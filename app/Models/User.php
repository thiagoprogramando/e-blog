<?php

namespace App\Models;

use Carbon\Carbon;
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable {
    
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'uuid',
        'company_token',
        'avatar',
        'name',
        'cpfcnpj',
        'bio',
        'email',
        'password',
        'role',
    ];

    public function invoices() {
        return $this->hasMany(Invoice::class);
    }

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }

    public function maskName() {
        
        if (empty($this->name)) {
            return '';
        }

        $nameParts = explode(' ', trim($this->name));

        if (count($nameParts) === 1) {
            return $nameParts[0];
        }

        return $nameParts[0] . ' ' . $nameParts[1];
    }

    public function hasActiveSubscription() {
       
        $invoice = $this->invoices()->where('payment_status', 'PAID')
                        ->whereHas('plan', function ($query) {
                            $query->whereIn('time', [
                                'monthly',
                                'semi-annual',
                                'yearly',
                                'lifetime',
                            ]);
                        })->latest('created_at')->first();

        if (!$invoice || !$invoice->plan) {
            return false;
        }

        $timeMap = [
            'monthly'      => 30,
            'semi-annual'  => 182,
            'yearly'       => 365,
            'lifetime'     => null,
        ];

        $time = $invoice->plan->time;
        if (!array_key_exists($time, $timeMap)) {
            return false;
        }

        if ($time === 'lifetime') {
            return true;
        }

        return now()->lessThanOrEqualTo(Carbon::parse($invoice->payment_date)->addDays($timeMap[$time]));
    }
}

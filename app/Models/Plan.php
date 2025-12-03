<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Plan extends Model {

    use SoftDeletes;

    protected $table = 'plans';
    
    protected $fillable = [
        'uuid', 
        'image',
        'title', 
        'caption',
        'description', 
        'value', 
        'status',
        'time',
        'views'
    ];

    public function invoices() {
        return $this->hasMany(Invoice::class, 'plan_id');
    }

    public function hasInvoice($user = null, $status = null): bool {
        
        $user   = $user ?? Auth::id();
        $status = $status ?? 1;
        return $this->invoices()
            ->where('user_id', $user)
            ->where('payment_status', $status)
            ->exists();
    }

    public function timeLabel() {
        switch ($this->time) {
            case 'free':
                return 'Gratuito';
            case 'monthly':
                return 'Mensal';
            case 'semi-annual':
                return 'Semestral';
            case 'yearly':
                return 'Anual';
            case 'lifetime':
                return 'Vitalício';
            default:
                return 'Gratuito';
        }
    }
}

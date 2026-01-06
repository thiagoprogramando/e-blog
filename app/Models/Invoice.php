<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model {
    
    use SoftDeletes;

    protected $table = 'invoices';

    protected $fillable = [
        'uuid',
        'user_id',
        'plan_id',
        'title',
        'description',
        'value',
        'payment_token',
        'payment_url',
        'payment_due_date',
        'payment_date',
        'payment_status',
        'payment_split',
    ];

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function plan() {
        return $this->belongsTo(Plan::class, 'plan_id');
    }

    public function statusLabel() {

        return match ($this->payment_status) {
            'PENDING'   => 'Pendente',
            'PAID'      => 'Pago',
            'OVERDUE'   => 'Atrasado',
            default     => '---',
        };
    }
}

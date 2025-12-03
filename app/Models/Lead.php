<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lead extends Model {

    use SoftDeletes;

    protected $table = 'leads';
    
    protected $fillable = [
        'uuid',
        'user_id',
        'company_id',
        'group_id',
        'name',
        'email',
        'phone',
        'type',
        'settings',
    ];

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function company() {
        return $this->belongsTo(User::class, 'company_id');
    }

    public function group() {
        return $this->belongsTo(Group::class, 'group_id');
    }

    public function typeLabel() {
        return match ($this->type) {
            'subscriber' => 'Assinante',
            'free'       => 'Gratuito',
            'guest'      => 'Convidado',
            default      => 'Desconhecido',
        };
    }

    public function maskPhone() {
        $phone = preg_replace('/\D/', '', $this->phone);
        if (strlen($phone) == 11) {
            return preg_replace('/(\d{2})(\d{5})(\d{4})/', '($1) $2-$3', $phone);
        } elseif (strlen($phone) == 10) {
            return preg_replace('/(\d{2})(\d{4})(\d{4})/', '($1) $2-$3', $phone);
        }
        return $this->phone;
    }
}

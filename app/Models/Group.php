<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Group extends Model {

    use SoftDeletes;

    protected $table = 'groups';
    
    protected $fillable = [
        'uuid',
        'user_id',
        'company_id',
        'title',
        'description',
        'value',
        'type',
        'settings',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function company() {
        return $this->belongsTo(User::class, 'company_id');
    }

    public function typeLabel() {
        return match ($this->type) {
            'free'      => 'Gratuito',
            'private'   => 'Privado',
            'signature' => 'Assinatura',
            default     => 'Desconhecido',
        };
    }
}

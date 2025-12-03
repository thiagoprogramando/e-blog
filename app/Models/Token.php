<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Token extends Model {

    protected $table = 'tokens';
    
    protected $fillable = [
        'token',
        'company_id',
        'title',
        'description',
        'url',
        'ip',
        'password',
    ];

    public function company() {
        return $this->belongsTo(User::class, 'company_id');
    }
}

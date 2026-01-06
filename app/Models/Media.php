<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Media extends Model {

    protected $table = 'medias';
    
    protected $fillable = [
        'uuid',
        'user_id',
        'company_id',
        'title',
        'file',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function company() {
        return $this->belongsTo(User::class, 'company_id');
    }
}

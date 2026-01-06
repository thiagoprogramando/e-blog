<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Letter extends Model {
    
    protected $table = 'newsletters';

    protected $fillable = [
        'uuid',
        'user_id',
        'company_id',
        'subject',
        'content',
        'attachments',
        'status',
        'scheduled_for',
    ];
}

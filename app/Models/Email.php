<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Crypt;

class Email extends Model {

    use SoftDeletes;
    
    protected $table = 'emails';

    protected $fillable = [
        'uuid',
        'user_id',
        'company_id',
        'title',
        'from_name',
        'from_email',
        'smtp_host',
        'smtp_port',
        'smtp_encryption',
        'smtp_username',
        'smtp_password',
        'is_default',
        'is_verified',
    ];

    public function setSmtpPasswordAttribute($value) {
        $this->attributes['smtp_password'] = Crypt::encryptString($value);
    }

    public function getSmtpPasswordAttribute($value) {
        return Crypt::decryptString($value);
    }
}

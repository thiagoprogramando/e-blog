<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Coupon extends Model {
    
    use SoftDeletes;

    protected $table = 'coupons';

    protected $fillable = [
        'uuid',
        'user_id',
        'code',
        'description',
        'discount_amount',
        'discount_percentage',
        'quantity',
        'status',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function statusLabel() {
        return $this->status ? 'Ativo' : 'Inativo';
    }

    public static function generateUniqueCode($length = 6) {

        $letters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $numbers = '0123456789';

        $code = '';
        for ($i = 0; $i < 3; $i++) {
            $code .= $letters[rand(0, strlen($letters) - 1)];
        }
        for ($i = 0; $i < 3; $i++) {
            $code .= $numbers[rand(0, strlen($numbers) - 1)];
        }

        if ($length > 6) {
            $all = $letters . $numbers;
            for ($i = 0; $i < $length - 6; $i++) {
                $code .= $all[rand(0, strlen($all) - 1)];
            }
        }

        return str_shuffle($code);
    }
}

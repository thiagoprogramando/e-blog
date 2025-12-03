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

    public function getFilePathAttribute() {
        return str_replace(asset('storage') . '/', '', $this->file);
    }

    public function getFileSizeAttribute() {
        if (!Storage::disk('public')->exists($this->file)) {
            return null;
        }

        $bytes = Storage::disk('public')->size($this->file);
        return number_format($bytes / 1048576, 2);
    }

    public function getFileTypeAttribute() {
        return Storage::disk('public')->exists($this->file_path)
            ? Storage::disk('public')->mimeType($this->file_path)
            : null;
    }
}

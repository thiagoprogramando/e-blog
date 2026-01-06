<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Post extends Model {

    use SoftDeletes;

    protected $table = 'posts';
    
    protected $fillable = [
        'uuid',
        'company_id',
        'created_by',
        'photo',
        'title',
        'body',
        'attachments',
        'tags',
        'status',
        'slug',
        'meta_title',
        'meta_description',
        'views',
        'likes',
        'published_at'
    ];

    public function setTitleAttribute($value) {

        $this->attributes['title'] = $value;
        if (empty($this->attributes['slug'])) {

            $baseSlug   = Str::slug($value);
            $exists     = static::withTrashed()
                                ->where('slug', $baseSlug)
                                ->exists();

            $this->attributes['slug'] = $exists ? "{$baseSlug}-" . $this->uuid : $baseSlug;
        }
    }

    public function statusLabel() {
        switch ($this->status) {
            case 'published':
                return 'Público';
            case 'draft':
                return 'Rascunho';
            case 'archived':
                return 'Arquivado';
            default:
                return '---';
        }
    }

    public function tagsLabel() {
        $tags = json_decode($this->tags, true) ?? $this->tags ?? [];
        $items = collect($tags)->map(function ($tag) {
            
            if (is_string($tag)) {
                return trim($tag);
            }

            if (is_array($tag)) {
                if (isset($tag['value'])) {
                    return trim($tag['value']);
                }
                if (isset($tag['name'])) {
                    return trim($tag['name']);
                }

                return trim(implode(' ', $tag));
            }
            return null;
        })->filter()->unique()->values()->toArray();

        if (empty($items)) {
            return 'Sem tags';
        }

        return implode(', ', $items);
    }

}

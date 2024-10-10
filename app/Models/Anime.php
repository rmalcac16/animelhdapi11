<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Anime extends Model
{

    protected $table = 'animes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $fillable = [
        'name',
        'name_alternative',
        'banner',
        'poster',
        'overview',
        'aired',
        'type',
        'status',
        'premiered',
        'broadcast',
        'genres',
        'rating',
        'popularity',
        'trailer',
        'vote_average',
        'slug_flv',
        'slug_tio',
        'slug_jk',
        'slug_monos',
        'slug_fenix',
        'prequel',
        'sequel',
        'related',
        'views',
        'views_app',
        'isTopic',
    ];

    public $timestamps = true;

    public static function boot()
    {
        parent::boot();

        static::saving(function ($anime) {
            if (empty($anime->slug)) {
                $anime->slug = static::generateUniqueSlug($anime->name);
            }
        });
    }

    public static function generateUniqueSlug($name)
    {
        $slug = Str::slug($name);
        $originalSlug = $slug;
        $counter = 2;
        while (static::where('slug', $slug)->exists()) {
            $slug = "{$originalSlug}-{$counter}"; 
            $counter++;
        }
        return $slug;
    }


    public function getAllAnimes()
    {
        return $this->orderBy('id', 'desc')->get();
    }

}

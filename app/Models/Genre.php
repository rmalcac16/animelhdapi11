<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    use HasFactory;

    protected $table = 'genres';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

     protected $fillable = [
        'name',
    ];

    public $timestamps = false;

    public static function boot()
    {
        parent::boot();

        static::saving(function ($genre) {
            if (empty($genre->slug)) {
                $genre->slug = static::generateUniqueSlug($genre->title);
            }
        });
    }

    public static function generateUniqueSlug($title)
    {
        $slug = Str::slug($title);
        $originalSlug = $slug;
        $counter = 2;
        while (static::where('slug', $slug)->exists()) {
            $slug = "{$originalSlug}-{$counter}"; 
            $counter++;
        }
        return $slug;
    }

}

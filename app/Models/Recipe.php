<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke ulasan
    public function reviews()
    {
        return $this->hasMany(Review::class)->latest();
    }

    // Relasi ke favorit
    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    // Helper untuk menghitung rata-rata rating
    public function averageRating()
    {
        return round($this->reviews()->avg('rating'), 1) ?: 0;
    }
}

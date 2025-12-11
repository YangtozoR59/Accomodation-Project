<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Accommodation extends Model
{
    //
    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'description',
        'price_per_night',
        'address',
        'quartier',
        'latitude',
        'longitude',
        'nb_rooms',
        'nb_beds',
        'nb_bathrooms',
        'max_guests',
        'is_available',
        'title',
        'category_id',
        'views_count',
        'is_available',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function images()
    {
        return $this->hasMany(Image::class);
    }
    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function scopeSearch($query, $term)
    {
        $term = '%' . $term . '%';
        $query->where(function ($q) use ($term) {
            $q->where('title', 'ILIKE', $term)
                ->orWhere('description', 'ILIKE', $term)
                ->orWhere('quartier', 'ILIKE', $term);
        });
    }
}

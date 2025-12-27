<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Accommodation extends Model
{
    use HasFactory;
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
        'views_count',
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


    public function scopeAvailable($query)
    {
        return $query->where('is_available', true);
    }

    /**
     * Scope : Hébergements vérifiés
     */
    public function scopeVerified($query)
    {
        return $query->where('is_verified', true);
    }

    /**
     * Accessor : Image principale
     */
    public function getPrimaryImageAttribute()
    {
        return $this->images()->where('is_primary', true)->first() 
            ?? $this->images()->first();
    }

    /**
     * Accessor : Note moyenne
     */
    public function getAverageRatingAttribute()
    {
        return $this->reviews()->avg('rating') ?? 0;
    }

    /**
     * Incrémenter le compteur de vues
     */
    public function incrementViews()
    {
        $this->increment('views_count');
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

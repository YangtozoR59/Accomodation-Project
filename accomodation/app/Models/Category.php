<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    //
     use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'icon',
    ];

    // Relations
    public function accommodations(): HasMany
    {
        return $this->hasMany(Accommodation::class);
    }

    // Helpers
    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}

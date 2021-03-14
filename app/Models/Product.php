<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Ryancco\HasUuidRouteKey\HasUuidRouteKey;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory, HasUuidRouteKey;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'price',
        'image'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'price' => 'float',
    ];

    /**
     * Get product categories
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'product_categories', 'product_id', 'category_id');
    }

     /**
     * Get product image as base64
     * 
     * @return string|null
     */
    public function getImageAttribute() : ?string
    {
        if(isset($this->attributes['image']) && Storage::disk('public')->exists($this->attributes['image']))
            return "data:image/png;base64," . base64_encode(Storage::disk('public')->get($this->attributes['image']));

        return null;
    }
}

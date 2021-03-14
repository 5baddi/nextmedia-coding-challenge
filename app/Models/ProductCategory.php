<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'product_categories';

    /**
     * Primary keys
     * 
     * @var array
     */
    protected $primaryKey = ['product_id', 'category_id'];

    /**
     * Disable auto incrementing
     * 
     * @var bool
     */
    public $incrementing = false;

    /**
     * Disable timestamps
     * 
     * @var bool
     */
    public $timestamps = false;

    /**
     * Get the product
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    /**
     * Get the category of this product
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}

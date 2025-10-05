<?php

namespace App\Models;

use App\Enums\CategoryProductsStatus;
use App\Enums\ProductStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Products extends Model
{
     use HasFactory;

    protected $table = 'products';
    protected $fillable = [
        'user_id',
        'name',
        'description',
        'status',
        'stock',
        'thumbnail_image',
        'main_image',
        'price',
        'city',
        'country',
        'currency',
        'showcase_images',
        'category'
    ];

    protected $casts = [
        'name' => 'string',
        'thumbnail_image' => 'string',
        'main_image' => 'string',
        'city' => 'string',
        'country' => 'string',
        'currency' => 'string',
        'description' => 'string',
        'stock' => 'integer',
        'category' => CategoryProductsStatus::class  ,
        'status' => ProductStatus::class  ,
         'price' => 'integer',      
        'showcase_images' => 'array'
    ];

    /**
     * Relasi ke User (Admin yang input)
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    
    public function order(): HasMany
    {
       return $this->hasMany(Orders::class, 'product_id');
    }


    public function whistlist(): HasMany
    {
       return $this->hasMany(Whishlist::class, 'product_id');
    }

 public function getPriceFormattedAttribute()
{

    if ($this->currency === 'IDR') {
        return number_format($this->price, 0, ',', '.');
    }
    
}

   
}

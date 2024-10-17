<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

class ParentProduct extends Model
{
    use HasFactory;
    protected $table = 'parent_products';
    protected $fields = [
        'categories_id',
        'name',
        'desc',
        'short_desc',
        'avatar',
        'rating',
    ];

    public function categories()
    {
        return $this->belongsTo(ProductCategory::class, 'categories_id');
    }
    public function products()
    {
        return $this->hasMany(Product::class, 'parent_id'); // 'parent_product_id' là khóa ngoại trong bảng products
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'parent_id'
    ];

    public function products()
	{
        return $this->hasMany(Product::class);
	}

    public function productCategories()
    {
        return $this->hasMany(ProductCategory::class);
    }

    public function childrenProductCategories()
    {
        return $this->hasMany(ProductCategory::class)->with('product_categories');
    }
}

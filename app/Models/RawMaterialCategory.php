<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RawMaterialCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'parent_id'
    ];

    public function rawMaterials()
	{
        return $this->hasMany(RawMaterial::class);
	}

    public function rawMaterialCategories()
    {
        return $this->hasMany(RawMaterialCategory::class);
    }

    public function childrenRawMaterialCategories()
    {
        return $this->hasMany(RawMaterialCategory::class)->with('raw_material_categories');
    }
}

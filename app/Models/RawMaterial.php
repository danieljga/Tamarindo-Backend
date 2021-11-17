<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RawMaterial extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'code',
        'description',
        'quantity',
        'unit',
        'raw_material_category_id'
    ];

    public function category()
    {
        return $this->belongsTo(RawMaterialCategory::class);
    }

    public function suppliers()
    {
        return $this->belongsToMany(Supplier::class, 'raw_material_supplier');
    }
}

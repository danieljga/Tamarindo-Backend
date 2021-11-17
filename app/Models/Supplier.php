<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'email',
        'phone',
        'address',
        'contact_name'
    ];

    public function rawMaterials()
    {
        return $this->belongsToMany(RawMaterial::class, 'raw_material_supplier');
    }
}

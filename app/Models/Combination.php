<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Combination extends Model
{
    protected $fillable = ['name'];

    public function variants()
    {
        return $this->belongsToMany(
            ProductVariant::class,
            'combination_variants',
            'combination_id',
            'product_variant_id',
        );
    }

    public function getCombinationValuesAttribute(){
        $combinationValues = $this->variants->pluck('value')->implode(', ');
        return $combinationValues;
    }
}

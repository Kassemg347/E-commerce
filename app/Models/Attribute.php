<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    protected $fillable = ['name', 'code'];

    public function attributeValues(){
        return $this->hasMany(AttributeValue::class);
    }
    public function sets(){
        return $this->belongsToMany(AttributeSet::class, 'attribute_set_attributes', 'attribute_id', 'attribute_set_id');
    }

    public function variantValue(){
        return $this->hasMany(VariantValue::class);
    }
}

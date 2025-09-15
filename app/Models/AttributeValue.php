<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttributeValue extends Model
{
    protected $fillable = ['attribbute_id','value'];

    public function attributes(){
        return $this->belongsTo(Attribute::class);
    }

    public function variantValue(){
        return $this->hasMany(VariantValue::class);
    }
}

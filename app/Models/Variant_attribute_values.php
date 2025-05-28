<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Variant_attribute_values extends Model
{
    protected $table = 'variant_attribute_values';

    protected $fillable = [
        'attribute_id',
        'value',
    ];

 public function variant_attribute()
    {
        return $this->belongsTo(Variant_attribute::class, 'attribute_id');
    }
}

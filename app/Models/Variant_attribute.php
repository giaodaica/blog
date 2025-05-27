<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Variant_attribute extends Model
{
    protected $table = 'variant_attributes'; // Khai báo tên bảng tương ứng

    protected $fillable = [
        'name',
    ];

    // Một thuộc tính có nhiều giá trị (values)
    public function values()
    {
        return $this->hasMany(Variant_attribute_values::class, 'attribute_id');
    }
}

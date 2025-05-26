<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Products extends Model
{
    use SoftDeletes;

    protected $table = 'products';

    protected $fillable = [
        'name',
        'dsc',
        'meta_title',
        'meta_dsc',
        'meta_keyword',
        'category_id',
        'status',
        'slug',
    ];
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Categories extends Model
{
    use SoftDeletes;

    protected $table = 'categories'; // nếu model tên Categories thì thêm dòng này

    protected $fillable = [
        'name',
        'image',
        'status',
    ];
}

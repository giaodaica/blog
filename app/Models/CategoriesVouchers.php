<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoriesVouchers extends Model
{
    //
    protected $table = 'categories_vouchers';
    public function vouchers(){
        return $this->hasMany(Vouchers::class,'category_id','id');
    }
}

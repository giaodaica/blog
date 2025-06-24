<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vouchers extends Model
{
    //
    use SoftDeletes;
    protected $table = 'vouchers';
    protected $fillable = ['code','type_discount','value','start_date','end_date','used','received','max_used','min_order_value','status','category_id','max_discount'];
    public function cate_vouchers(){
        return $this->belongsTo(CategoriesVouchers::class,'category_id','id');
    }
    public function users()
{
    return $this->belongsToMany(User::class, 'vouchers_users')
                ->withPivot('status', 'is_used', 'issued_date')
                ->withTimestamps();
}
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;
    protected $fillable=['code','type','value', 'minimum','status', 'seller_id'];

    public static function findByCode($code){
        return self::where('code',$code)->first();
    }
    
    public function discount($total){
        if($this->type=="fixed"){
            return $this->value;
        }
        elseif($this->type=="percent"){
            return ($this->value /100)*$total;
        }
        else{
            return 0;
        }
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_coupons');
    }

    public function userCoupon() {
        return $this->hasMany(UserCoupon::class);
    }

    public function brand() {
        return $this->belongsTo(SellerInfo::class, 'seller_id', 'seller_id');
    }
}

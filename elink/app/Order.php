<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //
    protected $fillable= ['voucher_no','item_id','user_id','buser_id','buyer_address','price','status'];
}

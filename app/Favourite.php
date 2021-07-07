<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Favourite extends Model
{
    //
    protected $fillable =['item_id','user_id'];

    public function item()
    {
    	return $this->belongsTo('App\Item');
    }

    public function user()
    {
    	return $this->belongsTo('App\User');
    }
}

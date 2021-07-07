<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    //
    protected $fillable = ['name','description','image','condition','price','location','user_id','category_id'];

    public function user()
	{
    	return $this->belongsTo('App\User');
	}

	public function favourites()
	{
		return $this->belongsToMany('App\Favourite');
	}
}

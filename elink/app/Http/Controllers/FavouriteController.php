<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Favourite;
use Auth;
use App\Category;

class FavouriteController extends Controller
{
    public function __construct($value='')
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $id = Auth::user()->id;
        $favourite = DB::table('favourites')
                ->where('favourites.user_id',$id)
                ->get()->count();
        $item = DB::table('items')
                ->where('items.user_id',$id)
                ->get()->count();
        return view('favourite.index',compact('favourite','item'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        //dd($request);
        $item_id=request('item_id');
        $user_id=Auth::user()->id;
        $favouritelist = DB::table('favourites')
                            ->where([['item_id','=',$item_id],['user_id','=',$user_id]])
                            ->get()->count();
        if ($favouritelist == 0) {
            Favourite::create([
                'item_id'=>$item_id,
                'user_id'=>$user_id,
            ]);
        return response($favouritelist);
        }
        else{
            $favouritelist = DB::table('favourites')
                            ->where([['item_id','=',$item_id],['user_id','=',$user_id]])
                            ->delete();
            return response($favouritelist);
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function favourite(Request $request){
        $favourites = DB::table('favourites')
                        ->join('items','items.id','=','favourites.item_id')
                        ->join('categories','categories.id','items.category_id')
                        ->select('items.*','favourites.user_id as fuser_id','categories.name as cname')
                        ->where('favourites.user_id','=',Auth::user()->id)
                        ->get();
        return response($favourites);
    }
}

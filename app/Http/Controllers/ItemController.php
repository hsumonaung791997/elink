<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Category;
use Auth;
use App\Item;
use App\Favourite;

class ItemController extends Controller
{
  public function __construct($value='')
    {
      $this->middleware('guest',['except' => ['index','store','show','destroy','create','itemcategory','postitems','postlist','getitems']]); 
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $prices = DB::table('items')
                    ->orderBy('items.price','asc')
                    ->get();
        $items = DB::table('items')
                    ->join('categories','categories.id','=','items.category_id')
                    ->join('favourites','favourites.item_id','=','items.id','left outer')
                    ->select('items.*','favourites.user_id as fuser_id','categories.name as cname')
                    ->orderBy('name','asc')
                    ->get();
        
        return view('item.index',compact('items','prices'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $items=Item::all();
        return view('item.create',compact('items'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
          $this->validate($request, [
                    'category' => 'required',
                    'condition' => 'required',
                    'name' => 'required|min:3|max:50',
                    'description' => 'required|min:10|max:191',
                    'image' => 'required|max:5000',
                    'image.*' => 'mimes:jpeg,jpg,png',
                    'category' => 'required',
                    'price'=> 'required',
                    'location'=> 'required',
                  ]);
        if($request->hasFile('image')){
            foreach ($request->file('image') as $image) {

                $name=$image->getClientOriginalName();
                $image->move(public_path().'/image/',$name);
                $data[]='/image/'.$name;
            }
           
        }
           /* dd($data);*/
        Item::create([
            "name"=>request('name'),
            "description"=>request('description'),
            "image"=>json_encode($data),
            "condition"=>request('condition'),
            "price"=>request('price'),
            "location"=>request('location'),
            "category_id"=>request('category'),
            "user_id"=>Auth::user()->id
        ]);
        session()->flash('message', 'Your Item was created!');
         return redirect()->route('item.index');
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$id)
    {
        //
        $find = Item::find($id);
        if($find){
        $detail = DB::table('items')
                    ->join('users','users.id','=','items.user_id')
                    ->join('favourites','favourites.item_id','=','items.id','left outer')
                    ->select('items.*','users.name as uname','favourites.user_id as fuser_id')
                    ->where('items.id',$id)
                    ->first();
                    // $detail = Item::find($id);
                    /*var_dump($detail);
                    die();*/
       return view('item.detail',compact('detail'));
     }
     else{
      return redirect()->back();
     }
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
    public function update(Request $request)
    {
        //
        if($request->hasFile('image')){
            $image=$request->file('image');
            $name=$image->getClientOriginalName();
            $image->move(public_path().'/image/',$name);
            $image='/image/'.$name;
        }else{
            $image=request('oldimg');
        }

        $item=Item::find($id);
        $item->name=request('name');
        $item->description=request('description');
        $item->image=$image;
        $item->condition=request('condition');
        $item->price=request('price');
        $item->location=request('location');
        $item->category_id=request('category');
        $item->user_id=Auth::user()->id;
        $item->save();

        return redirect()->route('item.show',$id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //
        $id = request('item_id');
        $item=Item::find($id);
        $item->delete();
        return redirect()->route('item.index');
    }

    public function postlist()
    {
        $id = Auth::user()->id;
        $favourite = DB::table('favourites')
                ->where('favourites.user_id',$id)
                ->get()->count();
        $item = DB::table('items')
                ->where('items.user_id',$id)
                ->get()->count();
        return view('item.mypostlist',compact('favourite','item'));
    }

    public function getitems(Request $request)
    {
        //dd($request);
        $id = request('id');
        $items = DB::table('items')
                        ->join('categories','categories.id','items.category_id')
                        ->join('favourites','favourites.item_id','=','items.id','left outer')
                        ->select('items.*','favourites.user_id as fuser_id','categories.name as cname')
                        ->orderBy('id','desc')
                        ->where('items.category_id',$id)
                        ->get();
                        //dd($items);
        return view('item.index',compact('items'));
    }

    public function postitems(Request $request)
    {
        $items = DB::table('items')
                  ->join('categories','categories.id','items.category_id')
                  ->where('items.user_id','=',Auth::user()->id)
                  ->select('items.*','categories.name as cname')
                  ->get();
        return response($items);
    }

    // public function search_items(Request $request)
    // {
    //     $search_data = request('search_data');
    //     $searchItems = DB::table('items')
    //                     ->join('favourites','favourites.item_id','=','items.id','left outer')
    //                     ->join('categories','categories.id','items.category_id')
    //                     ->select('items.*','favourites.user_id as fuser_id','categories.name as cname')
    //                     ->where('items.name','like', '%'.$search_data.'%')
    //                     ->orWhere('items.description','like', '%'.$search_data.'%')
    //                     ->get();
    //     return response($searchItems);
    // }


   public function itemcategory(Request $request)

    { 
        //dd($request);
        $category=request('category');
        $minprice=request('minprice');
        $maxprice= request('maxprice');
        if ($category == '') {
              $items = DB::table('items')
                    ->join('categories','categories.id','items.category_id')

                    ->join('favourites','favourites.item_id','=','items.id','left outer')

                    ->select('items.*','favourites.user_id as fuser_id','categories.name as cname')

                    ->where('items.price', '>=', $minprice)

                    ->where('items.price', '<=', $maxprice)

                    ->get();
              //dd($items);                
           return view('item.index',compact('items')); 
            }
        else{    
             $items = DB::table('items')
                    ->join('categories','categories.id','items.category_id')

                    ->join('favourites','favourites.item_id','=','items.id','left outer')

                    ->select('items.*','favourites.user_id as fuser_id','categories.name as cname')

                    ->orWhere('items.category_id',$category)

                    ->where('items.price', '>=', $minprice)

                    ->where('items.price', '<=', $maxprice)

                    ->get();
              //dd($items);                
           return view('item.index',compact('items')); 
         }
         

        }

}

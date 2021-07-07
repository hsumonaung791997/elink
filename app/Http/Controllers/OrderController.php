<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Routing\Redirect;
use Auth;
use App\Order;
use App\Item;
use App\User;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('order.orderlist');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
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
        // dd($request);
        $buser_id = request('buyer_id');
        $buyer_address = request('address');
        $item_id = request('item_id');
        $user_id = request('user_id');
        $voucher_no = Str::random(5);
        $price = request('price');
        //dd($buser_id . $buyer_address . $item_id .$voucher_no . $user_id);
        Order::create([
            "voucher_no"=> $voucher_no,
            "item_id"=> $item_id,
            "user_id"=> $user_id,
            "buser_id"=> $buser_id,
            "buyer_address"=> $buyer_address,
            "price"=> $price,
            "status"=> 0,
        ]);
        return response('Your Order is Successful');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
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

    public function order_detail(Request $request)
    {
        // dd($request);
        $id = request('item_id');
        $user_id = request('user_id');
        //dd($id . '+' . $user_id);
        $item = DB::table('items')
                ->where('items.id',$id)
                ->join('users','users.id','=','items.user_id')
                ->select('items.*','users.name as uname')
                ->first();
         //dd($item);
        return view('order.index',compact('item'));
    }

    public function getincommingorder(Request $request)
    {
        $incommingorders = DB::table('orders')
                        ->join('items','items.id','=','orders.item_id')
                        ->join('users','users.id','=','orders.buser_id')
                        ->select('orders.*','users.name as buyer_name','orders.buyer_address as buyer_address','users.phone as buyer_phone','items.name as item_name','items.image as item_image',)
                        ->where('orders.user_id','=',Auth::user()->id)
                        ->orderBy('orders.id','desc')
                        ->get();
        return response($incommingorders);
    }

    public function getoutgoingorder(Request $request){
        $outgoingorders = DB::table('orders')
                        ->join('items','items.id','=','orders.item_id')
                        ->join('users','users.id','=','orders.user_id')
                        ->select('orders.*','users.name as seller_name','users.phone as seller_phone','items.name as item_name','items.image as item_image',)
                        ->where('orders.buser_id','=',Auth::user()->id)
                        ->orderBy('orders.id','desc')
                        ->get();
        return response($outgoingorders);
    }

    public function confirmorder(Request $request){
        //dd($request);
        $id = request('id');
        $price = request('price');
        $newprice = $price-(($price*2)/100);
        $user_id = request('user_id');
        $buser_id = request('buser_id');
        $user = User::find($buser_id);
        if ($user->balance >= $price) {
            DB::table('orders')->where('id',$id)->increment('status', 1);
            DB::table('users')->where('id',$buser_id)->decrement('balance', $price);
            DB::table('users')->where('id',$user_id)->increment('balance', $newprice);
            return response('success');
        }
        else{
            DB::table('orders')->where('id',$id)->delete();
            return response('error');
        }
    }

    public function deleteorder(Request $request){
        $id = request('id');
        $order = Order::find($id);
        $order->delete();

        return response('success');
    }
}

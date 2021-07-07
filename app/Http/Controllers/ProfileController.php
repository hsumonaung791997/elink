<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Redirect;
use Illuminate\Http\RedirectResponse;
use App\Category;
use Auth;

class ProfileController extends Controller
{
  public function __construct($value='')
    {
        $this->middleware('isAdmin',['except'=>['edit','update']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        
    }
    

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      //dd($id);
      $authid = Auth::user()->id;
      if ($id == $authid) {
        $user=User::find($id);
        return view('profile.edit',compact('user'));
      }
      else{
        return redirect()->back();
      }
       
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
        //upload
        if($request->hasfile('avatar')){
        $image=$request->file('avatar');
        $name=$image->getClientOriginalName();
        $image->move(public_path().'/avatar/',$name);
        $avatar='/avatar/'.$name;
       }else{
        $avatar=request('oldimg');
       }
        //update
       $password = request('password');
       if ($password == '') {
         $user=User::find($id);
       $user->name=request('name');
       $user->email=request('email');
       $user->password=Auth::user()->password;
       $user->phone=request('phone');
       $user->avatar=$avatar;
       $user->save();
       }
       else{
       $user=User::find($id);
       $user->name=request('name');
       $user->email=request('email');
       $user->password=Hash::make(request('password'));
       $user->phone=request('phone');
       $user->avatar=$avatar;
       $user->save();
     }
       
       return redirect()->route('profile.edit',$id);
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

    public function getuser(Request $request)
    {
      $email = request('email');
      //dd($email);
      $user = DB::table('users')
              ->where('users.email',$email)
              ->first();
      if ($user == null) {
        return response()->json(['user'=>$user]);
      }
      else {
        return response()->json(['user'=>$user]);
      }
    }

    public function add_balance(Request $request)
    {
      $user_id = request('user_id');
      $balanceamount = request('balanceamount');
      //dd($balanceamount . $user_id);
      DB::table('users')->where('id',$user_id)->increment('balance', $balanceamount);
      $user = User::find($user_id);
      return response()->json(['user'=>$user]);
    }

    public function sub_balance(Request $request)
    {
      $user_id = request('user_id');
      $balanceamount = request('balanceamount');
      //dd($balanceamount . $user_id);
      DB::table('users')->where('id',$user_id)->decrement('balance', $balanceamount);
      $user = User::find($user_id);
      return response()->json(['nuser'=>$user]);
    }

    public function balance()
    {
       return view('profile.balance');
    }
}


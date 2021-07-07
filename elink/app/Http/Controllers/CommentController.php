<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;
use App\Item;
use Auth;
use Illuminate\Support\Facades\DB;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        //validation
        //dd($request);
        $request->validate([
            'comment'=> 'required',
            'item_id'=>'required'
        ]);

        //Data Insert
        Comment::create([

            'body'=>request('comment'),
            'item_id'=>request('item_id'),
            'user_id'=>Auth::user()->id
        ]);

        return response('success');
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
        $comment = Comment::find($id);
        //dd($post);
        return view('comment.edit',compact('comment'));
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
        $request->validate([
            'comment'=> 'required',
            'item_id'=>'required'
        ]);

        $id = request('comment_id');

        $comment = Comment::find($id);
        $item = Item::find($id);
        $comment->body = request('comment');
        $comment->item_id = request('item_id');
        $comment->user_id=Auth::user()->id;

        $comment->save();
        
        return response('success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //dd($request);
        $id=request('id');
        $comment= Comment::find($id);
        $comment-> delete();
        return response('success');
    }

    public function getcomments(Request $request)
    {
        //accet post_id from ajax request
        //dd(request('post_id'));
        $item_id = request('item_id');

        //$comments = Comment::where('post_id',$post_id)->get();
        $comments = DB::table('comments')
                    ->join('users','users.id','=','comments.user_id')
                    ->where('comments.item_id',$item_id)
                    ->orderBy('comments.id','desc')
                    ->select('comments.*','users.name','users.avatar')
                    ->get();
        $authid = Auth::user()->id;

        return response()->json([
            'comments'  => $comments,
            'authid'    => $authid,
        ]);
    }
}

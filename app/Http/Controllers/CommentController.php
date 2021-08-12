<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Auth;
use Response;

use App\Models\Comment;
use App\Models\Article;

class CommentController extends SiteController
{


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->except('_token', 'comment_post_ID', 'comment_parent' );
        $data['article_id'] = $request->comment_post_ID;
        $data['parent_id'] = empty($request->comment_parent) ? '0' : $request->comment_parent;

        $validator = Validator::make($data, [
            'article_id'=>'integer|required',
            'parent_id'=>'integer|required',
            'text'=>'string|required',

        ]);

        $validator->sometimes(['name', 'email'], 'required|max:255', function ($input) {

            return !Auth::check();

        });

        if ($validator->fails()) {
            return Response::json(['error'=>$validator->errors()->all()]);
        }

        $user = Auth::user();

        $comment = new Comment($data);
        if ($user) {
            $comment->user_id = $user->id;
        }

        $post = Article::find($data['article_id']);
        $post->comments()->save($comment);

        $comment->load('user');
        $data['id'] = $comment->id;

        $data['email'] = (!empty($data['email'])) ? $data['email'] : $comment->user->email;
        $data['name'] = (!empty($data['name'])) ? $data['name'] : $comment->user->name;

        $data['hash'] = md5($data['email']);

        $view_comment = view(config('settings.theme').'.comment.one_comment')->with('data', $data)->render();

        return Response::json(['success'=>true, 'comment'=>$view_comment, 'data'=>$data]);
        echo "<pre>";
        print_r($data);
        echo "</pre>";
        echo json_encode(['hello'=>'world']);
        exit();
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
}

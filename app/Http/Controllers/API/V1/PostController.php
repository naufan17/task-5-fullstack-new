<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Post;

class PostController extends Controller
{
    public function index()
    {
        $posts = auth()->user()->posts()->paginate(15);
    }
    
    public function show($id)
    {
        $post = auth()->user()->posts()->find($id);
    }
    
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'content' => 'required',
            'image' => 'required',
        ]);

        $post = new Post();
        $post->title = $request->title;
        $post->content = $request->content;
        $post->image = $request->image;
        $post->user_id = auth()->user()->id;
        $post->category_id = $request->category_id;

        auth()->user()->posts()->save($post)
    }
    
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'content' => 'required',
            'image' => 'required',
        ]);

        $post = auth()->user()->posts()->find($id);

        $post->fill($request->all())->save()
    }
    
    public function destroy($id)
    {
        $post = auth()->user()->posts()->find($id);

        $post->delete()
    }
}

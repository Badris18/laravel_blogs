<?php 

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index() {
        $posts = Post::latest()->paginate(6);
        return view('blog.index', compact('posts'));
    }

    public function show(Post $post) {
        $comments = $post->comments()->latest()->get();
        return view('blog.show', compact('post', 'comments'));
    }

    public function addComment(Request $request, Post $post) {
        $request->validate([
            'name' => 'required',
            'message' => 'required',
        ]);

        $comment = new Comment([
            'name' => $request->name,
            'message' => $request->message,
        ]);

        $post->comments()->save($comment);

        return response()->json([
            'message' => 'Comment added successfully!',
            'comment' => $comment
        ]);
    }
}
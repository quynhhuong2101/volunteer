<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;

class CommunityController extends Controller
{
    public function index()
    {
        $posts = Post::with(['user', 'reactions', 'comments'])->orderBy('created_at', 'desc')->paginate(15);
        return view('admin.community.index', compact('posts'));
    }

    public function show($id)
    {
        $post = Post::with(['user', 'reactions.user', 'comments.user'])->findOrFail($id);
        return view('admin.community.show', compact('post'));
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();

        return redirect()->route('admin.community.index')->with('success', 'Bài đăng đã được xóa.');
    }
}

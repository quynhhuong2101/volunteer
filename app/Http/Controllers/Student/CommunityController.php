<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\PostReaction;
use App\Models\PostComment;
use App\Models\CommentReaction;
class CommunityController extends Controller
{
    /**
     * Display a listing of community posts.
     */
    public function index()
    {
        $posts = Post::with(['user', 'reactions', 'comments.user'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('student.community.index', compact('posts'));
    }

    /**
     * Show the form for creating a new post.
     */
    public function create()
    {
        return view('student.community.create');
    }

    /**
     * Store a newly created post in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:idea,recruitment,announcement',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('posts', 'public');
        }

        Post::create([
            'user_id' => auth()->id(),
            'type' => $request->type,
            'title' => $request->title,
            'content' => $request->content,
            'image_url' => $imagePath,
            'status' => 'approved', // Auto approve or pending based on logic, let's assume approved for now
        ]);

        return redirect()->route('student.community.index')
            ->with('success', 'Bài đăng của bạn đã được xuất bản!');
    }

    /**
     * Display the specified post.
     */
    public function show($id)
    {
        $post = Post::with(['user', 'reactions', 'comments.user'])->findOrFail($id);
        return view('student.community.show', compact('post'));
    }

    /**
     * Like or Dislike a post.
     */
    public function react(Request $request, $id)
    {
        $request->validate([
            'type' => 'required|in:like,dislike'
        ]);

        $post = Post::findOrFail($id);
        $userId = auth()->id();

        $existingReaction = PostReaction::where('post_id', $post->id)
                                        ->where('user_id', $userId)
                                        ->first();

        if ($existingReaction) {
            if ($existingReaction->type === $request->type) {
                // Remove reaction if clicking the same one twice
                $existingReaction->delete();
                return response()->json(['status' => 'removed']);
            } else {
                // Change reaction
                $existingReaction->update(['type' => $request->type]);
                return response()->json(['status' => 'updated']);
            }
        }

        PostReaction::create([
            'post_id' => $post->id,
            'user_id' => $userId,
            'type' => $request->type,
        ]);

        return response()->json(['status' => 'added']);
    }

    /**
     * Add a comment to a post.
     */
    public function comment(Request $request, $id)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
            'parent_id' => 'nullable|exists:post_comments,id'
        ]);

        PostComment::create([
            'post_id' => $id,
            'user_id' => auth()->id(),
            'parent_id' => $request->parent_id,
            'content' => $request->content,
        ]);

        return redirect()->back()->with('success', 'Đã thêm bình luận.');
    }

    /**
     * Like or Dislike a comment.
     */
    public function reactComment(Request $request, $id)
    {
        $request->validate([
            'type' => 'required|in:like,dislike'
        ]);

        $comment = PostComment::findOrFail($id);
        $userId = auth()->id();

        $existingReaction = CommentReaction::where('post_comment_id', $comment->id)
                                        ->where('user_id', $userId)
                                        ->first();

        if ($existingReaction) {
            if ($existingReaction->type === $request->type) {
                $existingReaction->delete();
                return response()->json(['status' => 'removed']);
            } else {
                $existingReaction->update(['type' => $request->type]);
                return response()->json(['status' => 'updated']);
            }
        }

        CommentReaction::create([
            'post_comment_id' => $comment->id,
            'user_id' => $userId,
            'type' => $request->type,
        ]);

        return response()->json(['status' => 'added']);
    }
}

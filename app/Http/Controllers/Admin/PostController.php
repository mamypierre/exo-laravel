<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PostsRequest;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PostController extends Controller
{
    /**
     * Show the application posts index.
     */
    public function index(): View
    {
        return view('admin.posts.index', [
            'posts' => Post::with('author')->latest()->paginate(50)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $users = (Auth::user()->isAdmin()) ? User::authors()->pluck('fullName', 'id') : [Auth::user()->id => Auth::user()->fullName] ;
        return view('admin.posts.create', [
            'users' => $users,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostsRequest $request): RedirectResponse
    {

        $post = Post::create($request->only(['title', 'content', 'posted_at', 'author_id', 'slug']));

        return redirect()->route('admin.posts.index', $post)->withSuccess(__('posts.created'));
    }

}

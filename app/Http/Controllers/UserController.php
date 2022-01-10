<?php

namespace App\Http\Controllers;

use App\Http\Middleware\VerifyProfile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserController
{
    /**
     * Display the specified resource.
     */
    public function show(Request $request): View
    {
       $user = session()->get(VerifyProfile::USER_SLUG_VERIFY);
        return view('users.show', [
            'user' => $user,
//            'posts_count' => $user->posts()->count(),
//            'posts' => $user->posts()->latest()->limit(5)->get(),
        ]);
    }
}

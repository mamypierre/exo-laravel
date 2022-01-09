<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Support\Facades\Redirect;

/**
 * check if request email is a user and user valid
 */
class VerifiedUserByEmail
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $userEmail = $request->input('email');

        if (!$userEmail) {
            return $this->redirectTo(__('email missing'));
        }
        /** @var User $user */

        $user = User::select('email_verified_at')->firstWhere('email', $userEmail);

        if (!$user) {
            return $this->redirectTo(__('User not found'));
        }

        if (!$user) {
            return $this->redirectTo(__('User not found'));
        }

        if (!$user->hasVerifiedEmail()) {
            return $this->redirectTo(__('Please validate your account first, click on the link in your email '));
        }
        return $next($request);
    }

    private function redirectTo(string $message){
        return Redirect::back()->withErrors(['user_email' => $message]);
    }
}

<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;

class VerifyProfile
{
    const USER_SLUG_VERIFY = 'user_verify' ;
    protected $redirectPath = '/';
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $userName = $request->route('user');

        if (!$userName) {
            return $this->redirectTo(__('id missing'));
        }
        $user = User::where('user_name',$userName)->first();

        if (!$user) {
            return $this->redirectTo(__('User not found'));
        }
        /**
         * set session
         */
        session()->put(self::USER_SLUG_VERIFY, $user);

        return $next($request);
    }

    private function redirectTo(string $message){
        return redirect($this->redirectPath)->withErrors(['msg' => $message]);
    }
}

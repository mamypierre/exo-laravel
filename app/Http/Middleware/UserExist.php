<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;

class UserExist
{
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
        $userId = $request->route('id');

        if (!$userId) {
           return $this->redirectTo(__('id missing'));
        }
        $user = User::select('id')->find($userId);
        if (!$user) {
            return $this->redirectTo(__('User not found'));
        }
        return $next($request);
    }

    private function redirectTo(string $message){
       return redirect($this->redirectPath)->withErrors(['msg' => $message]);;
    }
}

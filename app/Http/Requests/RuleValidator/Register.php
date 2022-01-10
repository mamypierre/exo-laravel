<?php

namespace App\Http\Requests\RuleValidator;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

trait Register
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $userId = Auth::id();

        return [
            'last_name' => ['required', 'string', 'max:150'],
            'first_name' => ['nullable', 'string', 'max:150'],
            'user_name' => [
                'required', 'string', 'alpha_dash', 'max:30',
                Rule::unique('users')->ignore($userId),
            ],
            'email' => [
                'required', 'string', 'email', 'max:255',
                Rule::unique('users')->ignore($userId)
            ],
            'password' => [
                'required', 'string', 'min:8', 'confirmed',
                'Regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%@\.\^\&\*]).*$/'
            ],
        ];
    }
}

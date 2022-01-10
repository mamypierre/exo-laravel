<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\Request;
use App\Http\Requests\RuleValidator\Register;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class RegisterRequest extends Request
{

   use Register;

}

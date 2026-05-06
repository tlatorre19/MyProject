<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = '/home';

    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'role'       => ['required', 'in:student,instructor'],
            'name'       => ['required', 'string', 'max:255'],
            'student_id' => ['nullable', 'string', 'max:50'],
            'email'      => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password'   => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    protected function create(array $data)
    {
        return User::create([
            'role'       => $data['role'],
            'name'       => $data['name'],
            'student_id' => $data['student_id'] ?? null,
            'email'      => $data['email'],
            'password'   => Hash::make($data['password']),
        ]);
    }
}
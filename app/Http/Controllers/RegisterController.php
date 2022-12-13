<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Token;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class RegisterController extends Controller
{
    public function create()
    {
        return view('register.create');
    }

    public function store()
    {

        // var_dump(request()->all());
        $attributes = request()->validate([
            'username' => 'required|min:3|max:255|unique:users,username',
            'email' => 'required|email|max:255|unique:users,email',
            'password1' => ['required', 'same:password2', 'min:6', 'max:255']
        ], [
            'username.required' => 'The field "Username" must be filled.',
            'username.min' => '"Username" must be at least 3 characters.',
            'username.max' => '"Username" cannot exceed 255 characters.',
            'username.unique' => '"Username" has already been taken.',
            'email.max' => '"Email" cannot exceed 255 characters.',
            'email.required' => 'The field "Email" must be filled.',
            'email.unique' => '"Email" has already been registered.',
            'password1.required' => 'The field "Password" must be filled.',
            'password1.min' => '"Password" must be at least 6 characters.',
            'password1.max' => '"Password" cannot exceed 255 characters.',
            'password1.same' => 'The entered Passwords do not match.'
        ]);
        // dd("ssuusscke");

        $user = User::create([
            'username' => $attributes['username'],
            'email' => $attributes['email'],
            'password' => bcrypt($attributes['password1'])
        ]);

        auth()->login($user);

        // return var_dump(session()->get('_token'));

        // Redirect back to main page on Website 1
        return redirect('/')->with('success', 'Your account has been created');

        // Redirect to Website 2

        // return redirect('http://localhost:8080/login')
        //     ->header('one_key', $data['one_key'])
        //     ->header('app1_id', $data['app1_id']);
    }
}

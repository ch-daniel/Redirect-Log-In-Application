<?php

namespace App\Http\Controllers;

use App\Models\Token;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SessionController extends Controller
{
    public function create()
    {
        return view('login');
    }

    public function store()
    {
        function generateRandomString($length = 10) {
            return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
        }

        $attributes = request()->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (auth()->attempt($attributes)) {
            // return var_dump(session()->get('_token'));

            // Redirect back to main page on Website 1
            return redirect("/");

            // Redirect to Website 2

            // return redirect('http://localhost:8080/login')
            // ->header('one_key', $data['one_key'])
            // ->header('app1_id', $data['app1_id']);
        }

        return back()->withErrors(['email' => 'Your provided credentials could not be verified.']);

    }

    public function exit()
    {
        function generateRandomString($length = 10) {
            return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
        }

        $data = [
            'app1_id' => auth()->user()->id,
            'session_key' => session()->get('_token'),
            'one_key' => bcrypt(generateRandomString(32))
        ];

        $s = Token::where('app1_id', '=', $data['app1_id'])->first();
        // return var_dump($s);
        if ( $s == NULL) {
            // return var_dump("option1");
            $s = Token::create($data);
            
        } else {
            // return var_dump("option2");
            $s->app1_id = $data['app1_id'];
            $s->session_key = $data['session_key'];
            $s->one_key = $data['one_key'];
            $s->save();
            
        }

        $key = env('API_CONFIDENCE_KEY');

        $response = Http::patch('http://localhost:8080/api/update/sessions', [
            'key' => $key,
            'data' => json_encode($data)
        ]);

        // return redirect('http://localhost:8080/login')
        //     ->header('one_key', $data['one_key'])
        //     ->header('app1_id', $data['app1_id']);
        // return redirect('http://localhost:8080/login', 302, [
        //     'one_key' => $data['one_key'],
        //     'app1_id' => $data['app1_id']
        // ]);
        return redirect('http://localhost:8080/login'."?one_key=".$data['one_key']."&app1_id=".$data['app1_id']);
    }

    public function destroy()
    {
        auth()->logout();
        return redirect('/login')->with('success', 'Goodbye!');
    }


}

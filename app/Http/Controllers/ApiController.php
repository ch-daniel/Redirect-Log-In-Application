<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Token;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    
    public function verify_token(Request $request)
    {
        //return response()->json(User::all());
        $key = $request->key;
        $session_key = $request->session_key;

        if ($key == env('API_CONFIDENCE_KEY')) {
            // return response()->json(User::all());
            $s = Token::where('session_key', '=', $session_key)->first();
            if ( $s == NULL) {
                // User is not meant to log in. Redirect to login page.
                return redirect('http://localhost:8000/login');
                
            } else {
                $s->one_key = NULL;
                $s->save();
                return true;
            }
        } else abort(403);
        
    }

    public function verify_user(Request $request)
    {
        
        //return response()->json(User::all());
        $key = $request->key;
        $session_key = $request->session_key;
        $app1_id = $request->app1_id;

        if ($key == env('API_CONFIDENCE_KEY')) {
            // Get Current session model
            
            $s = Token::where('app1_id', '=', $app1_id)->first();
            
            // Check if session exists
            if ( $s == NULL) {
                abort(403);
            }
            
            // Check if Session keys match
            if ( $s->session_key == $session_key) {
                // Get current User Model
                $user = User::find($s->app1_id);
                $s->one_key = NULL;
                $s->save();

                return $user;
            } else abort(403);

            

            

            
        } else abort(403);
        
    }
}

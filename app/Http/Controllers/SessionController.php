<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Sessions;
use App\Models\User;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SessionController extends Controller
{
    public function create(Request $request)
    {
        if (!isset($_GET["one_key"]) or !isset($_GET["app1_id"])) {
            return redirect('http://localhost:8000/login');
        }

        $one_key = $_GET["one_key"];
        $app1_id = $_GET["app1_id"];

        //verify that user is Meant to be logged in

        $s = Sessions::where('app1_id', '=', $app1_id)->first();

        // return var_dump($s);
        if ( $s == NULL) {
            // User is not meant to log in. Redirect to login page.
            return redirect('http://localhost:8000/login');
            
        } else {
            // User has been found in the list
            
            // Check if One Time Code is valid
            if ($s->one_key != $one_key) {
                // One Key does not coincide. Redirect to login page.
                return redirect('http://localhost:8000/login');
            } elseif ($s->one_key == $one_key) {
                // Key Coincides
                
                // Check if Session Keys match with Website 1
                
                $response = Http::patch('http://localhost:8000/api/session/user', [
                    'key' => env('API_CONFIDENCE_KEY'),
                    'session_key' => $s->session_key,
                    'app1_id' => $app1_id
                ]);
                // dd($response->json('username'));

                if ($response->status() == 403) {
                    //Failed Session Keys authentication
                    return redirect('http://localhost:8000/login');
                }
                if ($response->status() == 200) {
                    
                    //Success Session Key authentication
                    if ($response->body() == true) {
                        // dd("aaa");
                        //Register or log user in
                        $user = User::where('app1_id', '=', $response->json('id'))->first();
                        if ( $user == NULL) {
                            $user = User::create([
                                'app1_id' => $response->json('id'),
                                'username' => $response->json('username'),
                                'coins' => 0
                            ]);

                            //Claim daily bonus
                            $tr = Transaction::create([
                                'user_id' => $user->id,
                                'amount' => 1000,
                                'type' => 0
                            ]);
                            $user->coins = $user->coins + 1000;
                            $user->last_log = Carbon::now()->timezone('UTC');
                            $user->save();
                        }
                        $s->one_key = NULL;
                        $s->save();

                        // Log the user in

                        auth()->login($user);

                        // See if elegible for daily bonus

                        $timestamp = $user->last_log;
                        $date = Carbon::createFromFormat('Y-m-d H:i:s', $timestamp);

                        if (!$date->isToday()) {
                            //Claim daily bonus
                            $tr = Transaction::create([
                                'user_id' => $user->id,
                                'amount' => 1000,
                                'type' => 0
                            ]);
                            $user->coins = $user->coins + 1000;
                            $user->last_log = Carbon::now()->timezone('UTC');
                            $user->save();
                        }

                        return redirect('/')->with('success', 'Success! You have logged in.');

                    }
                }

            }
            $s->app1_id = $data['app1_id'];
            $s->session_key = $data['session_key'];
            $s->one_key = $data['one_key'];
            $s->save();
            
        }

        auth()->login($user);

        dd($_GET["one_key"]);

        return redirect('/')->with('success', 'Hello!');
    }

    public function destroy()
    {
        auth()->logout();
        return redirect('http://localhost:8000/login')->with('success', 'Goodbye!');
    }
}

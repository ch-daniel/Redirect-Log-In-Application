<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AdminController extends Controller
{
    public function create()
    {
        // dd("here");
        $key = env('API_CONFIDENCE_KEY');
        
        $response = Http::get('http://127.0.0.1:8080/api/users', [
            'key' => $key
        ]);

        // return $response;
        
        return view('dashboard', [
            'users' => json_decode($response)
        ]);
    }

    public function update()
    {
        $key = env('API_CONFIDENCE_KEY');

        $data = request();
        if ($data['coins'] == NULL) {
            return redirect('/dashboard');
        }
        // $data = request()->validate([
        //     'coins' => 'digits:8'
        // ], [
        //     'coins.digits' => 'The number of coins is too big.'
        // ]);
        $array = [];
        foreach($data['coins'] as $id=>$value){
            error_log($value);
            array_push($array, [$id, $value]);
        }

        // return $data;

        // return json_decode($data);

        $response = Http::patch('http://localhost:8080/api/update/coins', [
            'key' => $key,
            'data' => json_encode($array)
        ]);

        // error_log('Some message here.');

        // return $response->status();

        // return json_decode($response);

        // return $response;

        if ($response->status() == 201) {
            foreach($data['coins'] as $id=>$value){
                error_log($value);
                if (intval($value) > intval($response->body())) {
                    return redirect('/dashboard')->with('coins'.strval($id), 'Selected coin value higher than maximum (100,000,000)');
                }
                array_push($array, [$id, $value]);
            }
        }

        return view('dashboard', [
            'users' => json_decode($response),
            'success' => 'Values have been saved!'
        ]);
 
        
        
    }

}

<?php


namespace App\Http\Controllers;
use App\Models\Transaction;
use App\Models\Sessions;
use App\Models\User;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function send_users(Request $request)
    {
        //return response()->json(User::all());
        $key = $request->key;

        if ($key == env('API_CONFIDENCE_KEY')) {
            // return response()->json(User::all());
            return User::all()->toArray();
        } else abort(403);
        
    }
    public function update_coins(Request $request)
    {

        

        $key = $request->key;

        $table = $request->data;
        error_log($request->data);
        $table = json_decode($table, true);
        
        
        // foreach($table as $row){
        //     $user = User::find($row[0]);
        //     $user->coins = intval($row[1]);
        //     $user->save();
        // }
        // return User::all()->toArray();

        

        // $table = '{"_token":"tmunch6FzzF7GxDjBzJ54VQRVduWvE0D7OO4mK30","coins":{"1":"35003","2":"23333"}}';
        

        if ($key == env('API_CONFIDENCE_KEY')) {
            foreach($table as $row){
                $user = User::find($row[0]);
                if ($row[1] < 100000000) {
                    if ($user->coins != intval($row[1])) {
                        $difference = intval($row[1]) - $user->coins;
                        $user->coins = intval($row[1]);

                        //Save Transaction
                        $tr = Transaction::create([
                            'user_id' => $row[0],
                            'amount' => $difference,
                            'type' => 4
                        ]);
                    }
                    
                } else {
                    return response('100000000', 201);
                }
                $user->save();
            }
            return User::all()->toArray();
        } else abort(403);
        
    }
    public function update_sessions(Request $request)
    {

        

        $key = $request->key;

        $table = $request->data;
        error_log($request->data);
        $data = json_decode($table, true);

        if ($key == env('API_CONFIDENCE_KEY')) {
            $s = Sessions::where('app1_id', '=', $data['app1_id'])->first();
            // return var_dump($s);
            if ( $s == NULL) {
                // return var_dump("option1");
                $s = Sessions::create($data);
                
            } else {
                // return var_dump("option2");
                $s->app1_id = $data['app1_id'];
                $s->session_key = $data['session_key'];
                $s->one_key = $data['one_key'];
                $s->save();
                
            }
        } else abort(403);
        
        
    }
    public function timezone(Request $request)
    {        
        return date_default_timezone_get();
    }
}

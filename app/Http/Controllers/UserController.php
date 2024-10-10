<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index(){
        $users = User::orderBy('updated_at','DESC')    
            ->orderBy('disable')        
            ->paginate(1);        

        $data = [
            'users'=>$users,            
        ];
        return view('users.index',$data);
    }

    public function change_user(User $user){
        $att['disable'] = ($user->disable)?null:1;   
        $user->update($att);
        
        return back();
    }

    public function add_user_power(User $user,$power){
        if($power=="admin") $att['admin'] = 1;
        if($power=="review") $att['review'] = 1;        
        $user->update($att);
        return back();
    }
    public function remove_user_power(User $user,$power){
        if($power=="admin") $att['admin'] = null;
        if($power=="review") $att['review'] = null;        
        $user->update($att);
        return back();
    }
    public function create(){
        return view('users.create');
    }
    public function store(Request $request){        
        $att = $request->all();
        if($att['password1'] != $att['password2']){
            return back()->withErrors(['errors' => ['兩次密碼不一致！']]);;
        }
        if($att['power']=="review") $att['review'] = 1;
        if($att['power']=="admin") $att['admin'] = 1;
        $att['password'] = bcrypt($request->input('password1'));                

        User::create($att);
        return redirect()->route('user.index');
    }
}

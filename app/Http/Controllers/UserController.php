<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index(){
        $users = User::orderBy('login_type','DESC')
            ->orderBy('disable')
            ->orderBy('updated_at','DESC') 
            ->paginate(20);        

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
            return back()->withErrors(['errors' => ['兩次密碼不一致！']]);
        }

        $check = User::where('username',$att['username'])->first();
        if(!empty($check->id)){
            return back()->withErrors(['errors' => ['此帳號有人使用了！']]);
        }

        if($att['power']=="review") $att['review'] = 1;
        if($att['power']=="admin") $att['admin'] = 1;
        $att['password'] = bcrypt($request->input('password1'));                

        User::create($att);
        return redirect()->route('user.index');
    }
    public function search(Request $request){
        $request->validate([
            'want' => 'required',            
        ]);
        $want = $request->input('want');
        $users = User::where('school_code', 'like', "%" . $want . "%")
        ->orWhere('school_name', 'like', "%" . $want . "%")
        ->orWhere('title', 'like', "%" . $want . "%")
        ->orWhere('username', 'like', "%" . $want . "%")
        ->orWhere('name', 'like', "%" . $want . "%")
        ->get();
        $data = [
            'users'=>$users,    
            'want'=>$want,
        ];
        return view('users.search',$data);
    }

    public function password_reset(User $user)
    {
        $att['password'] = bcrypt('demo1234');        
        $user->update($att);
        return back();
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;

class UsersController extends Controller
{
	public function save(Request $request, User $user){
		$user->update(['name'=>$request->name, 'password'=>bcrypt($request->password)]);
		return redirect()->route('home');  
	}  

	public function home(){
		return view('home');
	}

	public function info()
    {
        $user = Auth::user();
        return  redirect()->route('user.topics',['mobile' => $user->mobile]);
    }

    public function showTopics()
    {
        $user = Auth::user();
        $topics = $user ->topics;
        return view('users.topics', compact('topics', 'user'));
    }

    public function showComments()
    {
        $user = Auth::user();
        $comments = $user ->comments;
        return view('users.comments', compact('comments', 'user'));
    }

    public function edit()
    {
        $user = Auth::user();
        return view('users.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $user->name = $request->name;
        $user->save();
        return  redirect()->route('user.edit', $user->mobile);
    }
}

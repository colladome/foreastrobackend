<?php

namespace App\Http\Controllers;

use App\Models\User;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {

        $users = User::where('user_type', 'user')->orderBy('id','desc')->get();

        return view('backend.user.index', compact('users'));
    }



    public function delete($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return back()->with('success', 'User delete successfully!');
    }


    public function active($id)
    {
        $user = User::findOrFail($id);
        $user->status = '1';
        $user->save();

        return back()->with('success', 'user unblock successfully!');
    }

    public function inActive($id)
    {
        $user = User::findOrFail($id);
        $user->status = '0';
        $user->save();
        return back()->with('success', 'user block successfully!');
    }
}

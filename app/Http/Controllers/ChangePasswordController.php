<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ChangePasswordController extends Controller
{
    public function showChangePasswordForm()
    {
        $user=User::all();

        return view('auth.change-password',compact('user'));
    }

    public function changePassword(Request $request)
    {
         
        $user = Auth::user();

         
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|confirmed',
        ]);
 
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Mật khẩu cũ không đúng.']);
        }
        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        return redirect('/login')->with('error','Mời đăng nhập lại');
    }
}

<?php

namespace App\Http\Controllers;
use Str;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\UserVerification;
use App\Mail\UserVerificationMail;
use Exception;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

    public function postLogin(Request $request){
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return view('dashboard');
        } else {
            return redirect()->back()->with('error', 'Email hoặc mật khẩu không đúng.');
        }
    }
    public function logout(Request $request)
    {
      
        return redirect('/login');
    }

    public function showRegisterForm()
    {
        return view('register');
    }
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|confirmed',  
                'phone' => 'nullable|string|max:15',
                'birthdate' => 'nullable|date',
                'gender' => 'nullable|string|in:male,female,other',
        ]);

        if ($validator->fails()) {
            return redirect('/register')
                        ->withErrors($validator)
                        ->withInput();
        }
        $user = User::create([
            'name' => $request->name,   
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'birthdate' => $request->birthdate,
            'gender' => $request->gender,
            'verify_token' => Str::random(32), 
        ]);
    
        
         Mail::to($user->email)->send(new UserVerificationMail($user, $user->verify_token));
        return view('emails.a');
    }
    public function verifyEmail()
    {
        return view('verify-user');
    }
   public function home() {
    return view('dashboard');
   }
    
}

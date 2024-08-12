<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\UserVerificationMail;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
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

    public function postLogin(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
           
            $request->session()->regenerate();

            return redirect()->route('home');
        } else {
           
            return redirect()->back()->with('error', 'Email hoặc mật khẩu không đúng.');
        }
    }

    public function logout()
    {
            Auth::logout();
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
        $user->assignRole('customer');
        Mail::to($user->email)->send(new UserVerificationMail($user, $user->verify_token));

        return view('emails.a');
    }

    public function verifyEmail($token)
    {
        $user = User::where('verify_token', $token)->firstOrFail();
        $user->email_verified_at = now();
        $user->verify_token = null;
        $user->save();

        return redirect('/login')->with('status', 'Email của bạn đã được xác minh. Bạn có thể đăng nhập.');
    }

    public function home( )
    {
        $products = Product::with('colors')->paginate(12); 
        $user = Auth::user(); 
        $products->getCollection()->transform(function ($product) {
                $product->review_count = DB::table('reviews')
                ->where('product_id', $product->id)
                ->count();

            $product->average_rating = DB::table('reviews')
                ->where('product_id', $product->id)
                ->avg('rating');

            return $product;
        });
        return view('dashboard', compact('products', 'user'));
        
    }
}

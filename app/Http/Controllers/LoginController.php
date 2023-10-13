<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class LoginController extends Controller
{
    public function index()
    {
        return view('login.index', [
            'title' => 'Login'
        ]);
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if(Auth::attempt($credentials))
        {
            $request->session()->regenerate();
            return redirect()->intended('/');
        }

        return back()->with('fail', 'Login failed. make sure you have the correct email and/or password!');
    }

    // public function authenticate(Request $request)
    // {
    //     $credentials = $request->validate([
    //         'email' => 'required|email',
    //         'password' => 'required'
    //     ]);
    
    //     $cipher = "AES-128-ECB";
    //     $secret = "fadhlanganteng123";
    
    //     // Encrypt the form input before comparing
    //     foreach ($credentials as $key => $value) {
    //         if($key !== 'email' && $key !== 'password') {
    //             $credentials[$key] = openssl_encrypt($value, $cipher, $secret);
    //         }
    //     }

    //     // Hash the password using bcrypt
    //     $credentials['password'] = bcrypt($credentials['password']);
    
    //     if(Auth::attempt($credentials))
    //     {
    //         $request->session()->regenerate();
    //         return redirect()->intended('/');
    //     }
    
    //     return back()->with('fail', 'Login failed. make sure you have the correct email and/or password!');
    // }

    // public function authenticate(Request $request)
    // {
    //     $credentials = $request->validate([
    //         'email' => 'required|email',
    //         'password' => 'required'
    //     ]);
    
    //     $cipher = "AES-128-ECB";
    //     $secret = "fadhlanganteng123";
    
    //     // Encrypt the form input before comparing
    //     foreach ($credentials as $key => $value) {
    //         if($key !== 'email' && $key !== 'password') {
    //             $credentials[$key] = openssl_encrypt($value, $cipher, $secret);
    //         }
    //     }

    //     // Hash the password using bcrypt
    //     $credentials['password'] = bcrypt($credentials['password']);
    
    //     if(Auth::attempt($credentials))
    //     {
    //         $request->session()->regenerate();
    //         return redirect()->intended('/');
    //     }
    
    //     return back()->with('fail', 'Login failed. make sure you have the correct email and/or password!');
    // }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
    
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/');
        }
    
        return back()->with('fail', 'Login failed. Make sure you have the correct email and/or password!');
    }


// public function authenticate(Request $request)
// {
//     $credentials = $request->validate([
//         'email' => 'required|email',
//         'password' => 'required'
//     ]);

//     if (Auth::attempt($credentials)) {
//         $request->session()->regenerate();
//         return redirect()->intended('/');
//     }

//     return back()->with('fail', 'Login failed. Make sure you have the correct email and/or password!');
// }




//     public function authenticate(Request $request)
// {
//     $credentials = $request->validate([
//         'email' => 'required|email',
//         'password' => 'required'
//     ]);

//     // Get the user by email
//     $user = User::where('email', Crypt::encryptString($credentials['email']))->first();

//     if ($user && Hash::check($credentials['password'], $user->password)) {
//         // Authentication passed...
//         Auth::login($user);
//         $request->session()->regenerate();
//         return redirect()->intended('/');
//     }

//     return back()->withErrors([
//         'email' => 'The provided credentials do not match our records.',
//     ]);
// }
    public function logout()
    {
        Auth::logout();

        request()->session()->invalidate();
        request()->session()->regenerateToken();
        
        return redirect('/animals');
    }
}

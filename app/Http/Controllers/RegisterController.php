<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Crypt;

class RegisterController extends Controller
{
    public function index()
    {
        return view('register.index', [
            'title' => 'Register',
        ]);
    }

    // public function store(Request $request)
    // {
    //     $validatedData = $request->validate([
    //         'name' => 'required|max:225',
    //         'username' => 'required|min:5|max:20|unique:users',
    //         'email' => 'required|email|unique:users',
    //         'password' => 'required|min:5|max:255'
    //     ]);

    //     $validatedData['password'] = bcrypt($validatedData['password']);
        
    //     User::create($validatedData);

    //     return redirect('/login')->with('success', 'Registration Success!');
    // }

    public function store(Request $request)
{
    $validatedData = $request->validate([
        'name' => 'required|max:225',
        'username' => 'required|min:5|max:20|unique:users',
        'email' => 'required|email|unique:users',
        'password' => 'required|min:5|max:255'
    ]);

    $cipher = "AES-128-ECB";
    $secret = "fadhlanganteng123";
    
    $validatedData['password'] = bcrypt($validatedData['password']);

    // Encrypt the data before storing
    foreach ($validatedData as $key => $value) {
        if ($key != 'password' && $key != 'email') { // We don't need to encrypt the password as it's already hashed
            $validatedData[$key] = openssl_encrypt($value, $cipher, $secret);
        }
    }

    User::create($validatedData);

    return redirect('/login')->with('success', 'Registration Success!');
}

// public function store(Request $request)
// {
//     $validatedData = $request->validate([
//         'name' => 'required|max:225',
//         'username' => 'required|min:5|max:20|unique:users',
//         'email' => 'required|email|unique:users',
//         'password' => 'required|min:5|max:255'
//     ]);

//     User::create([
//         'name' => $validatedData['name'],
//         'username' => $validatedData['username'],
//         'email' => $validatedData['email'],
//         'password' => bcrypt($validatedData['password']), // Use bcrypt to securely hash the password
//     ]);

//     return redirect('/login')->with('success', 'Registration Success!');
// }

}

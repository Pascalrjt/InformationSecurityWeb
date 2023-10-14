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

    public function imageToBase64($imagePath) {
        try {
            $imageData = file_get_contents($imagePath);
            if ($imageData === false) {
                throw new Exception("Failed to read the image file.");
            }
            
            $base64Encoded = base64_encode($imageData);
            return $base64Encoded;
        } catch (Exception $e) {
            echo "An error occurred: " . $e->getMessage();
            return null;
        }
    }

//     public function store(Request $request)
// {
//     $validatedData = $request->validate([
//         'name' => 'required|max:225',
//         'username' => 'required|min:5|max:20|unique:users',
//         'email' => 'required|email|unique:users',
//         'password' => 'required|min:5|max:255',
//         'image' => 'mimes:jpeg,bmp,png|file|max:2048' // Ensure the uploaded file is an image
//     ]);

//     $image = $request->file('image');
//     if ($image) {
//         $imageBase64 = base64_encode(file_get_contents($image));
//     } else {
//         $imageBase64 = null; // or any default value you want to use
//     }
//     //$imageBase64 = base64_encode(file_get_contents($image));

//     $cipher = "AES-128-ECB";
//     $secret = "fadhlanganteng12";
    
//     $validatedData['password'] = bcrypt($validatedData['password']);

//     // Encrypt the data before storing
//     foreach ($validatedData as $key => $value) {
//         if ($key != 'password' && $key != 'email' && $key != 'image') { // We don't need to encrypt the password as it's already hashed
//             $validatedData[$key] = openssl_encrypt($value, $cipher, $secret);
//         }
//     }

//     User::create($validatedData);
    

//     return redirect('/login')->with('success', 'Registration Success!');
// }

public function store(Request $request)
{
    $request->validate([
        'name' => 'required|max:225',
        'username' => 'required|min:5|max:20|unique:users',
        'email' => 'required|email|unique:users',
        'password' => 'required|min:5|max:255',
        'image' => 'image|file|max:2048' // Ensure the uploaded file is an image
    ]);

    $image = $request->file('image');
    if ($image) {
        $imageBase64 = base64_encode(file_get_contents($image));
    } else {
        $imageBase64 = null; // or any default value you want to use
    }

    $cipher = "AES-128-ECB";
    $secret = "fadhlanganteng12";

    $name = openssl_encrypt($request->name, $cipher, $secret);
    $username = openssl_encrypt($request->username, $cipher, $secret);

    User::create([
        'name' => $name,
        'username' => $username,
        'email' => $request->email,
        'password' => bcrypt($request->password),
        'image' => $imageBase64
    ]);

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

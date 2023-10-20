<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Encryption\Encryption;
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

    //Ciphers
    $cipher = "AES-256-CBC";
    $rc4 = "rc4";
    $des = "DES-ECB";

    function generateAESKey(){
        return bin2hex(openssl_random_pseudo_bytes(16));
    }

    // $secret = "12345678901234567890123456789012";

    $secret1 = generateAESKey();




    $rc4key = "2B7E151628AED2A6ABF7158809CF4F3C";
    $deskey = "133457799BBCDFF1A";

    //Iv
    $options = 0;
    $iv = str_repeat("0", openssl_cipher_iv_length($cipher));

    //User profile encryption
    $name = openssl_encrypt($request->name, $cipher, $secret1, $options, $iv);
    // $username = openssl_encrypt($request->username, $cipher, $secret1, $options, $iv);
    $email = openssl_encrypt($request->email, $cipher, $secret1, $options, $iv);
    $username = $request->username;


    // AES Encryption for ID card
    $IDAESstart = microtime(true);
    $imageBase64 = openssl_encrypt($imageBase64, $cipher, $secret1, $options, $iv);
    $IDAESend = microtime(true);
    $IDAEStime_taken = ($IDAESend - $IDAESstart) * 1000;
    echo "Time taken to encrypt ID with AES-128-ECB: " . $IDAEStime_taken . " ms";

    // RC4 Encryption for ID card
    $IDRC4start = microtime(true);
    $imageBase64rc4 = openssl_encrypt($imageBase64, $rc4, $rc4key);
    $IDRC4end = microtime(true);
    $IDRC4time_taken = ($IDRC4end - $IDRC4start) * 1000;
    echo "Time taken to encrypt ID with RC4: " . $IDRC4time_taken . " ms";;

    // DES Encryption for ID Card
    $IDDESstart = microtime(true);
    $imageBase64des = openssl_encrypt($imageBase64, $des, $deskey);
    $IDDESend = microtime(true);
    $IDDEStime_taken = ($IDDESend - $IDDESstart) * 1000;
    echo "Time taken to encrypt ID with DES-ECB: " . $IDDEStime_taken . " ms";

    User::create([
        'name' => $name,
        'username' => $username,
        'email' => $email,
        'password' => bcrypt($request->password),
        'image' => $imageBase64,
        'key' => $secret1
    ]);
    // return redirect('/login')->with('success', 'Registration Success!');
    return redirect('/login')->with('success', 'Registration Success!')->with('id_aes_time_taken', $IDAEStime_taken)->with('id_rc4_time_taken', $IDRC4time_taken)->with('id_des_time_taken', $IDDEStime_taken);;
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

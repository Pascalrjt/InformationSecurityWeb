<?php

namespace App\Http\Controllers;

use App\Models\Animals;
use Illuminate\Http\Request;
use \App\Models\Centers;
use Illuminate\Support\Facades\Crypt;
use Encryption\Encryption;
use Encryption\Exception\EncryptionException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\File;

class AnimalsController extends Controller
{

    public function index()
{
    // Use the same secret key used for encryption
    $secret = hex2bin("1B6D4B4A5254AC");
    $animals = Animals::all();

    // Decrypt the names of all animals
        foreach ($animals as $animal) {
            $encryptedData = base64_decode($animal->name);
            $iv = substr($encryptedData, 0, 8);
            $data = substr($encryptedData, 8);

            $decryptedName = openssl_decrypt($data, 'des-ecb', $secret, OPENSSL_RAW_DATA, $iv);
            $decryptedName = rtrim($decryptedName, "\0");

            // Update the name in the model
            $animal->name = $decryptedName;
        }

        return view('animals.index', compact('animals'));
    }


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

    public function create()
    {
        $centers = Centers::all();
        return view('animals.create', compact('centers'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'breed' => 'required',
            'age' => 'required|numeric',
            'center_id' => 'required',
            'desc' => 'required|max:2048',
            'image' => 'image|file|max:2048'
        ], [
            'name.required' => 'Name can\'t be empty!',
            'breed.required' => 'Breed can\'t be empty!',
            'age.required' => 'Age can\'t be empty!',
            'center_id.required' => 'Please choose your center',
            'desc.required' => 'Description can\'t be empty!'
        ]);

        $image = $request->file('image');
        $imageBase64 = base64_encode(file_get_contents($image));

        $name = $request->input('name');
        $keyName = base64_decode("RRZy0njZDzw");
        $cipherName = 'DES-CBC';

        // Generate a random IV for each entry
        $ivName = openssl_random_pseudo_bytes(openssl_cipher_iv_length($cipherName));

        // Encrypt the name
        $encryptedName = openssl_encrypt($name, $cipherName, $keyName, 0, $ivName);

        // Concatenate IV with the encrypted name
        $encodedName = base64_encode($ivName . $encryptedName);

        // Store data in the 'animals' table
        Animals::create([
            'name' => base64_encode($encodedName), // Store IV with the encrypted name
            'center_id' => $request->center_id,
            'breed' => $request->breed,
            'age' => $request->age,
            'desc' => $request->desc,
            'image' => $imageBase64,
        ]);

        return redirect('/animals')->with('success', 'Successfully added!');
    }

    public function show($id)
    {
        $animal = Animals::findOrFail($id);

        // Ensure the encryption settings match the ones used in the store method
        $nameEncryptionKey = base64_decode("RRZy0njZDzw="); // Use the same key as in the store method

        // Get the IV and encrypted data from the 'name' field
        $nameParts = explode(':', $animal->name);

        if (count($nameParts) === 2) {
            $iv = base64_decode($nameParts[0]);
            $encryptedData = base64_decode($nameParts[1]);

            // Decrypt the name using the key and IV
            $decryptedName = openssl_decrypt($encryptedData, 'DES-CBC', $nameEncryptionKey, 0, $iv);

            // Replace the encrypted name with the decrypted name in the $animal object
            $animal->name = $decryptedName;
        } else {
            // Handle the case where the 'name' field is not in the expected format
            // You can add error handling or a default behavior here
        }

        return view('animals.show', compact('animal'));
    }




    public function edit($id)
    {
        $animals = Animals::findorfail($id);
        $centers = Centers::all();
        return view('animals.edit', compact('animals', 'centers'));
    }



    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'breed' => 'required',
            'age' => 'required|numeric',
            'center_id' => 'required',
        ],
        [
            'name.required' => 'name can\'t be empty!',
            'breed.required' => 'breed can\'t be empty!',
            'age.required' => 'age can\'t be empty!',
            'center_id' => 'Please choose your center',
        ]);

        $animals = Animals::findorfail($id);

        $animals_data = [
            'name' => $request->name,
            'center_id' => $request->center_id,
            'breed' => $request->breed,
            'age' => $request->age,
        ];

        $animals->update($animals_data);

        return view('animals.show', compact('animals'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $animals = Animals::findorfail($id);
        $animals->delete();

        return redirect('/animals');
    }

}

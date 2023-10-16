<?php

namespace App\Http\Controllers;

use App\Models\Animals;
use Illuminate\Http\Request;
use \App\Models\Centers;

class AnimalsController extends Controller
{

    public function index()
    {
        $animals = Animals::all();

        // Decrypt the name for each animal
        $secret = "fadhlanganteng12"; // Replace with your secret key
        foreach ($animals as $animal) {
            $animal->name = openssl_decrypt($animal->name, "AES-128-ECB", $secret);
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
        ],
        [
            'name.required' => 'Name can\'t be empty!',
            'breed.required' => 'NRP can\'t be empty!',
            'age.required' => 'Jurusan can\'t be empty!',
            'center_id' => 'Please choose your angkatan',
            'desc.required' => 'desc can\'t be empty!'
        ]);


        $image = $request->file('image');
        $imageBase64 = base64_encode(file_get_contents($image));

          // Encrypt data
        // $cipher = "AES-128-ECB";
        // $secret = "fadhlanganteng12";// Replace with your secret key
        // $encryptedName = openssl_encrypt($request->name, $cipher, $secret);

        // Encrypt the name
        $secret = hex2bin("1B6D4B4A5254AC");;
        $iv = openssl_random_pseudo_bytes(8); // Generate a random IV
        $paddedName = str_pad($request->name, 8, "\0"); // Pad the name to 8 bytes if needed
        $encrypted = openssl_encrypt($paddedName, 'des-ecb', $secret, OPENSSL_RAW_DATA, $iv);

        // Store the encrypted name in the database
        $encryptedName = base64_encode($iv . $encrypted);

        Animals::create([
            'name' => $encryptedName, // Store the encrypted name
            'center_id' => $request->center_id,
            'breed' => $request->breed,
            'age' => $request->age,
            'desc' => $request->desc,
            'image' => $imageBase64
        ]);

        return redirect('/animals');
    }

    public function show($id)
    {
        $animals = Animals::findorfail($id);

        // Decrypt the name
        $secret = "fadhlanganteng12"; // Replace with your secret key
        $animals->name = openssl_decrypt($animals->name, "AES-128-ECB", $secret);

        return view('animals.show', compact('animals'));
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
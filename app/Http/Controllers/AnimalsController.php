<?php

namespace App\Http\Controllers;

use App\Models\Animals;
use Illuminate\Http\Request;
use \App\Models\Centers;

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


    public function imageBase64($imagePath) {
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
        $des = "des-ecb";
        $secret = hex2bin("1B6D4B4A5254AC");;
        $iv = openssl_random_pseudo_bytes(8); // Generate a random IV
        $paddedName = str_pad($request->name, 8, "\0"); // Pad the name to 8 bytes if needed
        // $encryptedName = openssl_encrypt($paddedName, 'des-ecb', $secret, OPENSSL_RAW_DATA, $iv);

        // Store the encrypted name in the database

        $animalDesstart = microtime(true);
        $encryptedName = openssl_encrypt($imageBase64, $des, $secret);
        $animalDESend = microtime(true);
        $animalDEStime_taken = ($animalDESend - $animalDesstart) * 1000;
        echo "Time taken to encrypt Animal with DES-ECB: " . $animalDEStime_taken . " ms";
        $encryptedName = base64_encode($iv . $encryptedName);
        Animals::create([
            'name' => $encryptedName, // Store the encrypted name
            'center_id' => $request->center_id,
            'breed' => $request->breed,
            'age' => $request->age,
            'desc' => $request->desc,
            'image' => $imageBase64
        ]);

        return redirect('/animals')->with('success', 'successfully added!')->with('animal_des_time_taken', $animalDEStime_taken);
    }

    public function show($id)
    {
        $animal = Animals::findOrFail($id);

        // Decrypt the name using DES-ECB
        $secret = hex2bin("1B6D4B4A5254AC");
        $encryptedData = base64_decode($animal->name);
        $iv = substr($encryptedData, 0, 8);
        $data = substr($encryptedData, 8);

        // Decrypt the name
        $decryptedName = openssl_decrypt($data, 'des-ecb', $secret, OPENSSL_RAW_DATA, $iv);
        $decryptedName = rtrim($decryptedName, "\0");

        $animal->name = $decryptedName;

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

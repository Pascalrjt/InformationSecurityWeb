<?php

namespace App\Http\Controllers;

use App\Models\Animals;
use Illuminate\Http\Request;
use \App\Models\Centers;

class AnimalsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $animals = Animals::all();
        return view('animals.index', compact('animals'));
    }

    /**
     * Show the form for creating a new resource.
     */
    // public function create()
    // {
    //     //
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
    
    public function create()
    {
        $centers = Centers::all();
        return view('animals.create', compact('centers'));
    }

    /**
     * Store a newly created resource in storage.
     */
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

        // Animals::create([
        //     'name' => $request->name,
        //     'center_id' => $request->center_id,
        //     'breed' => $request->breed,
        //     'age' => $request->age,
        //     'desc' => $request->desc,
        //     'image' => $request->file('image')->store('post-images')
        //     ]);

        // return redirect('/animals');

        $image = $request->file('image');
        $imageBase64 = base64_encode(file_get_contents($image));
        Animals::create([
            'name' => $request->name,
            'center_id' => $request->center_id,
            'breed' => $request->breed,
            'age' => $request->age,
            'desc' => $request->desc,
            'image' => $imageBase64
        ]);

        return redirect('/animals');
    }

//     public function store(Request $request)
// {
//     $request->validate([
//         'name' => 'required',
//         'breed' => 'required',
//         'age' => 'required|numeric',
//         'center_id' => 'required',
//         'desc' => 'required|max:2048',
//         'image' => 'image|file|max:2048'
//     ],
//     [
//         'name.required' => 'Name can\'t be empty!',
//         'breed.required' => 'NRP can\'t be empty!',
//         'age.required' => 'Jurusan can\'t be empty!',
//         'center_id' => 'Please choose your angkatan',
//         'desc.required' => 'desc can\'t be empty!'
//     ]);

//     // Get the file from the request
//     $file = $request->file('image');

//     // Read the file's contents
//     $contents = file_get_contents($file->getRealPath());

//     // Encrypt the contents
//     $encryptedContents = encrypt($contents);

//     // Generate a file name
//     $fileName = $file->getClientOriginalName();

//     // Store the encrypted contents
//     Storage::put("post-images/{$fileName}", $encryptedContents);

//     Animals::create([
//         'name' => $request->name,
//         'center_id' => $request->center_id,
//         'breed' => $request->breed,
//         'age' => $request->age,
//         'desc' => $request->desc,
//         'image' => "post-images/{$fileName}"
//     ]);

//     return redirect('/animals');
// }

    /**
     * Display the specified resource.
     */
    // public function show(Animals $animals)
    // {
    //     //
    // }

    public function show($id)
    {
        $animals = Animals::findorfail($id);
        return view('animals.show', compact('animals'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    // public function edit(Animals $animals)
    // {
    //     //
    // }

    public function edit($id)
    {
        $animals = Animals::findorfail($id);
        $centers = Centers::all();
        return view('animals.edit', compact('animals', 'centers'));
    }

    /**
     * Update the specified resource in storage.
     */
    // public function update(Request $request, Animals $animals)
    // {
    //     //
    // }

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

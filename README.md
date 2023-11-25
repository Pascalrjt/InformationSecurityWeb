<h1>Information Security Project</h1>
<h3>Webhub</h3>

| NAME                              | NRP       |
|-----------------------------------|-----------|
|Muhammad Fadhlan Ashila Harashta   |5025211168 |
|Pascal Roger Junior Tauran         |5025211072 |
|Faraihan Rafi Adityawarman         |5025211074 |
|Fauzan Ahmad Faisal                |5025211067 | 

## Outline
- We created a simple website that allows the user to register, login and then store their data. All these files are then encrypted before being stored.

## Set Up
- Before running program, please edit the env file and add
```env
AES_KEY_KEY=9328e2bce387ed16a42f46c780fe1f64
```
- Or you can use any key you want 

## Features:
## User register & login screen
- The user is able to register themselves into the into the website providing information such as  their `name`, `username`, `email`, `password` as `ID card image`. These data will be encrypted and then stored in a database.

- Once the user has registered, the website will redirect the user to the login screen where the user can enter their `email` and `password` to log in.

## Encryption of user data
- The users data are encrypted using `AES-128-ECB` this is done using `openssl_encrypt`. 

- The users ID image is also encrypted and stored in the database. This done by first converting the image to a base64 longtext using a `imageToBase64` function:
```php
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
```
- Once this is done, the `image longtext` is encrypted using `AES-128-ECB`, `RC4`, and `DES`. Then the one encrypted with `AES-128-ECB` stored in the database.
```php
// AES Encryption for ID card
    $IDAESstart = microtime(true);
    $imageBase64 = openssl_encrypt($imageBase64, $cipher, $secret);
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
```
- `IDAESstart` represents the start time before the file is encrpyted and `IDEASend` represents the end time after the file is encrypted with `AES-128-ECB`. 
- `$IDAEStime_taken` is calculated by subtracting `IDAESstart` from `IDAESend`. It is then `multiplied by 1000` to obtain the time in `ms`.

![AESvsRC4vsDES](https://cdn.discordapp.com/attachments/1160530410460151899/1163875724109819905/image.png?ex=65412abc&is=652eb5bc&hm=573899e36efa4b6defe30fac73a8de3ae91b3c8be90183aad0626a7f710409f0&)

- As we can see, here is the comparison between the performance of the three encryption algorithms. As we can see `DES` was the fastest with `RC4` being second fastest and `AES` being the slowest among the three. We still chose to use AES in this case as it is the most secure among the three.

Database:<br>
![UserDatabase](https://cdn.discordapp.com/attachments/1160530410460151899/1163427682441244733/image.png?ex=653f8976&is=652d1476&hm=c4afa6faf5b9a5cd2704e5138b111a8c6bc05837e9d68d65434fa4453ed4806a&)
![UserDatabase](https://media.discordapp.net/attachments/1160530410460151899/1165266031531528233/image.png?ex=6546398f&is=6533c48f&hm=3949ab617773a4d00ee9716683c54e3a64394bd62b8468dd2a95d798f26e0818&=&width=1440&height=107)

## Analysis on Encryption Time

![encryptiontime](https://media.discordapp.net/attachments/1160530410460151899/1165261958078021663/image.png?ex=654635c4&is=6533c0c4&hm=6868822828e6ca6a5ac4d524f6f25c63f511a75be4ea384e788ae5f253a6121a&=)

- In our encryption, it turns out that `RC4` has the slowest encryption time. This occurs because PHP doesn't directly support this encryption algorithm. Because of this, we have to manually make this encryption type ourself. This is why `RC4` has the slowest time in our website with average encryption time of `0.209 ms`, it was followed by `AES` with an average encryption time of `43.089 ms` and then `DES` with an average encryption time of `0.1411 ms`

## Analysis on Encryption Size
![encryption size](https://cdn.discordapp.com/attachments/1160530410460151899/1165262008405458955/image.png?ex=654635d0&is=6533c0d0&hm=cff9dedeebc9a199aa56c2320ca049974d893d8583648ac828d92b6fd458fb9e&)

- We also have measured the size of the encrypted images, in this case, the image encrypted with `RC4` has the largest size with an average size of `376056 bytes` followed by `AES` with an an average size `250717.3333 bytes` and then there is `DES` with an average size of `188043 bytes`

## Viewing user profile / data
- After the user logs-in, they are able to view their data by going to the `profile` menu.
- Once they click it, the website will redirect them to their profile where it will pull their data from the database and decrypt it using `openssl_decrypt` with the same `cipher` and `key` as it was encrypted. Their `ID card` image remains in base64 after the decryption as html supports displaying base64 images.

User profile web page:<br>
![UserProfile](https://media.discordapp.net/attachments/1160530410460151899/1165257792924426340/image.png?ex=654631e3&is=6533bce3&hm=0df70f85d8ac0c12142a330d1e17817a7a44094852186d2065d46e60e62bad36&=&width=1342&height=671)

DES-ECB Encryption: <br>
```php
$secret = hex2bin("1B6D4B4A5254AC");;
$iv = openssl_random_pseudo_bytes(8); // Generate a random IV
$paddedName = str_pad($request->name, 8, "\0"); // Pad the name to 8 bytes if needed
$encryptedName = openssl_encrypt($paddedName, 'des-ecb', $secret, OPENSSL_RAW_DATA, $iv);

// Store the encrypted name in the database
$encryptedName = base64_encode($iv . $encryptedName);

Animals::create([
    'name' => $encryptedName, // Store the encrypted name
    'center_id' => $request->center_id,
    'breed' => $request->breed,
    'age' => $request->age,
    'desc' => $request->desc,
    'image' => $imageBase64
]);
```
- First decide on the secret key for encryption <br>
- Here, a variable $iv is defined, and it's assigned a random 8-byte value generated using the openssl_random_pseudo_bytes function. This is the Initialization Vector (IV) used for encryption <br>
- paddedName = str_pad($request->name, 8, "\0") This line creates a variable $paddedName. It takes the name field from the $request object, and if the length of the name is less than 8 characters, it pads it with null bytes ("\0") to make it exactly 8 bytes long<br>
- encryptedName = openssl_encrypt($paddedName, 'des-ecb', $secret, OPENSSL_RAW_DATA, $iv); This is to create variable to for the encrypted name and put the value in <br>
- Store the encrypted name in the database
- Lastly, we put it on the table

## File Downloading
- The user is able to upload and download the files that they have uploaded

![UserFiles](https://media.discordapp.net/attachments/824131614073683968/1177786096684372028/image.png?ex=6573c5c7&is=656150c7&hm=ae9c6cf5d0eafacbb7d3d5b8894c1afb6f86d291c9540be446cec677b8cebcef&=&format=webp&width=1390&height=671)

```php
public function download($id) {
        $file = Files::find($id);

        if (!$file) {
            abort(404); // File not found
        }

        // Check if the file is a duplicate
        if ($file->isDuplicate) {
            // Return a view with a form to ask for the private key
            return view('files.request_key', ['file' => $file]);
        }

        // Fetch the encrypted file content and decrypt it
        $cipher = "AES-256-CBC";
        $aeskey = $file->secret;
        $options = 0;
        $iv = $file->iv;

        $decrypted_AESBase64 = openssl_decrypt($file->file_base64, $cipher, $aeskey, $options, $iv);
        $fileContent = base64_decode($decrypted_AESBase64);

        // Set headers for file download
        $headers = [
            'Content-Type' => 'application/octet-stream',
            'Content-Disposition' => 'attachment; filename=' . $file->filename,
        ];

        // Return the download response
        return response()->make($fileContent, 200, $headers);
    }
```

## User Page & File Sharing

![UsersPage](https://cdn.discordapp.com/attachments/824131614073683968/1177777651495227502/image.png?ex=6573bdea&is=656148ea&hm=347e42a7aa0e96415006846c6396e627b255c8ed1fb132cd05bcd10688cfaaf4&)

- The user is able to view other users who are registerd to the website
- Below their profiles theres a `Request Files` button. Clicking on it will make a request towards the `requested_user` for their files. And return a response that request has been created.

![FileRequest](https://cdn.discordapp.com/attachments/824131614073683968/1177781895866630215/image.png?ex=6573c1de&is=65614cde&hm=37a1130f639f9ca28d8775e510ebf9a69d6bc757064157cd462bba1fe49913e5&)

- This creates a new table `file_requests` with the parameters `requester_id`, `requested_id` and `has_access` which has a default value of `false`.

![FileRequestTable](https://cdn.discordapp.com/attachments/824131614073683968/1177782463246913626/image.png?ex=6573c265&is=65614d65&hm=25061f22245a31d88ba213e0e67888dad58950ed46849b51f720f9b93ccfaff7&)

```php
public function store(Request $request, User $requested)
    {
        $user = Auth::user();

        $existingRequest = FileRequest::where('requested_id', $request->input('requested_id'))
            ->where('requester_id', $user->id)
            ->first();

            if (!$existingRequest) {
                $filerequest = FileRequest::create([
                    'requested_id' => $request->input('requested_id'),
                    'requester_id' => $user->id,
                    'has_access' => false,
                ]);

                return redirect('/users')->with('success', 'Successfully requested files!');
            } else {
                return redirect('/users')->with('error', 'File request already exists!');
            }
    }
```

## User Inbox for File Requests & File Sharing

- The user has an inbox page where the requests that they received are stored

![UserInbox](https://cdn.discordapp.com/attachments/824131614073683968/1177783803880677457/image.png?ex=6573c3a5&is=65614ea5&hm=888580faaa1ca401789e9bb482a7ca6392367ae03f3b902fb7c63089e6ea2456&)

- The requested user can click on the `Accept Request` button and the `file_requests` table will be updated changing the `has_access` value from `false` to `true`.

![requestedInbox](https://media.discordapp.net/attachments/824131614073683968/1177783803880677457/image.png?ex=6573c3a5&is=65614ea5&hm=888580faaa1ca401789e9bb482a7ca6392367ae03f3b902fb7c63089e6ea2456&=&format=webp&width=1394&height=670)

- The `requested_user`'s files will then be duplicated and modified so that their `fileOwner` is now the `requester_user`. During the duplication the files, the file will first be decrypted and then a new `key` will be generated to encrypt the duplicated `files`. Once this happens the encrypted files will then be stored and the newly generated `key` will be encrypted again by a `master key` that is stored in the `env`. The newly duplicated files will also have their `isDuplicate` value changed from false to `true`, This prevents shared files to be reshared again to other users.
- The `requester_user` will be notified that the `requested_user` has given them access to the files via the inbox and the encrypted key `private_key` will also be sent to the inbox of the `requester_user` which will be used when downloading the `shared` `files`.

![requesterFiles](https://media.discordapp.net/attachments/824131614073683968/1177786096684372028/image.png?ex=6573c5c7&is=656150c7&hm=ae9c6cf5d0eafacbb7d3d5b8894c1afb6f86d291c9540be446cec677b8cebcef&=&format=webp&width=1390&height=671)

```php
public function update(Request $request, FileRequest $fileRequest)
    {
        $fileRequest->has_access = true;
        $fileRequest->save();

        // Fetch all files owned by the requested_id
        $files = Files::where('fileOwner', $fileRequest->requested_id)->get();

        // Define the cipher
        $cipher = "AES-256-CBC";
        $options = 0;

        // Generating a new secret
        $newAESkey = bin2hex(openssl_random_pseudo_bytes(16));
        // $AESkeykey = bin2hex(openssl_random_pseudo_bytes(16));
        $AESkeykey = env('AES_KEY_KEY');

        // Duplicate each file and change the fileOwner to the requester_id
        foreach ($files as $file) {
            //Checks if file is a duplicate and does not duplicate if isDuplicate value is true
            if(!$file->isDuplicate){
                $newFile = $file->replicate();
                $newFile->fileOwner = $fileRequest->requester_id;
                $newFile->isDuplicate = true;

                // Fetch the iv from the file
                $iv = $file->iv;
                // Decrypting the FileBase64
                $decryptedFileBase64 = openssl_decrypt($file->file_base64, $cipher, $file->secret, $options, $iv);
                // Re-encrypting the file with the new secret
                $encryptedFileBase64 = openssl_encrypt($decryptedFileBase64, $cipher,  $newAESkey, $options, $iv);

                $encrypedAESkey = openssl_encrypt($newAESkey, $cipher, $AESkeykey, $options, $iv);
                $AESkeyMessage = openssl_encrypt($encrypedAESkey, $cipher, $AESkeykey, $options, $iv);

                // Storing the encrpyted file and the new secret
                $newFile->file_base64 = $encryptedFileBase64;

                // secret is holding the value of the encrypted encrypted key 
                $newFile->secret = $AESkeyMessage;

                $newFile->save();
            }
        }

        $requester = User::find($fileRequest->requester_id);
        $notification = "User A has accepted your request.";

        return redirect('/inbox')->with('success', 'You have accepted the file request.');
    }
```

## Downloading Shared Files 

- The `requester_user` is able to download the files that have been shared to him by clicking the `download` button
- If the file is a `shared file` it will promt the user to enter the `private key` that was generated when the file was shared.  
- After the `private key` is entered the key will be decrypted with the `master key` stored in the `env` and then the `encrypted shared_file` will be decrypted by the decrypted `private key`. The file will then be downloaded.

![PrivateKeyPrompt](https://cdn.discordapp.com/attachments/824131614073683968/1177790862814625922/image.png?ex=6573ca37&is=65615537&hm=aedd2c4dcd5e7b9abaf189440871d5a1adb691a26fd2e8f8856edfbefe6caf08&)

```php
public function decryptWithKey(Request $request, $id) {
        $file = Files::find($id);

        if (!$file) {
            abort(404); // File not found
        }

        // Fetch the private key from the request
        $privateKey = $request->input('private_key');


        // Fetch the encrypted file content and decrypt it
        $cipher = "AES-256-CBC";
        $options = 0;
        $iv = $file->iv;
        $decryptedPrivateKey = openssl_decrypt($privateKey, $cipher, env('AES_KEY_KEY'), $options, $iv);

        $decrypted_AESBase64 = openssl_decrypt($file->file_base64, $cipher, $decryptedPrivateKey, $options, $iv);
        $fileContent = base64_decode($decrypted_AESBase64);

        // Set headers for file download
        $headers = [
            'Content-Type' => 'application/octet-stream',
            'Content-Disposition' => 'attachment; filename=' . $file->filename,
        ];

        // Return the download response
        return response()->make($fileContent, 200, $headers);
    }
```

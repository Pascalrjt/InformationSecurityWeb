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
- Once this is done, the `image longtext` is encrypted using `AES-128-ECB` then stored in the database.

Database:<br>
![UserDatabase](https://cdn.discordapp.com/attachments/1160530410460151899/1163427682441244733/image.png?ex=653f8976&is=652d1476&hm=c4afa6faf5b9a5cd2704e5138b111a8c6bc05837e9d68d65434fa4453ed4806a&)

## Viewing user profile / data
- After the user logs-in, they are able to view their data by going to the `profile` menu.
- Once they click it, the website will redirect them to their profile where it will pull their data from the database and decrypt it using `openssl_decrypt` with the same `cipher` and `key` as it was encrypted. Their `ID card` image remains in base64 after the decryption as html supports displaying base64 images.

User profile web page:<br>
![UserProfile](https://media.discordapp.net/attachments/1160530410460151899/1163428968741994607/image.png?ex=653f8aa9&is=652d15a9&hm=9513074701059ab063c89cbe788b66e094c625a6c0f76c8f1e36995bdbfd7c0f&=&width=1297&height=671)

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

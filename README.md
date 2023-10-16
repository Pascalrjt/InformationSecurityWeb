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
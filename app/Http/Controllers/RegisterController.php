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

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:225',
            'username' => 'required|min:5|max:20|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:5|max:255',
            'image' => 'image|file|max:2048'
        ]);

        $image = $request->file('image');
        if ($image) {
            $imageBase64 = base64_encode(file_get_contents($image));
        } else {
            $imageBase64 = null;
        }

        // Function to check if a number is prime
        function isPrime($number) {
            if ($number < 2) {
                return false;
            }
            for ($i = 2; $i <= sqrt($number); $i++) {
                if ($number % $i == 0) {
                    return false;
                }
            }
            return true;
        }

        // Function to find a random prime number in a given range
        function findRandomPrime($min, $max) {
            do {
                $candidate = mt_rand($min, $max);
            } while (!isPrime($candidate));
            return $candidate;
        }

        // Function to calculate the greatest common divisor (GCD) of two numbers
        function gcd($a, $b) {
            while ($b != 0) {
                $temp = $b;
                $b = $a % $b;
                $a = $temp;
            }
            return $a;
        }

        // Function to find a public exponent (e) such that 1 < e < phi(n) and gcd(e, phi(n)) = 1
        function findPublicExponent($phiN) {
            $e = 2;
            while ($e < $phiN) {
                if (gcd($e, $phiN) == 1) {
                    return $e;
                }
                $e++;
            }
            return null; // Error: Couldn't find a suitable public exponent
        }

        // Function to calculate the modular multiplicative inverse of a number
        function modInverse($a, $m) {
            for ($x = 1; $x < $m; $x++) {
                if (($a * $x) % $m == 1) {
                    return $x;
                }
            }
            return null; // Error: Modular multiplicative inverse does not exist
        }


        //Ciphers
        $aes = "AES-256-CBC";
        // $rc4 = "rc4";
        $des = 'DES-CBC';

        function rc4($key, $str) {
            $s = array();
            for ($i = 0; $i < 256; $i++) {
                $s[$i] = $i;
            }
            $j = 0;
            for ($i = 0; $i < 256; $i++) {
                $j = ($j + $s[$i] + ord($key[$i % strlen($key)])) % 256;
                $x = $s[$i];
                $s[$i] = $s[$j];
                $s[$j] = $x;
            }
            $i = 0;
            $j = 0;
            $res = '';
            for ($y = 0; $y < strlen($str); $y++) {
                $i = ($i + 1) % 256;
                $j = ($j + $s[$i]) % 256;
                $x = $s[$i];
                $s[$i] = $s[$j];
                $s[$j] = $x;
                $res .= $str[$y] ^ chr($s[($s[$i] + $s[$j]) % 256]);
            }

            $res = bin2hex($res);
            return $res;
        }

        function generateAESKey(){
            return bin2hex(openssl_random_pseudo_bytes(16));
        }

        function generateRC4Key() {
            $key = '';
            $characters = '0123456789ABCDEF';
            $length = 32;

            for ($i = 0; $i < $length; $i++) {
                $key .= $characters[rand(0, strlen($characters) - 1)];
            }

            return $key;
        }

        function generateDESKey() {
            $key = '';
            $characters = '0123456789ABCDEF';
            $length = 16; // 16 characters for a 128-bit key

            for ($i = 0; $i < $length; $i++) {
                $key .= $characters[rand(0, strlen($characters) - 1)];
            }

            return $key;
        }

        // $secret = "12345678901234567890123456789012";

        //generating the keys
        $aeskey = generateAESKey();
        $rc4key = generateRC4Key();
        $deskey = generateDESKey();

        // $rc4key = "2B7E151628AED2A6ABF7158809CF4F3C";
        // $deskey = "133457799BBCDFF1A";

        //Iv
        $options = 0;
        $iv = str_repeat("0", openssl_cipher_iv_length($aes));

        //User profile encryption
        $name = openssl_encrypt($request->name, $aes, $aeskey, $options, $iv);
        // $username = openssl_encrypt($request->username, $aes, $aeskey, $options, $iv);
        $email = openssl_encrypt($request->email, $aes, $aeskey, $options, $iv);
        $username = $request->username;


        // AES Encryption for ID card
        $IDAESstart = microtime(true);
        $imageBase64AES = openssl_encrypt($imageBase64, $aes, $aeskey, $options, $iv);
        $IDAESend = microtime(true);
        $IDAEStime_taken = ($IDAESend - $IDAESstart) * 1000;
        echo "Time taken to encrypt ID with AES-128-ECB: " . $IDAEStime_taken . " ms";

        $IDRC4start = microtime(true);
        $imageBase64RC4 = rc4($rc4key, $imageBase64);
        $IDRC4end = microtime(true);
        $IDRC4time_taken = ($IDRC4end - $IDRC4start) * 1000;
        echo "Time taken to encrypt ID with RC4: " . $IDRC4time_taken . " ms";

        // DES Encryption for ID Card
        $IDDESstart = microtime(true);
        $imageBase64DES = openssl_encrypt($imageBase64, $des, $deskey, 0, $iv);
        $IDDESend = microtime(true);
        $IDDEStime_taken = ($IDDESend - $IDDESstart) * 1000;
        echo "Time taken to encrypt ID with DES-ECB: " . $IDDEStime_taken . " ms";

        User::create([
            'name' => $name,
            'username' => $username,
            'email' => $email,
            'password' => bcrypt($request->password),
            'imageBase64AES' => $imageBase64AES,
            'imageBase64RC4' => $imageBase64RC4,
            'keyAES' => $aeskey,
            'keyRC4' => $rc4key
        ]);

        // // Key generation code
        // $config = array(
        //     "private_key_bits" => 2048,
        //     "private_key_type" => OPENSSL_KEYTYPE_RSA,
        // );

        // $privateKey = openssl_pkey_new($config);

        // openssl_pkey_export($privateKey, $privateKeyPEM);

        // $publicKeyDetails = openssl_pkey_get_details($privateKey);
        // $publicKeyPEM = $publicKeyDetails["key"];

        // // Save private and public keys to files
        // file_put_contents(storage_path('app/certificates/private_key.pem'), $privateKeyPEM);
        // file_put_contents(storage_path('app/certificates/public_key.pem'), $publicKeyPEM);

        // // Paths to the certificate and key files
        // $certificatePath = storage_path('app/certificates/Webhub.cer');
        // $privateKeyPath = storage_path('app/certificates/private_key.pem');
        // $publicKeyPath = storage_path('app/certificates/public_key.pem');

        // // Read the contents of the certificate, private key, and public key
        // $certificateContent = file_get_contents($certificatePath);
        // $privateKeyContent = file_get_contents($privateKeyPath);
        // $publicKeyContent = file_get_contents($publicKeyPath);

        // // Combine the contents in the desired order
        // $combinedContent = $certificateContent . "\n" . $privateKeyContent . "\n" . $publicKeyContent;

        // // Path to the new combined certificate file in /storage/app/certificates
        // $newCertificatePath = storage_path("app/certificates/{$username}.crt");

        // // Save the combined content to the new certificate file
        // file_put_contents($newCertificatePath, $combinedContent);

        // Generate two random prime numbers, p and q
        $p = findRandomPrime(10000, 20000);
        $q = findRandomPrime(10000, 20000);

        // Calculate n (modulus)
        $n = $p * $q;

        // Calculate phi(n) (Euler's totient function)
        $phiN = ($p - 1) * ($q - 1);

        // Find a public exponent (e)
        $e = findPublicExponent($phiN);

        // Calculate private exponent (d) using the modular multiplicative inverse
        $d = modInverse($e, $phiN);

        echo "Public Key (e, n): ($e, $n)\n";
        echo "Private Key (d, n): ($d, $n)\n";

        // Convert keys to PEM format
        $publicKeyPEM = "-----BEGIN CERTIFICATE REQUEST-----\n" .
            wordwrap(base64_encode(pack('N', $e) . pack('N', $n)), 64, "\n", true) .
            "\n-----END CERTIFICATE REQUEST-----\n";

        $privateKeyPEM = "-----BEGIN RSA PRIVATE KEY-----\n" .
            wordwrap(base64_encode(pack('N', $n) . pack('N', $e) . pack('N', $d)), 64, "\n", true) .
            "\n-----END RSA PRIVATE KEY-----\n";

        // Read the contents of the certificate, private key, and public key
        $certificatePath = storage_path('app/certificates/Webhub.cer');
        $certificateContent = file_get_contents($certificatePath);

        // Combine the contents in the desired order
        $combinedContent = $certificateContent . $privateKeyPEM . $publicKeyPEM;

        // Path to the new combined certificate file in /storage/app/certificates
        $newCertificatePath = storage_path("app/certificates/{$username}.crt");

        // Save the combined content to the new certificate file
        file_put_contents($newCertificatePath, $combinedContent);

        return redirect('/login')->with('success', 'Registration Success!')->with('id_aes_time_taken', $IDAEStime_taken)->with('id_rc4_time_taken', $IDRC4time_taken)->with('desdecrypt', $imageBase64DES);
    }

}

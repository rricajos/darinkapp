<?php

require __DIR__ . '/vendor/autoload.php';

use ParagonIE\Halite\Symmetric\Crypto;
use ParagonIE\Halite\KeyFactory;
use ParagonIE\HiddenString\HiddenString;

// Generate or load the encryption key
$keyPath = __DIR__ . '/encryption.key';
if (!file_exists($keyPath)) {
    $key = KeyFactory::generateEncryptionKey();
    KeyFactory::save($key, $keyPath);
} else {
    $key = KeyFactory::loadEncryptionKey($keyPath);
}

// Encrypt session data
function encryptSessionData($data, $key) {
    // Wrap plaintext data in a HiddenString
    $hiddenString = new HiddenString($data);
    return Crypto::encrypt($hiddenString, $key);
}

// Decrypt session data
function decryptSessionData($encryptedData, $key) {
    // Decrypt the data and return as string
    $hiddenString = Crypto::decrypt($encryptedData, $key);
    return $hiddenString->getString(); // Get the plain string from HiddenString
}

// Start a PHP session
session_start();

// Save encrypted data to the session
$data = json_encode(['user_id' => 124, 'username' => 'JohnDoe']); // Prepare data as JSON string
$_SESSION['secure_data'] = encryptSessionData($data, $key);

// Retrieve and decrypt data from the session
$decryptedData = json_decode(decryptSessionData($_SESSION['secure_data'], $key), true);
echo 'User: ' . $decryptedData['username'];
echo $_SESSION['secure_data'];

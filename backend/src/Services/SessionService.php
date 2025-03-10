<?php

namespace App\Services;

use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\NativeSessionStorage;
use ParagonIE\Halite\Symmetric\Crypto;
use ParagonIE\Halite\KeyFactory;
use ParagonIE\HiddenString\HiddenString;

class SessionService {
    private $session;
    private $encryptionKey;

    public function __construct() {
        $keyPath = __DIR__ . '/../../config/encryption.key';
        if (!file_exists($keyPath)) {
            $this->encryptionKey = KeyFactory::generateEncryptionKey();
            KeyFactory::save($this->encryptionKey, $keyPath);
        } else {
            $this->encryptionKey = KeyFactory::loadEncryptionKey($keyPath);
        }

        $this->session = new Session(new NativeSessionStorage());
        $this->session->start();
    }

    public function startSession() {
        $this->session->start();
    }

    public function set($key, $value) {
        // Convert $value to a JSON string and wrap it in HiddenString
        $hiddenValue = new HiddenString(json_encode($value));
        $encryptedValue = Crypto::encrypt($hiddenValue, $this->encryptionKey);
        $this->session->set($key, $encryptedValue);
    }

    public function get($key) {
        $encryptedValue = $this->session->get($key);
        if (!$encryptedValue) {
            return null;
        }

        // Decrypt and decode the JSON data
        $hiddenString = Crypto::decrypt($encryptedValue, $this->encryptionKey);
        return json_decode($hiddenString->getString(), true);
    }

    public function destroySession() {
        $this->session->invalidate();
    }
}

<?php

namespace App\controller;

class DTC
{
    private static $instances;
    private $key="asdERFb~14Rfff15";

    public function hashing($password, $natid) {
        $hashedpass = false;

        if($natid != ""){
            $hashed_natid = hash_hmac('sha512', $natid, $this->key);
            $hashed_password = hash_hmac('sha512', $password, $this->key);

            $hashedpass = substr($hashed_natid, 10, 16).substr($hashed_password, 36, 16).substr($hashed_natid, 97, 16).substr($hashed_password,89,16);
        }

        return $hashedpass;
    }

   public function enc($data){
        return base64_encode(openssl_encrypt($data, "aes-256-cbc", $this->key, OPENSSL_RAW_DATA , "iv"));
    }

   public function dec($data){
        return openssl_decrypt(base64_decode($data), "aes-256-cbc", $this->key, OPENSSL_RAW_DATA , "iv");
    }

   public function create_checksum($input){
        $hashed = hash_hmac('sha512', $input, $this->key);
        return substr($hashed, 13, 8).substr($hashed, 99, 8);
    }

   public function create_serial($input){
        $hashed = hash_hmac('sha512', $input, $this->key);
        return substr($hashed, 46, 12).substr($hashed, 72, 12);
    }

}
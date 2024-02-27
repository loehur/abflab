<?php

class Encrypt
{
    function enc($text)
    {
        //TRUE
        $newText = crypt(md5($text), md5($text . "_F0r3ver_j499uL0v3ly_N3lyL0vEly")) . md5(md5($text)) . crypt(md5($text), md5("saturday_10.06.2017_12.45"));
        return $newText;
    }

    function enc_2($encryption)
    {
        //TRUE
        $ciphering = "AES-128-CTR";
        $options = 0;

        $encryption_iv = '1234567891011121';
        $encryption_key = "_F0r3ver_j499uL0v3ly_N3lyL0vEly";

        $encryption = openssl_encrypt(
            $encryption,
            $ciphering,
            $encryption_key,
            $options,
            $encryption_iv
        );

        return $encryption;
    }

    function dec_2($encryption)
    {
        //TRUE
        $ciphering = "AES-128-CTR";
        $options = 0;

        $decryption_iv = '1234567891011121';
        $decryption_key = "_F0r3ver_j499uL0v3ly_N3lyL0vEly";

        $decryption = openssl_decrypt(
            $encryption,
            $ciphering,
            $decryption_key,
            $options,
            $decryption_iv
        );

        return $decryption;
    }
}

<?php
namespace Sproduce\JWT;


class JWT
{
    private static $privateKey;
    private static $publicKey;
    
    
    
    private static function base64SafeEncode($data)
    {
        return str_replace('=', '',strtr(base64_encode($data), '+/', '-_'));
    }
    
    
    
    private static function base64SafeDecode($data64)
    {
       $remainder = strlen($data64) % 4;
        if ($remainder) {
            $padlen = 4 - $remainder;
            $data64 .=str_repeat('=', $padlen);
        }
        return base64_decode(strtr($data64, '-_', '+/'));
    }
    
    
    
    
    private static function sign($data)
    {
        $signature='';
        openssl_sign($data,$signature,static::$privateKey,OPENSSL_ALGO_SHA256);
        return $signature;
    }
    
    
    
    
    
    public static function loadPrivateKeyFromFile($path)
    {
        static::$privateKey=file_get_contents($path); 
    }
    
    public static function loadPublicKeyFromFile($path)
    {
        static::$publicKey=file_get_contents($path); 
    }
    
    
    public static function encode($payload)
    {
        $header=array("alg"=>"RS256","typ"=>"jwt");
        $headerJson= json_encode($header);
        if(is_array($payload)){
            $payloadJson=json_encode($payload);
            $forSign=static::base64SafeEncode($headerJson).".".static::base64SafeEncode($payloadJson);
            $signature= static::sign($forSign);
            return $forSign.".".static::base64SafeEncode($signature);
        } 
        
        return null;
        
    }
    
    
    public static function decode($jwt)
    {
       $tkn=explode('.',$jwt);
        if (count($tkn)==3){
            list($header64,$payload64,$sig64)=$tkn;
            $payload= static::base64SafeDecode($payload64);
            $sig= static::base64SafeDecode($sig64);
            $res=openssl_verify($header64.".".$payload64,$sig, static::$publicKey,OPENSSL_ALGO_SHA256);
            if($res){
            return json_decode($payload,true);
            }
        }
        
        return null; 
        
    }
    
    
    
    
    
}


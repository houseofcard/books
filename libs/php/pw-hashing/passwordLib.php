<?php
/**
 * PHP 5.5-like password hashing functions
 *
 * Provides a password_hash() and password_verify() function as appeared in PHP 5.5.0
 * 
 * See: http://php.net/password_hash and http://php.net/password_verify
 * 
 * @link https://github.com/Antnee/phpPasswordHashingLib
 */

require_once('passwordLibClass.php');

function password_hash($password, $algo=PASSWORD_DEFAULT, $options=array()){
    $crypt = NEW Antnee\PhpPasswordLib\PhpPasswordLib;
    $crypt->setAlgorithm($algo);
        
    $debug  = isset($options['debug'])
        ? $options['debug']
        : NULL;
        
    $password = $crypt->generateCryptPassword($password, $options, $debug);
        
    return $password;
}

function password_verify($password, $hash){
    return (crypt($password, $hash) === $hash);
}



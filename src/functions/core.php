<?php
/**
 * Kbs project - 2019 © ICTM1o1 - Abdullah, Boaz, Jesse, Jordy, Kahn, Ton
 * Core functions for project
 */

 /**
  * Encrypts string
  * @param mixed $string String that needs updating
  * @return mixed Encrypted string
  */

  
  function hashString($string) {
    $salt = "KB5Í5ƒÚÑ";
    $encryptedString = hash('sha512', hash('sha512', $string) . $salt);
    return $encryptedString;
 }

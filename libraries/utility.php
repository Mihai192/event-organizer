<?php

   function containsDigits(string $text): bool
   {
      for ($i = 0; $i < strlen($text); $i++) 
          if(is_numeric($text[$i]))  
             return true;

      return false;
   }

   function generateString(int $length): string
   {
      return bin2hex(random_bytes($length / 2));
   }

   function generateSessionToken($email, $pass)
   {
      $salt = generateString(60);
      return hash("sha256", hash("sha256", $email . $pass) . $salt);
   }
   
   function containsUppercaseLetter(string $text): bool
   {
      for ($i = 0; $i < strlen($text); $i++) 
          if('A' <= $text[$i] && $text[$i] <= 'Z')  
             return true;

      return false;
   }

   function containsLowercaseLetter(string $text): bool 
   {
      for ($i = 0; $i < strlen($text); $i++) 
          if('a' <= $text[$i] && $text[$i] <= 'z')  
             return true;

      return false;
   }

   function checkEmail(string $text): bool
   {
      $pattern = "/^.*@.*\..*$/";
      return preg_match($pattern, $text);
   }

   function checkDate_(string $text) : bool 
   {
      $pattern = "/^[0-9][0-9][0-9][0-9]-[0-9][0-9]-[0-9][0-9]$/";
      return preg_match($pattern, $text);
   }

   function checkPass(string $text): bool
   {
      return containsUppercaseLetter($text) && containsLowercaseLetter($text)
               && containsDigits($text) && strlen($text) > 7;
   }

?>
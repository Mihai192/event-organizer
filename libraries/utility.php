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
   
   function createToken(mysqli $conn) : string
   {
      $token = hash("sha256", generateString(64));

      $sql = "INSERT INTO Token(hash, user_id) VALUES 
         ('$token', LAST_INSERT_ID())";

      if ($conn->query($sql) === TRUE)
      {
         $GLOBALS['success'] = "Cont creat cu succes! A fost trimis un mail pe adresa contului pentru verificare!";
         return $token;
      }
      else
         throw new Exception("Ceva nu a mers bine! Incearca mai tarziu.");
   }


   function createAccount(mysqli $conn, string $nume, string $prenume, string $email, string $password) : string
   {
      $sql = "SELECT * FROM User WHERE email = '${email}'";
      $results = $conn->query($sql);

      if ($results->num_rows === 0)
      {
         $pass = hash("sha256", $password);
         $user_type = USER;
         $status    = INACTIVE_ACCOUNT;
         $salt      = hash("sha256", generateString(64));

         
         $stmt = $conn->prepare("INSERT INTO User(nume, prenume, email, password, user_type, status)
         VALUES (?, ?, ?, ?, ?, ?)");

         $stmt->bind_param("ssssii", $nume, $prenume, $email, $pass, $user_type,  $status);
         
         $stmt -> execute(); 
         return createToken($conn);
         
         // else
      //       throw new Exception("Ceva nu a mers bine! Incearca mai tarziu.");
      }
      else
         throw new Exception("nume sau email deja folosite!");
      
   }

   function sendVerificationAccountMail($token)
   {
      $from = "mail@event-organizer.tk";
      $to = $email;
      $subject = "Confirma contul event-organizer";
      $message = "Click pe link-ul urmator pentru a confirma contul: " . 'https://www.event-organizer.tk/verify-email.php?token=' . $token;

      $headers = "From:" . $from;

      if(!mail($to,$subject,$message, $headers)) 
         throw "Nu s-a putut trimite mail-ul. Mai incearca odata creearea contului.";
      
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

   function checkLogin()
   {
      return isset($_SESSION['session_token']);
   }
   


   function _redirect($location)
   {
      header("Location: " . $location);
      die();
   }
?>
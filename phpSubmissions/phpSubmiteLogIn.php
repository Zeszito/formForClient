<?php 

header('Content-Type: charset=utf-8');
setlocale(LC_ALL, 'Portuguese_Portugal.1252');
   // MAKE SQLI CONNECTION
   $conn = new mysqli("15.188.164.24", "root", "sayhitoevolution", "sabseg_database");
   if($conn->connect_error)
   {
      die ("error:" . $conn->connect_error);
   } 

   mysqli_set_charset($conn, "utf8"); // TA-DA

   // POSTS
   $email = $_POST['emailVal'];

   //1-Verificar se email esta registado
   $accountVerify = "SELECT email FROM users WHERE email = '".$email."'";
   if($conn->query($accountVerify)->num_rows == 0)
   {
      echo ("NO-Este email não foi ainda registado.");
   }
   else
   {
      // 2 testar club
      $selectUserClub = "SELECT club FROM users WHERE email = '".$email."'";
      if($conn->query($selectUserClub)->num_rows == 0)
      {
         echo ("NO-Erro a encontrar club.");
      }
      else
      {
         $clubSelect = "SELECT `club` FROM `users` WHERE email = '" . $email . "'";
         $clubResult = $conn->query($clubSelect);
         if ( $clubResult->num_rows == 0) 
         {
            echo ("NO-Erro a encontrar o club do utilizador.");
         }
         else
         {
            // Clube do utilizador
            $club = mysqli_fetch_row($clubResult)[0];
            echo "OK-" . $club;
         }
      }
   }
?>
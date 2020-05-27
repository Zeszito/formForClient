<?php header('Content-Type: charset=utf-8');

setlocale(LC_ALL, 'Portuguese_Portugal.1252');
   // MAKE SQLI CONNECTION
   $conn = new mysqli("15.188.164.24", "root", "sayhitoevolution", "sabseg_database");
   if($conn->connect_error)
   {
      die("error:" . $conn->connect_error);
   } 

   // POSTS
   $email = $_POST['emailVal'];

   //1-Verificar se email esta registado
   $accountVerify = "SELECT email FROM users WHERE email = '".$email."'";
   if($conn->query($accountVerify)->num_rows == 0)
   {
      die("NO-Este email não foi ainda registado");
   }
   else
   {
      // 2 testar club
      $selectUserClub = "SELECT club FROM users WHERE email = '".$email."'";
      if($conn->query($selectUserClub)->num_rows == 0)
      {
         die("NO-Erro a encontrar club");
      }
      else
      {
         // 3- Verificar se o club esta na data base
         $userClub = mysqli_fetch_row($conn->query($selectUserClub))[0];
         $selectClub = "SELECT `sponsored` FROM `clubs` WHERE `name` = '".$userClub."'";
         if($conn->query($selectClub)->num_rows == 0)
         {
            die("NO-Erro a encontrar club do utilizador na db");
         }
         else
         {
            // 4- Verificar se o club é valido
            if(mysqli_fetch_row($conn->query($selectClub))[0] == 0)
            {
               die("NO-Club não patrocionado pela sabseg");
            }
            else
            {
               // 5-Verificar se já jogou
               $selectReward = "SELECT reward FROM users WHERE email = '".$email."' AND reward != '0'";
               if ($conn->query($selectReward)->num_rows > 0) 
               {
                  die("NO-Voçê já jogou á roleta");
               }
               else
               {
                  $clubSelect = "SELECT `club` FROM `users` WHERE email = '" . $email . "'";
                  $clubResult = $conn->query($clubSelect);
                  if ( $clubResult->num_rows == 0) 
                  {
                     die("NO-Error getting club");
                  }
                  else
                  {
                     $club = mysqli_fetch_row($clubResult);
                     echo "OK-" . utf8_encode($club[0]);
                  }
               }
            }
         }
      }
   }
?>
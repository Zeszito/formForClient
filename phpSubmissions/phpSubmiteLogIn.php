<?php 

use PHPMailer\PHPMailer\PHPMailer;
   use PHPMailer\PHPMailer\Exception;
   
   require '/opt/lampp/htdocs/roleta/phpSubmissions/phpmailer/src/Exception.php';
   require '/opt/lampp/htdocs/roleta/phpSubmissions/phpmailer/src/PHPMailer.php';
   require '/opt/lampp/htdocs/roleta/phpSubmissions/phpmailer/src/SMTP.php';

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
   $registered = $_POST['VimDeRegistoVal'];

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
            if($registered == 0)
            {
               //Send email
               $mail = new PHPMailer();
               $mail->IsSMTP(); // enable SMTP
               //$mail->SMTPDebug = 0; // debugging: 1 = errors and messages, 2 = messages only
               $mail->SMTPAuth = true; // authentication enabled
               //$mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail
               $mail->SMTPSecure = 'tls'; // secure transfer enabled REQUIRED for Gmail
               $mail->Host = "smtp.live.com";
               //$mail->Host = "smtp.live.com";
               $mail->Port = 587; // 465 or 587
               $mail->IsHTML(true);
               $mail->Username = "celebramosfutebol@sabseg.pt";
               $mail->Password = "G.1722.a";
               $mail->SetFrom("celebramosfutebol@sabseg.pt");
               //$mail->Username = "hivolvept@gmail.com";
               //$mail->Password = "sayhitoevolutionemail";
               //$mail->SetFrom("hivolvept@gmail.com");
               $mail->Subject = "Celebramos Futebol | SABSEG Seguros: Roleta Digital SABSEG";
               $mail->Body = "Ola,
            
<p>Desde ja obrigado pelo teu interesse na Roleta Digital SABSEG.<br>
Os teus dados foram submetidos com sucesso. Esperamos que te divirtas com a nossa Roleta!<br>
Mantem-te atento ao <a href='www.celebramosfutebol.sabseg.com'>www.celebramosfutebol.sabseg.com</a> e nao percas os premios exclusivos que temos para te oferecer.</p>
            
<p>Junta-te a nos e vive experiencias inesqueciveis.<br>
O futebol e a paixao que nos une.</p>
            

<p><p><b>Celebramos o Futebol | SABSEG Seguros</b></p></p>";
               $mail->AddAddress($email);

               if(!$mail->Send()) 
               {
                 echo "NO-Mailer error: " . $mail->ErrorInfo;
               } 
               else 
               {
                  // Clube do utilizador
                  $club = mysqli_fetch_row($clubResult)[0];
                  echo "OK-" . $club;
               }
            }
            else
            {
               // Clube do utilizador
               $club = mysqli_fetch_row($clubResult)[0];
               echo "OK-" . $club;
            }
         }
      }
   }
?>
<?php
 use PHPMailer\PHPMailer\PHPMailer;
 use PHPMailer\PHPMailer\Exception;
 
 require '/opt/lampp/htdocs/roleta/phpSubmissions/phpmailer/src/Exception.php';
 require '/opt/lampp/htdocs/roleta/phpSubmissions/phpmailer/src/PHPMailer.php';
 require '/opt/lampp/htdocs/roleta/phpSubmissions/phpmailer/src/SMTP.php';
 
   $conn = new mysqli("15.188.164.24", "root", "sayhitoevolution", "sabseg_database");
   if($conn->connect_error)
   {
      die("error:" . $conn->connect_error);
   } 
   else
   {
     echo "Connected!";
   }

   $email = $_POST['emailVal'];
   $reward = $_POST['rewardVal'];


   $updateReward = "UPDATE `users` SET `reward`=$reward WHERE `email` = $email";
   if($conn->query($updateReward) === FALSE)
   {
      echo("NO-Nao deu update á reward");
   }
   else
   {
      $getReward = "SELECT reward FROM users WHERE email = '" . $email . "'";
      $rewardConn = $conn->query($getReward);
      if ($rewardConn->num_rows == 0)
      {
         echo "NO-Erro a encontrar reward - email nao valido";
      }
      else
      {
         // Current user reward
         $sqlReward = mysqli_fetch_row($conn->query($getReward))[0];

         //Send email
         $mail = new PHPMailer();
         $mail->IsSMTP(); // enable SMTP
         $mail->SMTPDebug = 2; // debugging: 1 = errors and messages, 2 = messages only
         $mail->SMTPAuth = true; // authentication enabled
         $mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail
         //$mail->SMTPSecure = 'tls'; // secure transfer enabled REQUIRED for Gmail
         $mail->Host = "smtp.gmail.com";
         //$mail->Host = "smtp.live.com";
         $mail->Port = 465; // 465 or 587
         $mail->IsHTML(true);
         $mail->Username = "hivolvept@gmail.com";
         $mail->Password = "sayhitoevolutionemail";
         $mail->SetFrom("hivolvept@gmail.com");
         $mail->Subject = "Celebramos Futebol | SABSEG Seguros: Roleta Digital";

         if($sqlReward = "camisola")
         {
            $mail->Body = "camisola";
         }
         else if($sqlReward = "camisolaAlt")
         {
            $mail->Body = "camisolaAlt";
         }
         else if($sqlReward = "seguro")
         {
            $mail->Body = "seguro";
         }
         else if($sqlReward = "consultoria")
         {
            $mail->Body = "consultoria";
         }
         else
         {
            $mail->Body = "other";
         }
         
         $mail->AddAddress($email);
         if(!$mail->Send()) 
         {
           echo "NO-Mailer error: " . $mail->ErrorInfo;
         } 
         else 
         {
           echo "OK";
         }
      }
   }
?>
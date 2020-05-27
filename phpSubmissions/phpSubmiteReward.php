<?php header('Content-Type: charset=utf-8');

setlocale(LC_ALL, 'Portuguese_Portugal.1252');

 use PHPMailer\PHPMailer\PHPMailer;
 use PHPMailer\PHPMailer\Exception;
 
 require 'D:/Xampp/htdocs/segaGest/formForClient/phpSubmissions/phpmailer/src/Exception.php';
 require 'D:/Xampp/htdocs/segaGest/formForClient/phpSubmissions/phpmailer/src/PHPMailer.php';
 require 'D:/Xampp/htdocs/segaGest/formForClient/phpSubmissions/phpmailer/src/SMTP.php';
 
   $conn = new mysqli("15.188.164.24", "root", "sayhitoevolution", "sabseg_database");
   if($conn->connect_error)
   {
      die("error:" . $conn->connect_error);
   } 

   $reward = $_POST['rewardVal'];
   $email = $_POST['emailVal'];

   $updateReward = "UPDATE `users` SET `reward`= '".$reward."' WHERE `email` = '".$email."'";
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
         //$mail->SMTPDebug = 0; // debugging: 1 = errors and messages, 2 = messages only
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

         // CAMISOLA
         if($sqlReward == "camisola")
         {
            $mail->Body = "<pre>Olá,

Desde já agradecemos a tua participação na Roleta Digital SABSEG!
O prémio que ganhaste, através da nossa Roleta, foi: Camisola Oficial

Para receberes o prémio, por favor, responde a este e-mail indicando-nos o tamanho pretendido e a morada para onde devemos enviar o prémio. Todos os prémios vão ser enviados por correio.

Após recebermos o teu e-mail vamos entrar em contacto contigo confirmando o prémio e a indicação da morada. 

Posteriormente, quando efetuarmos o envio para a tua morada, receberás, também, um e-mail com essa indicação!

Mais uma vez, muito obrigado por participares na Roleta Digital SABSEG.


Junta-te a nós e vive experiências inesquecíveis.
O futebol é a paixão que nos une.

<b>Celebramos o Futebol | SABSEG Seguros</b></pre>";
         }
         // CAMISOLA ALTERNATIVA
         else if($sqlReward == "camisolaAlt")
         {
            $mail->Body = "<pre>Olá,

Desde já agradecemos a tua participação na Roleta Digital SABSEG!
O prémio que ganhaste, através da nossa Roleta, foi: Camisola Oficial Alternativa

Para receberes o prémio, por favor, responde a este e-mail indicando-nos o tamanho pretendido e a morada para onde devemos enviar o prémio. Todos os prémios vão ser enviados por correio.

Após recebermos o teu e-mail vamos entrar em contacto contigo confirmando o prémio e a indicação da morada. 

Posteriormente, quando efetuarmos o envio para a tua morada, receberás, também, um e-mail com essa indicação!

Mais uma vez, muito obrigado por participares na Roleta Digital SABSEG.


Junta-te a nós e vive experiências inesquecíveis.
O futebol é a paixão que nos une.

<b>Celebramos o Futebol | SABSEG Seguros</b></pre>";
         }
         // SEGURO AUTOMOVEL
         else if($sqlReward == "seguro")
         {
            $mail->Body = "<pre>Olá,

Desde já agradecemos a tua participação na Roleta Digital SABSEG!
O prémio que ganhaste, através da nossa Roleta, foi: Seguro Automóvel (oferta da primeira anuidade)

Para receberes o prémio, por favor, responde a este e-mail demonstrando interesse pelo mesmo. Após recebermos o teu e-mail vamos entrar em contacto contigo! 

Mais uma vez, muito obrigado por participares na Roleta Digital SABSEG.

Junta-te a nós e vive experiências inesquecíveis.
O futebol é a paixão que nos une.

<b>Celebramos o Futebol | SABSEG Seguros</b></pre>";
         }
         // CONSULTORIA DE SEGUROS
         else if($sqlReward == "consultoria")
         {
            $mail->Body = "<pre>Olá,

Desde já agradecemos a tua participação na Roleta Digital SABSEG!
O prémio que ganhaste, através da nossa Roleta, foi: Consultoria de todos os teus seguros
            
Para receberes o prémio, por favor, responde a este e-mail demonstrando interesse pelo mesmo. Após recebermos o teu e-mail vamos entrar em contacto contigo! 
            
Mais uma vez, muito obrigado por participares na Roleta Digital SABSEG.
            
Junta-te a nós e vive experiências inesquecíveis.
O futebol é a paixão que nos une.

            
<b>Celebramos o Futebol | SABSEG Seguros</b></pre>";
         }
         // OTHER
         else
         {
            $mail->Body = "<pre>Olá,

Desde já agradecemos a tua participação na Roleta Digital SABSEG!
O prémio que ganhaste, através da nossa Roleta, foi: $sqlReward 

Para receberes o prémio, por favor, responde a este e-mail indicando-nos a morada para onde devemos enviar o prémio. Todos os prémios vão ser enviados por correio.

Após recebermos o teu e-mail vamos entrar em contacto contigo confirmando o prémio e a indicação da morada. 

Posteriormente, quando efetuarmos o envio para a tua morada, receberás, também, um e-mail com essa indicação!

Mais uma vez, muito obrigado por participares na Roleta Digital SABSEG.

Junta-te a nós e vive experiências inesquecíveis.
O futebol é a paixão que nos une.


<b>Celebramos o Futebol | SABSEG Seguros</b></pre>";
         }

         $mail->AddAddress($email);
         if(!$mail->Send()) 
         {
           echo "NO-Mailer error: " . $mail->ErrorInfo;
         } 
         else 
         {
            echo "OK-";
         }
      }
   }
?>
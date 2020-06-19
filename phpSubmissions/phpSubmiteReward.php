<?php header('Content-Type: charset=utf-8');

   setlocale(LC_ALL, 'Portuguese_Portugal.1252');

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

   mysqli_set_charset($conn, "utf8"); // TA-DA

   $reward = $_POST['rewardVal'];
   $email = $_POST['emailVal'];

   $updateReward = "UPDATE `users` SET `reward`= '".$reward."' WHERE `email` = '".$email."'";
   if($conn->query($updateReward) === FALSE)
   {
      echo("NO-Não deu update á recompensa");
   }
   else
   {
      $getReward = "SELECT reward FROM users WHERE email = '" . $email . "'";
      $rewardConn = $conn->query($getReward);
      if ($rewardConn->num_rows == 0)
      {
         echo "NO-Erro a encontrar a recompensa";
      }
      else
      {
         // Current user reward
         $sqlReward = mysqli_fetch_row($conn->query($getReward))[0];
         // Get reward fullname
         $getRewardName = "SELECT reward_name FROM rewards WHERE index_name = '" . $sqlReward . "'";
         if($conn->query($getRewardName)->num_rows == 0)
         {
            echo ("NO-Error a encontrar o nome da recompensa");
         }
         else
         {
            $sqlRewardName = mysqli_fetch_row($conn->query($getRewardName))[0];

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
            $mail->Subject = "Celebramos Futebol | SABSEG Seguros: Roleta Digital";

            // CAMISOLA
            if($sqlReward == "camisola")
            {
               $mail->Body = "Ola,

<p>Desde ja agradecemos a tua participacao na Roleta Digital SABSEG!<br>
O premio que ganhaste, atraves da nossa Roleta, foi: $sqlRewardName</p>

<p>Para receberes o premio, por favor, responde a este e-mail indicando-nos o tamanho pretendido e a morada para onde devemos enviar o prémio. Todos os premios vao ser enviados por correio.</p>

<p>Apos recebermos o teu e-mail vamos entrar em contacto contigo confirmando o premio e a indicacao da morada.</p>

<p>Posteriormente, quando efetuarmos o envio para a tua morada, receberas, tambem, um e-mail com essa indicacao!</p>

<p>Mais uma vez, muito obrigado por participares na Roleta Digital SABSEG.</p>


<p>Junta-te a nós e vive experiencias inesqueciveis.<br>
O futebol é a paixao que nos une.</p>

<p><b>Celebramos o Futebol | SABSEG Seguros</b></p>";
            }
            // CAMISOLA ALTERNATIVA
            else if($sqlReward == "camisolaAlt")
            {
               $mail->Body = "Ola,

<p>Desde ja agradecemos a tua participacao na Roleta Digital SABSEG!<br>
O premio que ganhaste, atraves da nossa Roleta, foi: $sqlRewardName</p>

<p>Para receberes o premio, por favor, responde a este e-mail indicando-nos o tamanho pretendido e a morada para onde devemos enviar o premio. Todos os premios vao ser enviados por correio.</p>

<p>Após recebermos o teu e-mail vamos entrar em contacto contigo confirmando o premio e a indicacao da morada.</p> 

<p>Posteriormente, quando efetuarmos o envio para a tua morada, receberas, tambem, um e-mail com essa indicacao!</p>

<p>Mais uma vez, muito obrigado por participares na Roleta Digital SABSEG.</p>


<p>Junta-te a nos e vive experiencias inesqueciveis.<br>
O futebol e a paixao que nos une.</p>

<p><b>Celebramos o Futebol | SABSEG Seguros</b></p>";
            }
            // SEGURO AUTOMOVEL
            else if($sqlReward == "seguro")
            {
               $mail->Body = "Ola,

<p>Desde ja agradecemos a tua participação na Roleta Digital SABSEG!<br>
O premio que ganhaste, atraves da nossa Roleta, foi: $sqlRewardName (oferta da primeira anuidade)</p>

<p>Para receberes o premio, por favor, responde a este e-mail demonstrando interesse pelo mesmo. Apos recebermos o teu e-mail vamos entrar em contacto contigo!</p>

<p>Mais uma vez, muito obrigado por participares na Roleta Digital SABSEG.</p>

<p>Junta-te a nos e vive experiencias inesqueciveis.<br>
O futebol e a paixao que nos une.</p>

<p><b>Celebramos o Futebol | SABSEG Seguros</b></p>";
            }
            // CONSULTORIA DE SEGUROS
            else if($sqlReward == "consultoria")
            {
               $mail->Body = "Ola,

<p>Desde ja agradecemos a tua participacao na Roleta Digital SABSEG!<br>
O premio que ganhaste, atraves da nossa Roleta, foi: $sqlRewardName</p>
            
<p>Para receberes o premio, por favor, responde a este e-mail demonstrando interesse pelo mesmo. Apos recebermos o teu e-mail vamos entrar em contacto contigo!</p> 
            
<p>Mais uma vez, muito obrigado por participares na Roleta Digital SABSEG.</p>
            
<p>Junta-te a nos e vive experiencias inesqueciveis.<br>
O futebol e a paixao que nos une.</p>

            
<p><b>Celebramos o Futebol | SABSEG Seguros</b></p>";
            }
            // OTHER
            else
            {
               $mail->Body = "Ola,

<p>Desde ja agradecemos a tua participacao na Roleta Digital SABSEG!<br>
O premio que ganhaste, atraves da nossa Roleta, foi: $sqlRewardName</p>

<p>Para receberes o premio, por favor, responde a este e-mail indicando-nos a morada para onde devemos enviar o premio. Todos os premios vao ser enviados por correio.</p>

<p>Apos recebermos o teu e-mail vamos entrar em contacto contigo confirmando o premio e a indicacao da morada.</p> 

<p>Posteriormente, quando efetuarmos o envio para a tua morada, receberas, tambem, um e-mail com essa indicacao!</p>

<p>Mais uma vez, muito obrigado por participares na Roleta Digital SABSEG.</p>

<p>Junta-te a nos e vive experiencias inesqueciveis.<br>
O futebol e a paixao que nos une.</p>


<p><b>Celebramos o Futebol | SABSEG Seguros</b></p>";
            }

            $mail->AddAddress($email);
            if(!$mail->Send()) 
            {
              echo "NO-Mailer error: " . $mail->ErrorInfo;
            } 
            else 
            {
               echo "OK-" . $sqlRewardName;
            }
         }
      }
   }
?>
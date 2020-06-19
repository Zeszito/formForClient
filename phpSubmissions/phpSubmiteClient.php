<?php header('Content-Type: charset=utf-8');

  setlocale(LC_ALL, 'Portuguese_Portugal.1252');

  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\Exception;
  
  require '/opt/lampp/htdocs/roleta/phpSubmissions/phpmailer/src/Exception.php';
  require '/opt/lampp/htdocs/roleta/phpSubmissions/phpmailer/src/PHPMailer.php';
  require '/opt/lampp/htdocs/roleta/phpSubmissions/phpmailer/src/SMTP.php';


  // Make connection to database
  $conn = new mysqli("15.188.164.24", "root", "sayhitoevolution", "sabseg_database");
  if($conn->connect_error)
  {
     die("error:" . $conn->connect_error);
  } 

  mysqli_set_charset($conn, "utf8"); // TA-DA

  $name = $_POST['nomeVal'];
  $email = $_POST['emailVal'];
  $birthDate = $_POST['dataNascimentoVal'];
  $locality = $_POST['localidadeVal'];
  $nif = $_POST['nifVal'];
  $cellphone = $_POST['telemovelVal'];
  $club = $_POST['clubVal'];
  $auto = (isset($_POST['autoVal'])) ? 1: 0;
  $life = (isset($_POST['vidaVal'])) ? 1: 0;
  $health = (isset($_POST['saudeVal'])) ? 1: 0;
  $house = (isset($_POST['casaVal'])) ? 1: 0;
  $other = (isset($_POST['outroVal'])) ? 1: 0;
  //TESTE
   //echo  "---------------------------\n".
   //       "APENAS PARA DEBUG ONLY!!!!!".
   //      "\nnome-".$name. "\nemail-".$email."\ndataNas-".$birthDate."\nlocal-".$locality."\nnif-".$nif.
   //      "\ntelemo-".$cellphone."\nclub-".$club."\nTem auto?-".$auto."\nTem vida?-".$life."\nTem saude?-".$health."\nTem casa?-".$house.
   //     "\nTem outro?-".$other."\n---------------------------";



   //0 - Verify if name is not empety
   if (empty($name)) 
   {  
     echo "NO-Preencha o nome, este não pode ser vazio";
   } 


  // 1- Verify if email exists
  $sqlVerifyEmail = "SELECT email FROM users WHERE email = '" . $email . "'";
  if ($conn->query($sqlVerifyEmail)->num_rows > 0) 
  {
    // Tell user that that name is already taken
    echo "NO-Este email já foi registado.";
  } 
  else 
  {
    // 2- Verify if email is valid
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) 
    {
      echo("NO-O email inserido não é válido.\n");
    } 
    else 
    {
      // 3- Verify if nif exists
      $sqlNif = "SELECT nif FROM users WHERE nif = '".$nif."'";
      if ($conn->query($sqlNif)->num_rows > 0)
      {
        // Tell user that that name is already taken
        echo "NO-Este nif já foi registado.";
      }
      else
      {
        // 4- Verify nif
        if(!binif_isvalid($nif))
        {
          echo "NO-NIF invalido.";
        }
        else
        {
          // 5- Verify phoneNumber
          if (!phonenumber_isvalid($cellphone))
          {
            echo "NO-Numero de telefone inválido.";
          }
          else 
          {
            // 6- Verify if district is valid
            $select_district = "SELECT `name` FROM `districts` WHERE `name` = '".$locality."'";
            if($conn->query($select_district)->num_rows == 0)
            {
              echo "NO-Ups... Escolha o seu distrito";
            }
            else
            {
              // 7- Verify if club is valid
              $select_club = "SELECT `name` FROM `clubs` WHERE `name` = '".$club."'";
              if($conn->query($select_club)->num_rows == 0)
              {
                echo "NO-Ups... Escolha o seu clube.";
              }
              else 
              {
                // 8- Verify if date is valid
                if(!birthdate_isvalid($birthDate))
                {
                  echo "NO-Ups... Insira uma data de nascimento válida.";
                }
                else
                {
                  // Dados validos, executar registo
                  $sqlCommand = "INSERT INTO `users`(`email`, `name`, `birthDate`, `locality`, `nif`, `cellphone`, `club`, `auto`, `life`, `health`, `house`, `other`, `reward`) 
                  VALUES ('".$email."','".$name."','".$birthDate."','".$locality."','".$nif."','".$cellphone."','".$club."','".$auto."','".$life."','".$health."','".$house."','".$other."','0')";
                  if ($conn->query($sqlCommand) === TRUE) 
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
Os teus dados foram submetidos com sucesso, pelo que te encontras registado no Celebramos Futebol, um site dedicado a todos os verdadeiros adeptos de futebol!</p>
                    
<p>Junta-te a nos e vive experincias inesqueciveis.<br>
O futebol e a paixao que nos une.</p>
                    

<p><p><b>Celebramos o Futebol | SABSEG Seguros</b></p></p>";
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
                  else
                  {
                    echo "NO-Não foi possivel inserir os dados na base de dados, tente mais tarde.";
                  }
                }
              }
            }
          }
        }
      }
    }
  }

  function birthdate_isvalid($date)
  {
    if($date == "")
    {
      return false;
    }

    $bday = new DateTime($date);
    $bday->add(new DateInterval("P18Y")); //adds time interval of 18 years to bday  
    if($bday < new DateTime())
    {   
        return true;
    }
    else
    {  
        return false;
    }
  }

  function phonenumber_isvalid($nr)
  {
    if(mb_strlen($nr) != 9)
    {
      return false;
    }
    if ((substr(trim($nr), 0, 2) == '91') || (substr(trim($nr), 0, 2) == '92') || (substr(trim($nr), 0, 2) == '93')|| (substr(trim($nr), 0, 2) == '96'))
    {
      return true;
    }
    else
    {
      return false;
    }
  }
  function binif_isvalid($nr)
  {
    if(mb_strlen($nr) != 9)
    {
      return false;
    }

    if (!ctype_digit($nr)) 
    {
      return false;
    }

    while (strlen($nr) < 9) 
    {
       $nr = "0" . $nr;
    }

    $calc = 9 * $nr[0] + 8 * $nr[1] + 7 * $nr[2] + 6 * $nr[3] + 5 * $nr[4] + 4 * $nr[5] + 3 * $nr[6] + 2 * $nr[7] + $nr[8];

    if ($calc % 11 === 0) {
       return true;
    }
    else if($nr[8] === 0 && ($calc + 10) % 11 === 0) {
       return true;
    }
    else {
       return false;
    }
  }  
?>
<?php
 //Repostas:
    //OK - Eu passo para a roda
    //Qualquer outra eu escrevo no topo da pagina
    //Erros de php eu digo só "Desculpe Erro Interno Tente mais tarde"


    

//Aqui para o ficheiro que faz a conecção
//include "phpSubmissions\phpConection.php";
$conn = new mysqli("15.188.164.24", "root", "sayhitoevolution", "sabseg_database");
if($conn->connect_error)
{
   die("error:" . $conn->connect_error);
} 
else
{
  echo "Connected!";
}

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
echo  "---------------------------\n".
        "APENAS PARA DEBUG ONLY!!!!!".
       "\nnome-".$name. "\nemail-".$email."\ndataNas-".$birthDate."\nlocal-".$locality."\nnif-".$nif.
       "\ntelemo-".$cellphone."\nclub-".$club."\nTem auto?-".$auto."\nTem vida?-".$life."\nTem saude?-".$health."\nTem casa?-".$house.
       "\nTem outro?-".$other."\n---------------------------";
  
  
// 1- Verify if email exists
$sqlVerifyEmail = "SELECT email FROM users WHERE email = '" . $email . "'";
$resultVerifyEmail = $conn->query($sqlVerifyEmail);
if ($resultVerifyEmail->num_rows > 0) 
{
  // Tell user that that name is already taken
  echo "NO-The email is already registered.";
} 
else 
{
  // 2- Verify if email is valid
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) 
  {
    echo("NO-Not a valid email address.\n");
  } 
  else 
  {
    // 3- Verify if nif exists
    $sqlNif = "SELECT nif FROM users WHERE email = '" . $email . "' AND nif = '".$nif."'";
    $resultNif = $conn->query($sqlNif);
    if ($resultNif->num_rows > 0)
    {
      // Tell user that that name is already taken
      echo "NO-The nif is already registered.";
    }
    else
    {
      // 4- Verify nif
      if(!binif_isvalid($nif))
      {
        echo "NO-BI invalido";
      }
      else
      {
        // 5- Verify phoneNumber
        if (!phonenumber_isvalid($cellphone))
        {
          echo "NO-Numero de telefone inválido";
        }
        else 
        {
          // Dados validos, executar registo
          $sqlCommand = "INSERT INTO users('".$email."','".$name."','".$birthDate."','".$locality."','".$nif."','".$cellphone."','".$club."','".$auto."','".$life."','".$health."','".$house."','".$other."')";
          echo "OK";
          if ($conn->query($sqlCommand) === TRUE) 
          {
            // Send email
            $mail = new PHPMailer();
            $mail->IsSMTP(); // enable SMTP
            $mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
            $mail->SMTPAuth = true; // authentication enabled
            $mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail
            $mail->Host = "smtp.gmail.com";
            $mail->Port = 465; // or 587
            $mail->IsHTML(true);
            $mail->Username = "hivolvept@gmail.com";
            $mail->Password = "sayhitoevolutionemail";
            $mail->SetFrom("hivolvept@gmail.com");
            $mail->Subject = "Sabseg Roleta: Obrigado pelo registo";
            //$mail->Body = "<a href='http://15.188.164.24/FriconBackend/EmailVerification.php?vKey=$vkey'>Verify Account</a>";
            $mail->Body = "Funcionou";
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
          else
          {
            echo "NO-Não foi possivel inserir os dados na base de dados!"
          }
        }
      }
    }
  }
}


function phonenumber_isvalid($nr)
{
  if(strlen($nr != 9 ))
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
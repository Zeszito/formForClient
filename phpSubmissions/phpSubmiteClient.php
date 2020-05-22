<?php
 //Repostas:
    //OK - Eu passo para a roda
    //Qualquer outra eu escrevo no topo da pagina
    //Erros de php eu digo só "Desculpe Erro Interno Tente mais tarde"



 //Aqui para o ficheiro que faz a conecção
 //include "phpSubmissions\phpConection.php";
 $con = mysqli_connect("15.236.164.101", "root", "sayhitoevolution", "sabseg_database");

 if(mysqli_connect_error())
 {

     echo "Failed my connection : ";

 } 


 $name = $_POST['nomeVal'];
 $email = $_POST['emailVal'];
 $birthDate = $_POST['dataNascimentoVal'];
 $locality = $_POST['localidadeVal'];
 $nif = $_POST['nifVal'];
 $cellphone = $_POST['telemovelVal'];
 $club = isset($_POST['clubVal']);
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
    echo "The email is already registered.";
  } 
  else 
  {
    // 2- Verify if nif exists
    $sqlNif = "SELECT nif FROM users WHERE email = '" . $email . "' AND nif = '".$nif."'";
    $resultNif = $conn->query($sqlNif);
    if ($resultNif->num_rows > 0)
    {
      // Tell user that that name is already taken
      echo "The nif is already registered.";
    }
    else
    {
      // 3- Verify nif
      if(!binif_isvalid($nif)
      {
        echo "BI invalido";
      }
      else
      {
        echo "BI válido";
        // 4- Verify phoneNumber
        if (!phonenumber_isvalid($cellphone))
        {
          echo "Numero de telefone inválido";
        }
        else 
        {
          // Dados validos, executar registo
          $sqlCommand = "INSERT INTO users('".$email."','".$name."','".$birthDate."','".$locality."','".$nif."','".$cellphone."','".$club."','".$auto."','".$life."','".$health."','".$house."','".$other."')";
          $result = $con->query($sqlCommand);
          echo $result;

          echo "OK";
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
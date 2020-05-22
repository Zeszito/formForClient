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
  
  
 //Aqui Vai as verificações
 /**Verificar se o email já existe -BD */
 /**Verificar nif - Regex*/
 /**verificar telemovel - Regex*/
 //

  //Aqui vai o INSERT PARA A BASE DE DADOS
  $sqlCommand = "INSERT INTO users('".$email."','".$name."','".$birthDate."','".$locality."','".$nif."','".$cellphone."','".$club."','".$auto."','".$life."','".$health."','".$house."','".$other."')";

  $result = $con->query($sqlCommand);

  echo $result;
?>
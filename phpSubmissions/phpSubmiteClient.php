<?php
 //Repostas:
    //OK - Eu passo para a roda
    //Qualquer outra eu escrevo no topo da pagina
    //Erros de php eu digo só "Desculpe Erro Interno Tente mais tarde"



 //Aqui para o ficheiro que faz a conecção
 //include "connection.php";
  
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


  //Aqui vai o INSERT PARA A BASE DE DADOS
  //$sqlCommand = "INSERT INTO `jogador`(`name`, `email`, `highScore`) VALUES ('$user','chi@mail.com','$pontos')";

  //$result = $con->query($sqlCommand);

?>
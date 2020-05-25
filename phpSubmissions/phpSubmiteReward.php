<?php
 //Repostas:
    //OK - Eu passo para a roda
    //Qualquer outra eu escrevo no topo da pagina
    //Erros de php eu digo só "Desculpe Erro Interno Tente mais tarde"



   //Aqui para o ficheiro que faz a conecção
   //include "connection.php";
  
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
   $reward ? $_POST['rewardVal'];

   //TESTE
   echo  "---------------------------\n".
        "APENAS PARA DEBUG!!!!!".
       "\nnome-".$name. "\nemail-".$email."\n---------------------------";

   //1-Verificar se email esta registado
   $updateReward = "UPDATE `users` SET `reward`=$reward WHERE `email` = $email";
   if($conn->query($updateReward) === FALSE)
   {
      echo("NO-Este email não foi ainda registado");
   }
   else
   {
      echo "OK-Parabéns voçe ganhou";
   }
?>
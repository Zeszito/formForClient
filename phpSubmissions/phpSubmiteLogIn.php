<?php
 //Repostas:
    //OK - Eu passo para a roda
    //Qualquer outra eu escrevo no topo da pagina
    //Erros de php eu digo só "Desculpe Erro Interno Tente mais tarde"



 //Aqui para o ficheiro que faz a conecção
 //include "connection.php";
  
 $name = $_POST['nomeVal'];
 $email = $_POST['emailVal'];

 

//TESTE
 echo  "---------------------------\n".
        "APENAS PARA DEBUG ONLY!!!!!".
       "\nnome-".$name. "\nemail-".$email."\n---------------------------";
  //Aqui Vai as verificações
  $accountVerify = "SELECT email FROM users WHERE email = '".$email."'";
  $accountVerifyResult = $conn->query($accountVerify);
  
  if($accountVerifyResult->num_rows == 0)
  {
      die("Email not found on database");
  }
  else
  {
     echo "OK";
  }

  //Aqui vai o INSERT PARA A BASE DE DADOS
  //$sqlCommand = "INSERT INTO `jogador`(`name`, `email`, `highScore`) VALUES ('$user','chi@mail.com','$pontos')";

  //$result = $con->query($sqlCommand);

?>
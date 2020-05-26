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
    // echo "Connected!";
   }

   $email = $_POST['emailVal'];

   //TESTE
   /*echo  "---------------------------\n".
        "APENAS PARA DEBUG!!!!!".
        "\nemail-".$email."\n---------------------------";*/

   //1-Verificar se email esta registado
   $accountVerify = "SELECT email FROM users WHERE email = '".$email."'";
   if($conn->query($accountVerify)->num_rows == 0)
   {
      echo("NO-Este email não foi ainda registado");
   }
   else
   {
      // 2-Verificar se já jogou
      $selectReward = "SELECT reward FROM users WHERE email = '".$email."' AND reward != '0'";
      if ($conn->query($selectReward)->num_rows > 0) 
      {
         echo"NO-Voçê já jogou á roleta";
      }
      else
      {
         $clubSelect = "SELECT `club` FROM `users` WHERE email = '" . $email . "'";
         $clubResult = $conn->query($clubSelect);
         if ( $clubResult->num_rows == 0) 
         {
            echo "NO-Error getting club";
         }
         else
         {
            $club = mysqli_fetch_row($clubResult);
            echo "OK-".$club[0];
         }
      }
   }
?>
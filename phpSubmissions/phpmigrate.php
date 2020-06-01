<?php 
    header('Content-Type: charset=utf-8');
    setlocale(LC_ALL, 'Portuguese_Portugal.1252');

    // MAKE SQLI CONNECTION
    $conn = new mysqli("15.188.164.24", "root", "sayhitoevolution", "sabseg_registered_already");
    if($conn->connect_error)
    {
       die ("error:" . $conn->connect_error);
    } 
    $connBase = new mysqli("15.188.164.24", "root", "sayhitoevolution", "sabseg_database");
    if($connBase->connect_error)
    {
       die ("error:" . $connBase->connect_error);
    } 
    mysqli_set_charset($conn, "utf8");
    mysqli_set_charset($connBase, "utf8");

    $array = array();
    $getUSerMail= "SELECT `mail`,`teamName` FROM `users`";
    if($conn->query($getUSerMail)->num_rows == 0)
    {
        echo "error finding values";
    }
    else
    {
        if ($result = $conn->query($getUSerMail)) 
        {
            /* fetch associative array */
            while ($row = $result->fetch_assoc()) 
            {
                $sqlCommand = "INSERT INTO `users`(`email`, `name`, `birthDate`, `locality`, `nif`, `cellphone`, `club`, `auto`, `life`, `health`, `house`, `other`, `reward`) 
                  VALUES ('".$row["mail"]."','none','none','none','none','none','".$row["teamName"]."','0','0','0','0','0','0')";

                if ($connBase->query($sqlCommand) === TRUE) 
                {
                  echo "Inserted";
                }
                else
                {
                  echo $connBase->error;
                }
            }
        
            /* free result set */
            $result->free();
        }
    }
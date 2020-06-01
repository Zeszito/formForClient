<?php 
    header('Content-Type: charset=utf-8');
    setlocale(LC_ALL, 'Portuguese_Portugal.1252');

    // MAKE SQLI CONNECTION
    $conn2 = new mysqli("15.188.164.24", "root", "sayhitoevolution", "sabseg_registered_already");
    if($conn2->connect_error)
    {
       die ("error:" . $conn2->connect_error);
    } 

    mysqli_set_charset($conn2, "utf8");

    $array = array();
    $getUSerMail= "SELECT mail, teamName FROM users";
    if($conn->query($getUSerMail)->num_rows == 0)
    {
        $array[] =  mysqli_fetch_row($conn->query($getUSerMail))[0];
    }
    
    for ($i=0; $i < conn->query($getUSerMail; $i++){ $array[] = "consultoria"; }
    echo 
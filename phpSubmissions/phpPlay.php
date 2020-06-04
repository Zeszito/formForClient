<?php 
    header('Content-Type: charset=utf-8');
    setlocale(LC_ALL, 'Portuguese_Portugal.1252');

    // MAKE SQLI CONNECTION
    $conn = new mysqli("15.188.164.24", "root", "sayhitoevolution", "sabseg_database");
    if($conn->connect_error)
    {
       die ("error:" . $conn->connect_error);
    } 

    mysqli_set_charset($conn, "utf8");

    // POSTS
    $email = $_POST['emailVal'];

    //1-Verificar se email esta registado
    $accountVerify = "SELECT email FROM users WHERE email = '".$email."'";
    if($conn->query($accountVerify)->num_rows == 0)
    {
       echo ("NO-Este email não foi ainda registado.");
    }
    else
    {
        // 2 testar club
        $selectUserClub = "SELECT club FROM users WHERE email = '".$email."'";
        if($conn->query($selectUserClub)->num_rows == 0)
        {
           echo ("NO-Erro a encontrar club.");
        }
        else
        {
            // 3- Verificar se o club esta na data base
            $userClub = mysqli_fetch_row($conn->query($selectUserClub))[0];
            $selectClub = "SELECT `sponsored` FROM `clubs` WHERE `name` = '".$userClub."'";
            if($conn->query($selectClub)->num_rows == 0)
            {
               echo ("NO-Ups...Desculpa, mas não reúnes todos os termos e condições do regulamento deste passatempo.");
            }
            else
            {
                // 4- Verificar se o club é valido
                if(mysqli_fetch_row($conn->query($selectClub))[0] == 0)
                {
                    echo ("NO-Ups...Desculpa, mas não reúnes todos os termos e condições do regulamento deste passatempo.");
                }
                else
                {
                    // 5-Verificar se já jogou
                    $selectReward = "SELECT reward FROM users WHERE email = '".$email."' AND reward != '0'";
                    if ($conn->query($selectReward)->num_rows > 0) 
                    {
                        echo ("NO-Ups.. Parece que já participou na Roleta SABSEG. Segundo o regulamento do jogo apenas pode participar uma vez.");
                    }
                    else
                    {
                        $clubSelect = "SELECT `club` FROM `users` WHERE email = '" . $email . "'";
                        $clubResult = $conn->query($clubSelect);
                        if ( $clubResult->num_rows == 0) 
                        {
                            echo ("NO-Ups... Erro a encontrar o club do utilizador.");
                        }
                        else
                        {
                            $club = mysqli_fetch_row($clubResult)[0];
                            //Get club remaining rewards
                            $selectRewardCount = "SELECT `reward_count` FROM `clubs` WHERE `name` = '".$club."'";
                            if($conn->query($selectRewardCount)->num_rows <= 0)
                            {
                                echo ("NO-Ups... Erro a encontrar o numero de recompensas do club");
                            }
                            else
                            {
                                //Club reward count
                                $club_reward_count = mysqli_fetch_row($conn->query($selectRewardCount))[0];
                                if($club_reward_count <= 0)
                                {
                                    echo ("NO-Ups...O número máximo de participações já foi atingido. Fica atento nas próximas jornadas e tenta a tua sorte!");
                                }
                                else
                                {
                                    $select_consultoria_count = "SELECT `consultoria` FROM `clubs` WHERE `name` = '".$club."'";
                                    $select_camisola_count = "SELECT `camisola` FROM `clubs` WHERE `name` = '".$club."'";
                                    $select_kit_count = "SELECT `kit` FROM `clubs` WHERE `name` = '".$club."'";
                                    $select_cachecol_count = "SELECT `cachecol` FROM `clubs` WHERE `name` = '".$club."'";
                                    $select_bola_count = "SELECT `bola` FROM `clubs` WHERE `name` = '".$club."'";
                                    $select_powerbank_count = "SELECT `powerbank` FROM `clubs` WHERE `name` = '".$club."'";
                                    $select_coluna_count = "SELECT `coluna` FROM `clubs` WHERE `name` = '".$club."'";
                                    $select_camisolaAlt_count = "SELECT `camisolaAlt` FROM `clubs` WHERE `name` = '".$club."'";
                                    $select_bone_count = "SELECT `bone` FROM `clubs` WHERE `name` = '".$club."'";
                                    $select_mochila_count = "SELECT `mochila` FROM `clubs` WHERE `name` = '".$club."'";

                                    $consultoria_count = mysqli_fetch_row($conn->query($select_consultoria_count))[0];
                                    $camisola_count = mysqli_fetch_row($conn->query($select_camisola_count))[0];
                                    $kit_count = mysqli_fetch_row($conn->query($select_kit_count))[0];
                                    $cachecol_count = mysqli_fetch_row($conn->query($select_cachecol_count))[0];
                                    $bola_count = mysqli_fetch_row($conn->query($select_bola_count))[0];
                                    $powerbank_count = mysqli_fetch_row($conn->query($select_powerbank_count))[0];
                                    $coluna_count = mysqli_fetch_row($conn->query($select_coluna_count))[0];
                                    $camisolaAlt_count = mysqli_fetch_row($conn->query($select_camisolaAlt_count))[0];
                                    $bone_count = mysqli_fetch_row($conn->query($select_bone_count))[0];
                                    $mochila_count = mysqli_fetch_row($conn->query($select_mochila_count))[0];

                                    $array = array();
                                    
                                    for ($i=0; $i < $consultoria_count; $i++){ $array[] = "consultoria"; }
                                    for ($i=0; $i < $camisola_count; $i++){ $array[] = "camisola"; }
                                    for ($i=0; $i < $kit_count; $i++){ $array[] = "kit"; }
                                    for ($i=0; $i < $cachecol_count; $i++){ $array[] = "cachecol"; }
                                    for ($i=0; $i < $bola_count; $i++){ $array[] = "bola"; }
                                    for ($i=0; $i < $powerbank_count; $i++){ $array[] = "powerbank"; }
                                    for ($i=0; $i < $coluna_count; $i++){ $array[] = "coluna"; }
                                    for ($i=0; $i < $camisolaAlt_count; $i++){ $array[] = "camisolaAlt"; }
                                    for ($i=0; $i < $bone_count; $i++){ $array[] = "bone"; }
                                    for ($i=0; $i < $mochila_count; $i++){ $array[] = "mochila"; }

                                    $rand_key = array_rand($array, 1);
                                    $reward = $array[$rand_key];

                                    if($reward == "consultoria") {$update_club_decrement_reward = "UPDATE `clubs` SET `consultoria` = `consultoria` - 1 WHERE `name` = '".$club."' AND `consultoria` > 0"; }
                                    else if($reward == "camisola") {$update_club_decrement_reward = "UPDATE `clubs` SET `camisola` = `camisola` - 1 WHERE `name` = '".$club."' AND `camisola` > 0";}
                                    else if($reward == "kit") {$update_club_decrement_reward = "UPDATE `clubs` SET `kit` = `kit` - 1 WHERE `name` = '".$club."' AND `kit` > 0";}
                                    else if($reward == "cachecol") {$update_club_decrement_reward = "UPDATE `clubs` SET `cachecol` = `cachecol` - 1 WHERE `name` = '".$club."' AND `cachecol` > 0";}
                                    else if($reward == "bola") {$update_club_decrement_reward = "UPDATE `clubs` SET `bola` = `bola` - 1 WHERE `name` = '".$club."' AND `bola` > 0";}
                                    else if($reward == "powerbank") {$update_club_decrement_reward = "UPDATE `clubs` SET `powerbank` = `powerbank` - 1 WHERE `name` = '".$club."' AND `powerbank` > 0";}
                                    else if($reward == "coluna") {$update_club_decrement_reward = "UPDATE `clubs` SET `coluna` = `coluna` - 1 WHERE `name` = '".$club."' AND `coluna` > 0";}
                                    else if($reward == "camisolaAlt") {$update_club_decrement_reward = "UPDATE `clubs` SET `camisolaAlt` = `camisolaAlt` - 1 WHERE `name` = '".$club."' AND `camisolaAlt` > 0";}
                                    else if($reward == "bone") {$update_club_decrement_reward = "UPDATE `clubs` SET `bone` = `bone` - 1 WHERE `name` = '".$club."' AND `bone` > 0";  }
                                    else if($reward == "mochila") {$update_club_decrement_reward = "UPDATE `clubs` SET `mochila` = `mochila` - 1 WHERE `name` = '".$club."' AND `mochila` > 0";}
                                    else { echo "NO-Ups erro a jogar, tente novamente.";die;}

                                    if($conn->query($update_club_decrement_reward) === FALSE)
                                    {
                                        echo("W8-Ups... Tente novamente.");
                                        die;
                                    })
                                    else
                                    {
                                        $update_club_reward_count = "UPDATE `clubs` SET `reward_count` = `reward_count` - 1 WHERE `name` = '".$club."' AND `reward_count` > 0 ";
                                        if($conn->query($update_club_reward_count) === FALSE)
                                        {
                                            echo("NO-Ups... Tente novamente.");
                                        }
                                        else
                                        {
                                            $updateReward = "UPDATE `users` SET `reward`= '".$reward."' WHERE `email` = '".$email."'";
                                            if($conn->query($updateReward) === FALSE)
                                            {
                                               echo("NO-Não deu update á recompensa");
                                            }
                                            else
                                            {
                                                echo "OK-" . $reward;
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
?>
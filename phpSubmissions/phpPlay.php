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
               echo ("NO-Erro a encontrar club do utilizador.");
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
                                if($club_reward_count == 0)
                                {
                                    echo ("NO-O numero de recompensas acabaram, volte a jogar no próximo jogo do seu clube.");
                                }
                                else
                                {
                                    echo "NO-entrou";

                                    $select_consultoria_count = "SELECT `consultoria_count` FROM `clubs` WHERE `name` = '".$club."'";
                                    $select_camisola_count    = "SELECT `camisola_count` FROM `clubs` WHERE `name` = '".$club."'";
                                    $select_kit_count         = "SELECT `kit_count` FROM `clubs` WHERE `name` = '".$club."'";
                                    $select_cachecol_count    = "SELECT `cachecol_count` FROM `clubs` WHERE `name` = '".$club."'";
                                    $select_bola_count        = "SELECT `bola_count` FROM `clubs` WHERE `name` = '".$club."'";
                                    $select_powerbank_count   = "SELECT `powerbank_count` FROM `clubs` WHERE `name` = '".$club."'";
                                    $select_coluna_count      = "SELECT `coluna_count` FROM `clubs` WHERE `name` = '".$club."'";
                                    $select_camisolaAlt_count = "SELECT `camisolaAlt_count` FROM `clubs` WHERE `name` = '".$club."'";
                                    $select_bone_count        = "SELECT `bone_count` FROM `clubs` WHERE `name` = '".$club."'";
                                    $select_mochila_count     = "SELECT `mochila_count` FROM `clubs` WHERE `name` = '".$club."'";

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
                                    
                                    for ($i=0; $i < $consultoria_count; $i++) { $array[] = "consultoria"; }
                                    for ($i=0; $i < $camisola_count; $i++) { $array[] = "camisola"; }
                                    for ($i=0; $i < $kit_count; $i++) { $array[] = "kit"; }
                                    for ($i=0; $i < $cachecol_count; $i++) { $array[] = "cachecol"; }
                                    for ($i=0; $i < $bola_count; $i++) { $array[] = "bola"; }
                                    for ($i=0; $i < $powerbank_count; $i++) { $array[] = "powerbank"; }
                                    for ($i=0; $i < $coluna_count; $i++) { $array[] = "coluna"; }
                                    for ($i=0; $i < $camisolaAlt_count; $i++) { $array[] = "camisolaAlt"; }
                                    for ($i=0; $i < $bone_count; $i++) { $array[] = "bone"; }
                                    for ($i=0; $i < $mochila_count; $i++) { $array[] = "mochila"; }

                                    $rand_key = array_rand($array, 1);

                                    $update_club_reward_decremented = "UPDATE `clubs` SET `reward_count` = $club_reward_count - 1 WHERE `name` = '".$club."'";
                                    $update_club_reward_count = "UPDATE `clubs` SET `reward_count` = $club_reward_count - 1 WHERE `name` = '".$club."'";
                                    if($conn->query($update_club_reward_count) === FALSE)
                                    {
                                        echo("NO-Não deu update á reward.");
                                    }
                                    else
                                    {
                                        echo "OK-" . $array[$rand_key];
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
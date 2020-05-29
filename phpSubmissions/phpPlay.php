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
                                    $update_club_reward_count = "UPDATE `clubs` SET `reward_count` = $club_reward_count - 1 WHERE `name` = '".$club."'";
                                    if($conn->query($update_club_reward_count) === FALSE)
                                    {
                                        echo("NO-Não deu update á reward.");
                                    }
                                    else
                                    {
                                        echo "OK-";
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
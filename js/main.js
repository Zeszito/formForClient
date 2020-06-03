var form = document.querySelector('.needs-validation');
var wichOne = 1;

$(function () {
    $('[data-toggle="popover"]').popover();
    $('#overlayLoad').slideUp();


    function autoHeight() {
        var h = $(document).height() - $('body').height();
        if (h > 0) {
            $('.pusher').css({
                marginTop: h
            });
        }
    }
    $(window).on('load', autoHeight);
  });

$('html').click(function(e) {
    $('.popViso').popover('hide');
});

$('.popViso').popover({
    html: true,
    trigger: 'manual'
}).click(function(e) {
    $(this).popover('toggle');
    e.stopPropagation();
});

var erroDeCliente = "Error, verifique a sua ligação de internet e tente novamente.";
var erroDeServidorString ="Error a nivel do servidor, por favor tente mais tarde";
/**Estado inicial de cada elemento */
$('.noLogIn').find('*').attr('disabled', true);
$('#nomeVal').attr('disabled', true);
$("#enviarFormBtn").attr('disabled', true);
//$(".AceitoDados").find('input').prop("checked", true);
//$(".AceitoDados").find('*').attr('disabled', true);

/*acertar a roda*/
HideForLoging();

$(".RodaAll").hide();
$('#voltarBtn').hide();
/**Observo o botao de enviar */
form.addEventListener('submit', function(event) {
    event.preventDefault();
    event.stopPropagation();
    
    if(wichOne===2){
        newClient();
    }
    else{
        logInClient();    
    }  
})
//-------------------------------------------------------//
/**Observo os Termos */
var a = $("#direitoInfo");
var b = $("#termosInfo");
var c = $("#termosInfoPAss");
a.click(function() {
    CheckTermos();
  });
b.click(function() {
    CheckTermos();
  });
c.click(function() {
    CheckTermos();
  });

  function CheckTermos()
{
  if(a.is(':checked') && b.is(':checked') && c.is(':checked')){
    $("#enviarFormBtn").attr('disabled', false);
    $("#enviarFormBtn").css('pointer-events','');
    $(".popViso").popover('disable');
  } 
  else{
    $("#enviarFormBtn").attr('disabled', true);
    $("#enviarFormBtn").css('pointer-events','none');
    $(".popViso").popover('enable');
  }  
}
//-------------------------------------------------------//
//**SHOWS WHEEL */
function whellTransition(){
 
       $(".rcorner").animate({bottom:-200, opacity:0}, 1000,
        function (){$(".rcorner").remove()});
}

/**ENVIA NOVO CLIENTE */
function newClient() {
    var form = $("#mainForm");


    $.ajax({
        type: "POST",
        url: "phpSubmissions/phpSubmiteClient.php",
        data: form.serialize(),
        success: function (data) 
        {

            result = data;
            if(result.slice(0, 3)==="OK-"){
                $('#myModalRegisto').modal();
                $("#registerChoose").prop("checked", true);
                HideShowChangeTarget(1);
                CheckTermos();
            }else if(result.slice(0, 3)==="NO-"){               
                $('.toast-body').empty();
                $('.toast-body').text(result.slice(3));
                $('.toast').toast('show');  
            }
            else{
                $('.toast-body').empty();
                $('.toast-body').text(erroDeCliente);
                $('.toast').toast('show');  
            }
        },
        error: function(xhr) {
            $('.toast-body').empty();
            $('.toast-body').text(erroDeServidorString);
            $('.toast').toast('show'); 
          
        }
    })
}

var finalEmail;

/** ENVIA faz log in */
function logInClient(){
    $.ajax({
        type: "POST",
        url: "phpSubmissions/phpSubmiteLogIn.php",
        data: {'emailVal':$("#emailVal").val() },
        success: function (data) {
            result = decodeURIComponent(data);
            finalEmail = $("#emailVal").val();

            // AQUI ESTA IGUAL AO TEU?
            if(result.slice(0, 3)==="OK-"){
                let club =result.slice(3);
                skinChange(club);
                $(".RodaAll").show();
                $("#pusherGrand").removeClass("regular");
                $("#pusherGrand").addClass("ForShow");
                $('.pusher').css("padding-top","6vh");
                $('#voltarBtn').show();
                whellTransition();
                
            }else if(result.slice(0, 3)==="NO-"){
                
                $('.toast-body').empty();
                $('.toast-body').text(result.slice(3));
                $('.toast').toast('show');  
            }
            else{
                $('.toast-body').empty();
                $('.toast-body').text(erroDeCliente);
                $('.toast').toast('show');  
            }
        },
        error: function(xhr) {
            $('.toast-body').empty();
            $('.toast-body').text(erroDeServidorString);
            $('.toast').toast('show'); 
          
        }
    })
}

/**Envia faz Posso Jogar? */
function play(){
    $.ajax({
        type: "POST",
        url: "phpSubmissions/phpPlay.php",
        data: {'emailVal': finalEmail },
        success: function (data) {
            result = decodeURIComponent(data);
            if(result.slice(0, 3)==="OK-")
            {
                spin(finalPostion(result.slice(3)));
            }
            else if(result.slice(0, 3)==="NO-")
            {
                $('.toast-body').empty();
                $('.toast-body').text(result.slice(3));
                $('.toast').toast('show');  
            }
            else
            {
                $('.toast-body').empty();
                $('.toast-body').text(erroDeCliente);
                $('.toast').toast('show');
            }
        },
        error: function(xhr) {
            $('.toast-body').empty();
            $('.toast-body').text(erroDeServidorString);
            $('.toast').toast('show'); 
          
        }
    })
}


$("#myToast").on("show.bs.toast", function() {
    $(this).removeClass("d-none");
})
$("#myToast").on("hidden.bs.toast", function() {
    $(this).addClass("d-none");
})

$("#myToast").addClass("d-none");
/**Chnage type of use */
function HideShowChangeTarget(choose){

    if(choose===1){ //Login
        $('.noLogIn').find('*').attr('disabled', true);
        $('#nomeVal').attr('disabled', true);
        //$(".AceitoDados").find('input').prop("checked", true);
        //$(".AceitoDados").find('*').attr('disabled', true);
        
        /**chorme only */
        $('#nomeVal').removeClass("Alternative-Autofill-act");
        $('#nomeVal').addClass("Alternative-Autofill-De-act");
        $('#telInput').removeClass("Alternative-Autofill-act");
        $('#telInput').addClass("Alternative-Autofill-De-act");
      
        $('#enviarFormBtn').text("Enviar");
        $('.pusher').css("padding-top","24vh");
        HideForLoging();
   
        wichOne = choose;
    
    }
    else{ //Registo
        $('.noLogIn').find('*').attr('disabled', false);
        $('#nomeVal').attr('disabled', false);
        //$(".AceitoDados").find('input').prop("checked", false);
        //$(".AceitoDados").find('*').attr('disabled', false);
        
       /**chorme only */
        $('#nomeVal').addClass("Alternative-Autofill-act");
        $('#nomeVal').removeClass("Alternative-Autofill-De-act");
        $('#telInput').addClass("Alternative-Autofill-act");
        $('#telInput').removeClass("Alternative-Autofill-De-act");

        $('#enviarFormBtn').text("Registar");
        $('.pusher').css("padding-top","5vh");
        showForRegist();
        wichOne = choose;
    }
    CheckTermos();
}

//wheel Spin
var $elie = $("#roda");

/**Atache onclick event */
$("#prizebtn").on("click", function () 
{
    play();
});

var ClubeDoUser;
function skinChange(club){
    ClubeDoUser = club;
    
    switch (club) {
        case "Sporting Clube de Braga":
            $("#roda").attr("src", "images/rodas/braga.png");
            $("#TopBanner").attr("src", "images/banners/Banner_sc_braga.jpg")
            break;
        case "Vitória Sport Clube":
            $("#roda").attr("src", "images/rodas/vitoriasc.png");
            $("#TopBanner").attr("src", "images/banners/Banner_vitoria_sc.jpg")
            break;
        case "Vitória Futebol Clube":
            $("#roda").attr("src", "images/rodas/vitoriafc.png");
            $("#TopBanner").attr("src", "images/banners/Banner_vitoria_fc.jpg")
            break;
        case "Club Sport Marítimo":
            $("#roda").attr("src", "images/rodas/maritimo.png");
            $("#TopBanner").attr("src", "images/banners/Banner_cs_maritimo.jpg")
            break;
        case "FC Famalicão":
            $("#roda").attr("src", "images/rodas/famalicao.png");
            $("#TopBanner").attr("src", "images/banners/Banner_fc_famalicao.jpg")
            break;
        case "Clube Desportivo Tondela":
            $("#roda").attr("src", "images/rodas/tondela.png");
            $("#TopBanner").attr("src", "images/banners/Banner_cd_tondela.jpg")
            break;
        case "Rio Ave Futebol Clube":
            $("#roda").attr("src", "images/rodas/rioave.png");
            $("#TopBanner").attr("src", "images/banners/Banner_rio_ave_fc.jpg")
            break;

        default:
            $("#roda").attr("src", "images/rodas/default.png");
            break;
    }
    $(".full-width-image img").css("height","10vw");
}

function spin(amount) {
 
    $elie.animate(
        { deg: amount },
        {
          duration: 7000,
          step: function(now) {
            $(this).css({ transform: 'rotate(' + now + 'deg)' });
        },
          complete: Stop()
        }
      );
      
}
    
function Stop(){
    $("#prizebtn").hide();
    console.log(ClubeDoUser);
    /*Show modal*/
    setTimeout(()=>{
        getPrizeToSend(getCurrentRotation(document.getElementById('roda')));
    },8500);

    /*send base */
  
    //console.log(getCurrentRotation(document.getElementById('roda')));
}

/**Funaçao de suport */
function getCurrentRotation(el)
{
    var st = window.getComputedStyle(el, null);
    var tm = st.getPropertyValue("-webkit-transform") ||
             st.getPropertyValue("-moz-transform") ||
             st.getPropertyValue("-ms-transform") ||
             st.getPropertyValue("-o-transform") ||
             st.getPropertyValue("transform") ||
             "none";
    if (tm != "none") {
      var values = tm.split('(')[1].split(')')[0].split(',');
      var angle = Math.round(Math.atan2(values[1],values[0]) * (180/Math.PI));
      return (angle < 0 ? angle + 360 : angle); 
    }
    return 0;
} 

//**Seitch angulos to prizes */
function getPrizeToSend(angleP){
    
    let resultado;
    resultado = angleP > 0 && angleP <= 22.5 ? "camisola" :

                angleP > 22.5 && angleP <= 45 ? "cachecol":

                angleP > 45 && angleP <= 67.5 ? "seguro": 

                angleP > 67.5 && angleP <= 90 && ClubeDoUser != "FC Famalicão" ? "coluna": 
                angleP > 67.5 && angleP <= 90 && ClubeDoUser == "FC Famalicão" ? "camisolaAlt": 

                angleP > 90 && angleP <= 112.5 ? "powerbank": 

                angleP > 112.5 && angleP <= 135 ? "camisola": 

                angleP > 135 && angleP <= 157.5 && ClubeDoUser != "FC Famalicão" ? "kit":
                angleP > 135 && angleP <= 157.5 && ClubeDoUser == "FC Famalicão" ? "bone": 

                angleP > 157.5 && angleP <= 180 ? "consultoria": 

                angleP > 180 && angleP <= 202.5 && ClubeDoUser != "FC Famalicão" ? "coluna": 
                angleP > 180 && angleP <= 202.5 && ClubeDoUser == "FC Famalicão" ? "camisolaAlt":  

                angleP > 202.5 && angleP <= 225 && ClubeDoUser != "FC Famalicão" ? "bola": 
                angleP > 202.5 && angleP <= 225 && ClubeDoUser == "FC Famalicão" ? "mochila": 

                angleP > 225 && angleP <= 247.5 ? "seguro": 

                angleP > 247.5 && angleP <= 270 ? "cachecol": 

                angleP > 270 && angleP <= 292.5 && ClubeDoUser != "FC Famalicão" ? "bola":
                angleP > 270 && angleP <= 292.5 && ClubeDoUser == "FC Famalicão" ? "bone":  

                angleP > 292.5 && angleP <= 315 && ClubeDoUser != "FC Famalicão" ? "kit":
                angleP > 292.5 && angleP <= 315 && ClubeDoUser == "FC Famalicão" ? "mochila": 

                angleP > 315 && angleP <= 337.5 ? "powerbank": 

               // angleP > 337.6 && angleP < 360 ? "seguro":
                "consultoria";

        sendPremio(resultado);
}

//*ENVIA Premio doesnt */
function sendPremio(premio){

    $.ajax({
        type: "POST",
        url: "phpSubmissions/phpSubmiteReward.php",
        data: {'rewardVal': premio, 'emailVal': finalEmail},
        success: function (data) {
            result = data;
         
            console.log(result);
            if(result.slice(0,3)==="OK-"){
                $("#ModalTitle").text(result.slice(3));
                PrizeModalChange(premio);
                $('#myModal').modal();
            }else if(result.slice(0, 3)==="NO-"){                
                $('.toast-body').empty();
                $('.toast-body').text(result.slice(3));
                $('.toast').toast('show');  
            }
            else{
                $('.toast-body').empty();
                $('.toast-body').text(erroDeCliente);
                $('.toast').toast('show');  
            }
        },
        error: function(xhr) {
            $('.toast-body').empty();
            $('.toast-body').text(erroDeServidorString);
            $('.toast').toast('show'); 
          
        }
    })
}

/**este metodo chama imagePrizechange e textModalchange */
function PrizeModalChange(stringObjectivo){
    imagePrizeChange(stringObjectivo);
    textModalchange(stringObjectivo);
}
    // Nao queres começar a usar as funçoes todas com letra grande?
    function imagePrizeChange(stringObjectivo){
    // imagemModalAlvo
    let imagemModalAlvo = $("#imagemModalAlvo");
    switch (stringObjectivo) 
    {
        case "seguro":
           imagemModalAlvo.attr("src", "images/prizeImg/seguro auto.svg");
           break;
        case "camisola":
           imagemModalAlvo.attr("src", "images/prizeImg/camisola oficial.svg");
           break;
        case "kit":
           imagemModalAlvo.attr("src", "images/prizeImg/mochila.svg");
           break;
        case"camisolaAlt":
           imagemModalAlvo.attr("src", "images/prizeImg/camisolaAlt.svg");
           break;
        case "coluna":
           imagemModalAlvo.attr("src", "images/prizeImg/coluna.svg");
           break;
        case "mochila":
           imagemModalAlvo.attr("src", "images/prizeImg/mochila.svg");
           break;
        case "bola":
           imagemModalAlvo.attr("src", "images/prizeImg/bola.svg");
           break;
        case "bone":
           imagemModalAlvo.attr("src", "images/prizeImg/bone.svg");
           break;
        case "cachecol":
           imagemModalAlvo.attr("src", "images/prizeImg/cachecol.svg");
           break;
        case "consultoria":
           imagemModalAlvo.attr("src", "images/prizeImg/consulta seguro.svg");
           break;
        case "powerbank":
           imagemModalAlvo.attr("src", "images/prizeImg/powerbank.svg");
           break;
        default:
            break;
    }
}

function textModalchange(stringObjectivo){
    let textoModalAlvo = $("#ganhouTexto");
    switch (stringObjectivo) {
        case "seguro":
            textoModalAlvo.text("Parabéns! Ganhaste uma anuidade do seguro automóvel. Está atento à tua caixa de e-mail, por favor, pois será através deste meio que vamos entrar em contacto contigo!");
            break;
        case "camisola":
            textoModalAlvo.text("Parabéns! Ganhaste a camisola oficial do equipamento principal. Está atento à tua caixa de e-mail, por favor, pois será através deste meio que vamos entrar em contacto contigo!");
            break;
        case "kit":
            textoModalAlvo.text("Parabéns! Ganhaste um Kit do Adepto. Está atento à tua caixa de e-mail, por favor, pois será através deste meio que vamos entrar em contacto contigo!");
            break;
        case "camisolaAlt":
            textoModalAlvo.text("Parabéns! Ganhaste a camisola oficial do equipamento alternativo. Está atento à tua caixa de e-mail, por favor, pois será através deste meio que vamos entrar em contacto contigo!");
            break;
        case "coluna":
            textoModalAlvo.text("Parabéns! Ganhaste uma coluna de som. Está atento à tua caixa de e-mail, por favor, pois será através deste meio que vamos entrar em contacto contigo!");
            break;
        case "mochila":
            textoModalAlvo.text("Parabéns! Ganhaste uma mochila. Está atento à tua caixa de e-mail, por favor, pois será através deste meio que vamos entrar em contacto contigo!");
            break;
        case "bola":
            textoModalAlvo.text("Parabéns! Ganhaste uma bola anti-stress. Está atento à tua caixa de e-mail, por favor, pois será através deste meio que vamos entrar em contacto contigo!");
            break;
        case "bone":
            textoModalAlvo.text("Parabéns! Ganhaste um boné. Está atento à tua caixa de e-mail, por favor, pois será através deste meio que vamos entrar em contacto contigo!");
            break;
        case "cachecol":
            textoModalAlvo.text("Parabéns! Ganhaste um cachecol. Está atento à tua caixa de e-mail, por favor, pois será através deste meio que vamos entrar em contacto contigo!");
            break;
        case "consultoria":
            textoModalAlvo.text("Parabéns! Ganhaste uma consultoria de todos os teus seguros. Está atento à tua caixa de e-mail, por favor, pois será através deste meio que vamos entrar em contacto contigo!");
            break;
        case "powerbank":
            textoModalAlvo.text(" Parabéns! Ganhaste uma powerbank. Está atento à tua caixa de e-mail, por favor, pois será através deste meio que vamos entrar em contacto contigo!");
            break;
        default:
            break;
    }
}

/*---------------Case we want to try-------------------------*/

function HideForLoging(){
         //**hide show*/
         $('.noLogIn').hide();
        // $(".AceitoDados").find('*').hide();
         $('#nomeVal').hide();
         $('#nameLabel').hide();
}

function showForRegist(){
    //**hide show*/
    $('.noLogIn').show();
   // $(".AceitoDados").find('*').show();
    $('#nomeVal').show();
    $('#nameLabel').show();
}

//control FOR THE FORMS//
function checkTele(){
    
    console.log($('#telInput').val());
    if ($('#telInput').val().length == 9 && ($('#telInput').val().charAt(0) == 9 || $('#telInput').val().charAt(0) == 2)) {
        $('#telInput').css("background-color","#D6E8F8");
    }
    else{
        $('#telInput').css("background-color","rgba(255, 25, 25, 0.46)");
    }
};

//MAX DATE 
var today = new Date();
var dd = today.getDate();
var mm = today.getMonth()+1; //January is 0!
var yyyy = today.getFullYear()-18;
 if(dd<10){
        dd='0'+dd
    } 
    if(mm<10){
        mm='0'+mm
    } 

today = yyyy+'-'+mm+'-'+dd;
document.getElementById("birthDate").setAttribute("max", today);

//Reload page//
function reload(){
    location.reload();
}


/**Lidar com erros mais sérios */
function stringErro(status){

}

/**funções de controlo de respostas para a roda */





function prizeDegrees(prizeIdentificator) {
    let twoChoice = randomNumber(1,3);
    switch (prizeIdentificator) {
        case "camisola":
            if(twoChoice==1)
            return 11.25;
            if(twoChoice==2)
            return 123.75;
            break;
        case "cachecol":
            if(twoChoice==1)
            return 33.75;
            if(twoChoice==2)
            return 358.75;
            break;
        case "seguro":
            if(twoChoice==1)
            return 56.25;
            if(twoChoice==2)
            return 236.25;
            break;
        case "coluna":
            if(twoChoice==1)
            return 78.75;
            if(twoChoice==2)
            return 191.25;
            break;
        case "camisolaAlt":
            if(twoChoice==1)
            return 78.75;
            if(twoChoice==2)
            return 191.25;
            break;
        case "powerbank":
            if(twoChoice==1)
            return 101.25;
            if(twoChoice==2)
            return 326.25;
            break;
        case "kit":
            if(twoChoice==1)
            return 146.25;
            if(twoChoice==2)
            return 303.75;
            break;
        case "bone":
            if(twoChoice==1)
            return 146.25;
            if(twoChoice==2)
            return 281.25;
            break;
        case "consultoria":
            if(twoChoice==1)
            return 168.75;
            if(twoChoice==2)
            return 348.75;
            break;
        case "bola":
            if(twoChoice==1)
            return 213.75;
            if(twoChoice==2)
            return 281.25;
            break;
        case "mochila":
            if(twoChoice==1)
            return 213.75;
            if(twoChoice==2)
            return 303.75;
            break;
        default:
            break;
    }
}

function randomlaps(){
    let randomLaps;
 
    let random = randomNumber(1,4);

    randomLaps = random * 360;
    return randomLaps;
}

function randomNumber(min,max){
    let random = 
    Math.floor(Math.random() * (+max - +min)) + +min; 
    return random;
}

function finalPostion(prizeIdentificator){
    return prizeDegrees(prizeIdentificator) + randomlaps();
}
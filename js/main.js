var form = document.querySelector('.needs-validation');
var wichOne = 1;

/**Estado inicial de cada elemento */
$('.noLogIn').find('*').attr('disabled', true);
$('#nomeVal').attr('disabled', true);
$(".AceitoDados").find('input').prop("checked", true);
$(".AceitoDados").find('*').attr('disabled', true);

/*acertar a roda*/
HideForLoging();
$(".RodaAll").hide();

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

a.click(function() {
    CheckTermos();
  });
b.click(function() {
    CheckTermos();
  });

function CheckTermos()
{
  if(a.is(':checked') && b.is(':checked'))
    $("#enviarFormBtn").attr('disabled', false);
  else  $("#enviarFormBtn").attr('disabled', true);
}
//-------------------------------------------------------//


//**SHOWS WHELL */
function whellTransition(){
 
       $(".rcorner").animate({bottom:-200, opacity:0}, 1000,
        function (){$(".rcorner").remove()});
}

/**ENVIA NOVO CLIENTE */
function newClient() {
    var form = $("#mainForm");

   // console.log(("JS ->" + form.serialize()));

    $.ajax({
        type: "POST",
        url: "phpSubmissions/phpSubmiteClient.php",
        data: form.serialize(),
        success: function (data) {
            result = data;
            if(result.slice(0, 3)==="OK-"){
                $('#myModalRegisto').modal();
                $("#registerChoose").prop("checked", true);
                HideShowChangeTarget(1);
                CheckTermos();
            }
            else{
                $('.toast-body').empty();
                $('.toast-body').text(result.slice(3));
                $('.toast').toast('show');
          
            }
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
            result = data;
            finalEmail = $("#emailVal").val();

            if(result.slice(0, 3)==="OK-"){
                let club =result.slice(3);
                skinChange(club);
                $(".RodaAll").show();
                whellTransition();
                
            }else{
                $('.toast-body').empty();
                $('.toast-body').text(result.slice(3));
                $('.toast').toast('show');
            }
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
        $(".AceitoDados").find('input').prop("checked", true);
        $(".AceitoDados").find('*').attr('disabled', true);
        
        /**chorme only */
        $('#nomeVal').removeClass("Alternative-Autofill-act");
        $('#nomeVal').addClass("Alternative-Autofill-De-act");
        $('#telInput').removeClass("Alternative-Autofill-act");
        $('#telInput').addClass("Alternative-Autofill-De-act");
      
       HideForLoging();
   
        wichOne = choose;
    
    }
    else{ //registo
        $('.noLogIn').find('*').attr('disabled', false);
        $('#nomeVal').attr('disabled', false);
        $(".AceitoDados").find('input').prop("checked", false);
        $(".AceitoDados").find('*').attr('disabled', false);
        
       /**chorme only */
        $('#nomeVal').addClass("Alternative-Autofill-act");
        $('#nomeVal').removeClass("Alternative-Autofill-De-act");
        $('#telInput').addClass("Alternative-Autofill-act");
        $('#telInput').removeClass("Alternative-Autofill-De-act");

        showForRegist();
        wichOne = choose;
    }
    CheckTermos();
}

//wheel Spin
var $elie = $("#roda");

/**Atache onclick event */
$("#prizebtn").on("click", function () {
   
    var min=1080; 
    var max=1800;  
    var amount = 
    Math.floor(Math.random() * (+max - +min)) + +min;

   spin(amount);

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
        case "Clube Sport Marítimo":
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
            $("#roda").attr("src", "images/rodas/rioave");
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
function getCurrentRotation(el){
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
    resultado = angleP > 0 && angleP < 22.5 ? "camisola" : 
                angleP > 22.6 && angleP < 45 ? "cachecol": 
                angleP > 45.1 && angleP < 67.5 ? "seguro": 
                angleP > 67.6 && angleP < 90 ? "coluna - mochila": 
                angleP > 90.1 && angleP < 112.5 ? "powerbank": 
                angleP > 112.6 && angleP < 135 ? "camisola": 
                angleP > 135.1 && angleP < 157.5 ? "kit - camisolaAlt": 
                angleP > 157.6 && angleP < 180 ? "consultoria": 
                angleP > 180.1 && angleP < 202.5 ? "colina": 
                angleP > 202.6 && angleP < 225 ? "bola - bone": 
                angleP > 225.1 && angleP < 247.5 ? "seguro": 
                angleP > 247.6 && angleP < 270 ? "cachecol": 
                angleP > 270.1 && angleP < 292.5 ? "bola - bone": 
                angleP > 292.6 && angleP < 315 ? "kit - camisolaAlt": 
                angleP > 315.1 && angleP < 337.5 ? "powerbank": 
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
                PrizeModalChange(premio);
                $('#myModal').modal();
            }else{
                $('.toast-body').empty();
                $('.toast-body').text(result.slice(3));
                $('.toast').toast('show');
            }
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
 switch (stringObjectivo) {
     case "seguro":
        imagemModalAlvo.attr("src", "images/prizeImg/seguro auto.svg");
     break;
     case "camisola":
        imagemModalAlvo.attr("src", "images/prizeImg/camisola oficial.svg");
     break;
     case "kit - camisolaAlt":
        if(ClubeDoUser==="FC Famalicão")
            imagemModalAlvo.attr("src", "images/prizeImg/camisolaAlt.svg");
        else
        imagemModalAlvo.attr("src", "images/prizeImg/mochila.svg");
     break;
     case "coluna - mochila":
        if(ClubeDoUser==="FC Famalicão")
            imagemModalAlvo.attr("src", "images/prizeImg/mochila.svg");
        else
        imagemModalAlvo.attr("src", "images/prizeImg/coluna.svg");
     break;
     case "bola - bone":
        if(ClubeDoUser==="FC Famalicão")
        imagemModalAlvo.attr("src", "images/prizeImg/bone.svg");
         else
         imagemModalAlvo.attr("src", "images/prizeImg/bola.svg");
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
        case "kit - camisolaAlt":
            if(ClubeDoUser==="FC Famalicão")
            textoModalAlvo.text("Parabéns! Ganhaste a camisola oficial do equipamento alternativo. Está atento à tua caixa de e-mail, por favor, pois será através deste meio que vamos entrar em contacto contigo!");
            else
            textoModalAlvo.text("Parabéns! Ganhaste um Kit do Adepto. Está atento à tua caixa de e-mail, por favor, pois será através deste meio que vamos entrar em contacto contigo!");
        break;
        case "coluna - mochila":
            if(ClubeDoUser ==="FC Famalicão")
            textoModalAlvo.text("Parabéns! Ganhaste uma mochila. Está atento à tua caixa de e-mail, por favor, pois será através deste meio que vamos entrar em contacto contigo!");
            else
            textoModalAlvo.text("Parabéns! Ganhaste uma coluna de som. Está atento à tua caixa de e-mail, por favor, pois será através deste meio que vamos entrar em contacto contigo!");
        break;
        case "bola - bone":
            if(ClubeDoUser ==="FC Famalicão")
            textoModalAlvo.text("Parabéns! Ganhaste um boné. Está atento à tua caixa de e-mail, por favor, pois será através deste meio que vamos entrar em contacto contigo!");
            else
            textoModalAlvo.text("Parabéns! Ganhaste uma bola anti-stress. Está atento à tua caixa de e-mail, por favor, pois será através deste meio que vamos entrar em contacto contigo!");
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
         $(".AceitoDados").find('*').hide();
         $('#nomeVal').hide();
         $('#nameLabel').hide();
}

function showForRegist(){
    //**hide show*/
    $('.noLogIn').show();
    $(".AceitoDados").find('*').show();
    $('#nomeVal').show();
    $('#nameLabel').show();
}
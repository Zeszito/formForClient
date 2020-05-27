var form = document.querySelector('.needs-validation');
var wichOne = 1;

/**Estado inicial de cada elemento */
$('.noLogIn').find('*').attr('disabled', true);
$('#nomeVal').attr('disabled', true);
$(".AceitoDados").find('input').prop("checked", true);
$(".AceitoDados").find('*').attr('disabled', true);



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
  else   $("#enviarFormBtn").attr('disabled', true);
}
//-------------------------------------------------------//


//**SHOWS WHELL */
function whellTransition(){

    $(".bg2").animate({
        'background-color' :"white"
       }, 1000);
 
       $(".rcorner").animate({bottom:-200, opacity:0}, 1000,
        function (){$(".rcorner").remove()});

     
  
}

/**ENVIA NOVO CLIENTE */
function newClient() {
    var form = $("#mainForm")

   // console.log(("JS ->" + form.serialize()));

    $.ajax({
        type: "POST",
        url: "phpSubmissions/phpSubmiteClient.php",
        data: form.serialize(),
        success: function (data) {
            result = data;
            if(result.slice(0, 3)==="OK-"){
                alert("Sucesso!");
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

/**faz log in */
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
                console.log(club);
                skinChange(club);

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

    if(choose===1){
        $('.noLogIn').find('*').attr('disabled', true);
        $('#nomeVal').attr('disabled', true);
        $(".AceitoDados").find('input').prop("checked", true);
        $(".AceitoDados").find('*').attr('disabled', true);
        
        /**chorme only */
        $('#nomeVal').removeClass("Alternative-Autofill-act");
        $('#nomeVal').addClass("Alternative-Autofill-De-act");
        $('#telInput').removeClass("Alternative-Autofill-act");
        $('#telInput').addClass("Alternative-Autofill-De-act");
       
        wichOne = choose;
    }
    else{
        $('.noLogIn').find('*').attr('disabled', false);
        $('#nomeVal').attr('disabled', false);
        $(".AceitoDados").find('input').prop("checked", false);
        $(".AceitoDados").find('*').attr('disabled', false);
        
       /**chorme only */
        $('#nomeVal').addClass("Alternative-Autofill-act");
        $('#nomeVal').removeClass("Alternative-Autofill-De-act");
        $('#telInput').addClass("Alternative-Autofill-act");
        $('#telInput').removeClass("Alternative-Autofill-De-act");
        wichOne = choose;
    }
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
    console.log("entro");
    ClubeDoUser = club;
    switch (club) {
        case "Sporting Clube de Braga":
            $("#roda").attr("src", "images/rodas/braga.png");
            break;
        case "Vitória Sport Clube":
            $("#roda").attr("src", "images/rodas/vitoriasc.png");
            break;
        case "Vitória Futebol Clube":
            $("#roda").attr("src", "images/rodas/vitoriafc.png");
            break;
        case "Clube Sport Marítimo":
            $("#roda").attr("src", "images/rodas/maritimo.png");
            break;
        case "FC Famalicão":
            $("#roda").attr("src", "images/rodas/famalicao.png");
            break;
        case "Clube Desportivo Tondela":
            $("#roda").attr("src", "images/rodas/tondela.png");
            break;
        case "Rio Ave Futebol Clube":
            $("#roda").attr("src", "images/rodas/rioave");
            break;

        default:
            $("#roda").attr("src", "images/rodas/default.png");
            break;
    }




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
        $('#myModal').modal();
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

    console.log("foi tanto "+ angleP)
    
    let resultado;
    resultado = angleP > 0 && angleP < 22.5 ? "cinema" : 
                angleP > 22.6 && angleP < 45 ? "carregador": 
                angleP > 45.1 && angleP < 67.5 ? "mochila": 
                angleP > 67.6 && angleP < 90 ? "estadio": 
                angleP > 90.1 && angleP < 112.5 ? "cascol": 
                angleP > 112.6 && angleP < 135 ? "bola": 
                angleP > 135.1 && angleP < 157.5 ? "coluna": 
                angleP > 157.6 && angleP < 180 ? "carregador": 
                angleP > 180.1 && angleP < 202.5 ? "bilhetes": 
                angleP > 202.6 && angleP < 225 ? "coluna - mochila": 
                angleP > 225.1 && angleP < 247.5 ? "bola-bone": 
                angleP > 247.6 && angleP < 270 ? "carregador": 
                angleP > 270.1 && angleP < 292.5 ? "bilhetes": 
                angleP > 292.6 && angleP < 315 ? "bola": 
                angleP > 315.1 && angleP < 337.5 ? "bilhestes": 
                angleP > 337.6 && angleP < 360 ? "cascol":
                "camisola";

        sendPremio(resultado);
    
    
}


//*Send Premio doesnt work*/
function sendPremio(premio){
    
    PrizeModalChange("seguro");
    $.ajax({
        type: "POST",
        url: "phpSubmissions/phpSubmiteReward.php",
        data: {'rewardVal': premio, 'emailVal': finalEmail},
        success: function (data) {
            result = data;
            console.log(result);
            if(result.slice(0, 3)==="OK-"){
                let club =result.slice(3);
                PrizeModalChange(premio);
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
function imagePrizeChange(stringObjectivo){
// imagemModalAlvo
 let imagemModalAlvo = $("#imagemModalAlvo");
 switch (stringObjectivo) {
     case "seguro":
        imagemModalAlvo.attr("src", "images/prizeImg/consulta seguro.svg");
     break;
     case "camisola":
        imagemModalAlvo.attr("src", "images/prizeImg/consulta seguro.svg");
     break;
     case "kit - camisolaAlt":
        imagemModalAlvo.attr("src", "images/prizeImg/consulta seguro.svg");
     break;
     case "coluna - mochila":
        imagemModalAlvo.attr("src", "images/prizeImg/consulta seguro.svg");
     break;
     case "bola - bone":
        imagemModalAlvo.attr("src", "images/prizeImg/consulta seguro.svg");
     break;
     case "cachecol":
        imagemModalAlvo.attr("src", "images/prizeImg/consulta seguro.svg");
     break;
     case "consultoria":
        imagemModalAlvo.attr("src", "images/prizeImg/consulta seguro.svg");
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
            textoModalAlvo.text("Parabéns! Ganhaste uma anuidade do seguro automóvel. Está atento à tua caixa de e-mail, por favor, pois será através deste meio que vamos entrar em contacto contigo!");
        break;
        case "kit - camisolaAlt":
            textoModalAlvo.text("Parabéns! Ganhaste uma anuidade do seguro automóvel. Está atento à tua caixa de e-mail, por favor, pois será através deste meio que vamos entrar em contacto contigo!");
        break;
        case "coluna - mochila":
            textoModalAlvo.text("Parabéns! Ganhaste uma anuidade do seguro automóvel. Está atento à tua caixa de e-mail, por favor, pois será através deste meio que vamos entrar em contacto contigo!");
        break;
        case "bola - bone":
            textoModalAlvo.text("Parabéns! Ganhaste uma anuidade do seguro automóvel. Está atento à tua caixa de e-mail, por favor, pois será através deste meio que vamos entrar em contacto contigo!");
        break;
        case "cachecol":
            textoModalAlvo.text("Parabéns! Ganhaste uma anuidade do seguro automóvel. Está atento à tua caixa de e-mail, por favor, pois será através deste meio que vamos entrar em contacto contigo!");
        break;
        case "consultoria":
            textoModalAlvo.text("Parabéns! Ganhaste uma anuidade do seguro automóvel. Está atento à tua caixa de e-mail, por favor, pois será através deste meio que vamos entrar em contacto contigo!");
        break;
    
    
        default:
            break;
    }
    
}
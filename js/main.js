var form = document.querySelector('.needs-validation');
var wichOne = 1;

/**Estado inicial de cada elemento */
$('.noLogIn').find('*').attr('disabled', true);
$('#nomeVal').attr('disabled', true)
$("#enviarFormBtn").attr('disabled', true);



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

function newClient() {
    var form = $("#mainForm")

    console.log(("JS ->" + form.serialize()));

    $.ajax({
        type: "POST",
        url: "phpSubmissions/phpSubmiteClient.php",
        data: form.serialize(),
        success: function (data) {
            result = data;
            console.log("PHP->" + result);
        }
    })
}

function logInClient(){
    console.log(("JS ->" + $("#emailVal").val()));


    $.ajax({
        type: "POST",
        url: "phpSubmissions/phpSubmiteLogIn.php",
        data: {'emailVal':$("#emailVal").val() },
        success: function (data) {
            result = data;
      
            if(result.slice(0, 3)==="OK-"){
                let club =result.slice(3);
                console.log(club);
                skinChange(club);

                whellTransition();
            }else{
                alert(result);
            }
        }
    })
}

/**Chnage type of use */
function HideShowChangeTarget(choose){

    if(choose===1){
        $('.noLogIn').find('*').attr('disabled', true);
        $('#nomeVal').attr('disabled', true)
        wichOne = choose;
    }
    else{
        $('.noLogIn').find('*').attr('disabled', false);
        $('#nomeVal').attr('disabled', false)
        wichOne = choose;
    }
}




var $elie = $("#roda");

//wheel Spin

function Stop(rodavar){
    $("#prizebtn").hide();
    /*Show modal*/
    setTimeout(()=>{
        $('#myModal').modal();
    },4000);

}
$("#prizebtn").on("click", function () {
   
    var min=1080; 
    var max=1800;  
    var amount = 
    Math.floor(Math.random() * (+max - +min)) + +min;

   spin(amount);

  });


function skinChange(club){
    console.log("entro");

    switch (club) {
        case "SC Braga":
            $("#roda").attr("src", "images/rodas/Red White.png");
            break;
        case "Vitória SC":
            $("#roda").attr("src", "images/rodas/Green White");
            break;
        case "Vitória FC":
            $("#roda").attr("src", "images/rodas/Black White.png");
            break;
        case "CS Marítimo":
            $("#roda").attr("src", "images/rodas/Red Green.png");
            break;
        case "FC Famalicão":
            $("#roda").attr("src", "images/rodas/Blue White.png");
            break;
        case "CD Tondela":
            $("#roda").attr("src", "images/rodas/Green Yellow.png");
            break;
        case "Rio Ave FC":
            $("#roda").attr("src", "images/rodas/Green White.png");
            break;

        default:
            $("#roda").attr("src", "images/rodas/roleta_default.png");
            break;
    }




}





function spin(amount) {
    var $myElm = $elie;
  
    var rotAmount = amount;
    function rotate(degrees) {
      
      $myElm.css({
        '-webkit-transform': 'rotate(' + degrees + 'deg)',
        '-moz-transform': 'rotate(' + degrees + 'deg)',
        '-ms-transform': 'rotate(' + degrees + 'deg)',
        'transform': 'rotate(' + degrees + 'deg)'
      });
      
      
    }
    
    $({
      deg: 0
    }).animate({
      deg: rotAmount * 2  
    }, {
      duration: 7000,
      easing: "easeOutCirc",
      step: function(now) {
        var deg = now < 6000  || now > 8000  ? now / 8 : now;
        rotate(deg);
      }
    });
  }
  
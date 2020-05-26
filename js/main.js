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
var $seta = $("#seta");

var degree = 10;
var degreeSeta = 0;
var time = 0;

//wheel Spin
function StarSpin() {
 
      //360º /16 espaços = 22.5;
      // For webkit browsers: e.g. Chrome
           $elie.css({ WebkitTransform: 'rotate(' + degree + 'deg)'});
      // For Mozilla browser: e.g. Firefox
           $elie.css({ '-moz-transform': 'rotate(' + degree + 'deg)'});
    degree+=22.5;   
    
    
    $seta.css({ WebkitTransform: 'rotate(' + degreeSeta + 'deg)'});
    // For Mozilla browser: e.g. Firefox
         $seta.css({ '-moz-transform': 'rotate(' + degreeSeta + 'deg)'});

         if(time<5)
         degreeSeta +=2;
         
         if(time==5)
         degreeSeta=0;

         if(time>5 && time < 10)
         degreeSeta -=2;

         if(time>10)
            time=0;
          
            time++;
    
}
function Stop(rodavar){
    $("#prizebtn").hide();

    setTimeout(()=>{
        clearInterval(rodavar);
        rodavar = setInterval(myFunction, 100);
        console.log("Roda 1");
    },1000);

    setTimeout(()=>{
        clearInterval(rodavar);
        rodavar = setInterval(myFunction, 200);
        console.log("Roda 2");
    },2000);

    setTimeout(()=>{
        clearInterval(rodavar);
        rodavar = setInterval(myFunction, 250);
        console.log("Roda 3");
    },2500);

    setTimeout(()=>{
        clearInterval(rodavar);
        console.log("Roda 4");
        $('#myModal').modal();
    },3200);

    /*Show modal*/
    setTimeout(()=>{
        $('#myModal').modal();;
    },4000);

}
$("#prizebtn").on("click", function () {
    var rodando = setInterval(StarSpin, 50);
    Stop(rodando);

  });



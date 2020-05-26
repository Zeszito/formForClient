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
 
    $elie.animate(
        { deg: amount },
        {
          duration: 7000,
          step: function(now) {
            $(this).css({ transform: 'rotate(' + now + 'deg)' });
            
  
            console.log(getCurrentRotation(document.getElementById('roda')));
        },
          complete: Stop()
        }
      );
      
}
    
function Stop(){
    $("#prizebtn").hide();
   
    /*Show modal*/
    setTimeout(()=>{
        $('#myModal').modal();
    },8500);

    /*send base */
    console.log($elie.css("transform"));
}

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
      /*
      a = values[0];
      b = values[1];
      angle = Math.round(Math.atan2(b,a) * (180/Math.PI));
      */
      //return Math.round(Math.atan2(values[1],values[0]) * (180/Math.PI)); //this would return negative values the OP doesn't wants so it got commented and the next lines of code added
      var angle = Math.round(Math.atan2(values[1],values[0]) * (180/Math.PI));
      return (angle < 0 ? angle + 360 : angle); //adding 360 degrees here when angle < 0 is equivalent to adding (2 * Math.PI) radians before
    }
    return 0;
  } 
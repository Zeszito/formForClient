var form = document.querySelector('.needs-validation');
var wichOne = 1;
$(".RodaAll").hide();
form.addEventListener('submit', function(event) {
    event.preventDefault();
    event.stopPropagation();

    if(wichOne===2){
        newClient();
    }
    else{
       // logInClient();
       $("#checksUserType").hide();
       $("#mainForm").hide();
       $(".RodaAll").show(1000);
    }
 
   
})

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

}


function HideShowChangeTarget(choose){

    if(choose===1){
        $(".noLogIn").hide();
        wichOne = choose;
    }
    else{
        $(".noLogIn").show();
        wichOne = choose;
    }
}



$(".noLogIn").hide();

var $elie = $("#roda");
var $seta = $("#seta");

var degree = 10;
var degreeSeta = 0;
var time = 0;
function myFunction() {
 
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
 
var rodando = setInterval(myFunction, 50);

$("#prizebtn").on("click", function () {
    Stop();
  });


function Stop(){
    $("#prizebtn").hide();

    setTimeout(()=>{
        clearInterval(rodando);
        rodando = setInterval(myFunction, 100);
        console.log("Roda 1");
    },1000)
    setTimeout(()=>{
        clearInterval(rodando);
        rodando = setInterval(myFunction, 200);
        console.log("Roda 2");
    },2000)

    setTimeout(()=>{
        clearInterval(rodando);
        rodando = setInterval(myFunction, 250);
        console.log("Roda 3");
    },2500)
    setTimeout(()=>{
        clearInterval(rodando);
        console.log("Roda 4");
        $seta.css({ WebkitTransform: 'rotate(' + 0 + 'deg)'});
        // For Mozilla browser: e.g. Firefox
             $seta.css({ '-moz-transform': 'rotate(' + 0 + 'deg)'});

    },3200)

}
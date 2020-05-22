var form = document.querySelector('.needs-validation');

form.addEventListener('submit', function(event) {
    event.preventDefault();
    event.stopPropagation();
    newClient();
   
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
    
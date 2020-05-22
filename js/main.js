var form = document.querySelector('.needs-validation');

form.addEventListener('submit', function(envent) {
    if(form.checkValidity() === false){
        event.preventDefault();
        event.stopPropagation();
    }
    form.classList.add("was-validated");
    
})

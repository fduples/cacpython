let btnSend = document.querySelector("#btn-send");

btnSend.addEventListener('click',function(){
    let firstname = document.querySelector("#firstname");
    let lastname = document.querySelector("#lastname");
    let email = document.querySelector("#email");

    if(firstname.value.trim()==='' && firstname.required ){
        let errorFirstname = document.querySelector("#error-firstname");
        errorFirstname.textContent = 'Debe completar el campo nombre';
        // alert('Error, debe completar el campo nombre');
    }
    
    if(!lastname.value.trim() && lastname.required ){
        document.querySelector("#error-lastname").textContent = 'Debe completar el campo apellido';        
    }

});

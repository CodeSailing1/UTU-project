const requeriments = {
    name: /^[a-zA-Z\s]{2,25}$/,
    lastName: /^[a-zA-Z\s]{2,25}$/,
    email:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+?.[a-zA-Z]{2,50}$/,
    password:/^[\w\S-¿?^*´!|#$%&/{}()=><;:,.-]{8,50}$/,
    day: /^[0-9\s]{2}$/,
    month: /^[0-9\s]{2}$/,
    year: /^[0-9\s]{4}$/
}
const tFs = {
    name: false,
    lastName: false,
    email: false,
    password:false,
    day: false,
    month: false,
    year: false
}

const URL_API = '/logica/register.php';

document.addEventListener('DOMContentLoaded', () => {

    const signUpForm = document.getElementById("signUpForm");
    const inputSignUp = document.querySelectorAll("#signUpForm input");    

    inputSignUp.forEach(input => {
        input.addEventListener("input", (e) => {
            let validation = validationInputs(requeriments[e.target.name], e.target.value, e.target.id);
            submitValidation(validation);
        }); 
    })
    
    function validationInputs(requeriment, input, idInput) {
    
        const element = document.getElementById(idInput);
        try{
            if(requeriment.test(input)){
                element.classList.add("valid");
                element.classList.remove("invalid");
                tFs[idInput] = true;
            } else{
                element.classList.add("invalid");
                element.classList.remove("valid");
                tFs[idInput] = false;
                throw new Error("Ingresa valores validos");
            }
            return true;
        }catch(e) {
            if(!requeriment.test(input)){
                console.error(e.message);
                return false
            }
        }
    }
    
    function submitValidation() {
        let allElementsValid = true;
        for(let input in tFs){
            if (!tFs[input]) {
                allElementsValid = false;
                break;
            }
        }
            (allElementsValid) ? registerSubmit.removeAttribute("disabled") : registerSubmit.setAttribute("disabled", "");
            return true;
    }
    
    
    registerSubmit.addEventListener("click", (e) => {
        e.preventDefault();
        const formData = new FormData(signUpForm);
        if (!submitValidation()) {
            console.error("No se pueden enviar los datos porque hay errores en el formulario");
        }
        fetch(URL_API, {
            method: "POST",
            body: formData
        })
        .then(data => {
            console.log(data);
        })
        .catch(error => {
            console.error(error);
        });
    });
    
    
})
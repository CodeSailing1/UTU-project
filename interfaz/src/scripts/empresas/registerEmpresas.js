import {showImage} from '/UTU-project/interfaz/src/scripts/usuario/showProfilePhoto.js';
showImage();
const requerimentsEmpresas = {
    nameEmpresas: /^[a-zA-Z\s]{2,25}$/,
    emailEmpresas: /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+?.[a-zA-Z]{2,50}$/,
    passwordEmpresas: /^[\w\S-¿?^*´!|#$%&/{}()=><;:,.-]{8,50}$/,
    phoneEmpresas: /^[0-9\s]{9}$/,
    direccionEmpresas: /^[a-zA-Z0-9\s]{2,25}$/
}
const tFsEmpresas = {
    nameEmpresas: false,
    emailEmpresas: false,
    passwordEmpresas:false,
    phoneEmpresas: false,
    direccionEmpresas: false,
}

const URL_API_EMPRESAS = '/UTU-project/logica/empresas/register.php';


document.addEventListener('DOMContentLoaded', () => {

    const signUpFormEmpresas = document.getElementById("signUpFormEmpresas");
    const inputSignUpEmpresas = document.querySelectorAll("#signUpFormEmpresas input");    

    inputSignUpEmpresas.forEach(input => {
        input.addEventListener("input", (e) => {
            let validation = validationInputs(requerimentsEmpresas, e.target.name, e.target.value, e.target.id);
            submitValidation(validation);
        }); 
    })
    
    function validationInputs(requeriments, inputName, input, idInput) {
        const element = document.getElementById(idInput);
        if (!requeriments.hasOwnProperty(inputName)) {
            console.error(`No requeriment found for input name: ${inputName}`);
            return false;
        }
        const requeriment = requerimentsEmpresas[inputName]; // Get the specific requeriment for this input
        console.log(requeriment)
        try {
            if (requeriment.test(input)) {
                element.classList.add("valid");
                element.classList.remove("invalid");
                tFsEmpresas[inputName] = true;
            } else {
                element.classList.add("invalid");
                element.classList.remove("valid");
                tFsEmpresas[inputName] = false;
                throw new Error("Ingresa valores validos");
            }
            return true;
        } catch (e) {
            if (!requerimentsEmpresas.test(input)) {
                console.error(e.message);
                return false
            }
        }
    }
    
    function submitValidation() {
        let allElementsValid = true;
        for(let input in tFsEmpresas){
            if (!tFsEmpresas[input]) {
                allElementsValid = false;
                break;
            }
        }
            const registerSubmitEmpresas = document.getElementById("registerSubmitEmpresas");

            (allElementsValid) ? registerSubmitEmpresas.removeAttribute("disabled") : registerSubmit.setAttribute("disabled", "");
            return true;
    }
    
    
    signUpFormEmpresas.addEventListener("submit", (e) => {
        e.preventDefault();
        const formEmpresas = document.getElementById('signUpFormEmpresas');
        const formDataEmpresas = new FormData(formEmpresas);  // Crear un objeto FormData con los datos del formulario

        if (!submitValidation()) {
            console.error("No se pueden enviar los datos porque hay errores en el formulario");
        }
        fetch(URL_API_EMPRESAS, {
            method: "POST",
            body: formDataEmpresas
        })
        .then(data => {
            if (data.success) {
                window.location.href ='/UTU-project/interfaz/public-html/login.html';
            } else {
                alert('Email ya registrado');
            }
        })
        .catch(error => {
            console.error(error);
        });
    });
    
    
})
import {showImage} from '/UTU-project/interfaz/src/scripts/usuario/showProfilePhoto.js';
showImage();
const requeriments = {
    name: /^[a-zA-Z\s]{2,25}$/,
    email: /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+?.[a-zA-Z]{2,50}$/,
    password: /^[\w\S-¿?^*´!|#$%&/{}()=><;:,.-]{8,50}$/,
    phone: /^[0-9\s]{9}$/,
    direccion: /^[a-zA-Z0-9\s]{2,25}$/
}
const tFs = {
    name: false,
    email: false,
    password:false,
    phone: false,
    direccion: false,
}

const URL_API = '/UTU-project/logica/usuarios/register.php';


document.addEventListener('DOMContentLoaded', () => {

    const signUpForm = document.getElementById("signUpForm");
    const inputSignUp = document.querySelectorAll("#signUpForm input");    

    inputSignUp.forEach(input => {
        input.addEventListener("input", (e) => {
            let validation = validationInputs(requeriments, e.target.name, e.target.value, e.target.id);
            submitValidation(validation);
        }); 
    })
    
    function validationInputs(requeriments, inputName, input, idInput) {
        const element = document.getElementById(idInput);
        if (!requeriments.hasOwnProperty(inputName)) {
            console.error(`No requeriment found for input name: ${inputName}`);
            return false;
        }
        const requeriment = requeriments[inputName]; // Get the specific requeriment for this input
        console.log(requeriment)
        try {
            if (requeriment.test(input)) {
                element.classList.add("valid");
                element.classList.remove("invalid");
                tFs[inputName] = true;
            } else {
                element.classList.add("invalid");
                element.classList.remove("valid");
                tFs[inputName] = false;
                throw new Error("Ingresa valores validos");
            }
            return true;
        } catch (e) {
            if (!requeriment.test(input)) {
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
            const registerSubmit = document.getElementById("registerSubmit");

            (allElementsValid) ? registerSubmit.removeAttribute("disabled") : registerSubmit.setAttribute("disabled", "");
            return true;
    }
    
    
    signUpForm.addEventListener("submit", (e) => {
        e.preventDefault();
        e.preventDefault();
        const form = document.getElementById('signUpForm');
        const formData = new FormData(form);  // Crear un objeto FormData con los datos del formulario

        if (!submitValidation()) {
            console.error("No se pueden enviar los datos porque hay errores en el formulario");
        }
        console.log('hola')
        fetch(URL_API, {
            method: "POST",
            body: formData
        })
        .then(data => {
            if (data.ok) {
                window.location.href ='/UTU-project/interfaz/public-html/login.html';
            } else {
                console.error(data.error);
            }
        })
        .catch(error => {
            console.error(error);
        });
    });
    
    
})
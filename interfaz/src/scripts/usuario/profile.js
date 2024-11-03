document.addEventListener('DOMContentLoaded', () => {
    const inputs = document.querySelectorAll('.input');
    const changeDataForm = document.getElementById("formData");
    console.log(changeDataForm);

    const requeriments = {
        password: /^[\w\S-¿?^*´!|#$%&/{}()=><;:,.-]{9,50}$/,
        confirmPassword: /^[\w\S-¿?^*´!|#$%&/{}()=><;:,.-]{9,50}$/

    }

    const tFs = {
        password:false,
        confirmPassword:false
    }

    const URL_API = '/UTU-project/logica/usuarios/changeDataUser.php';

    inputs.forEach(input => {
        input.addEventListener("input", (e) => {
            const validation = validationInputs(requeriments, e.target.name, e.target.value, e.target.id);
            if ( validation === true && e.target.name === 'password' || e.target.name === 'confirmPassword') {
                validatePassword();
                submitValidation();
                
            }
        }); 
    });
    
    
    function validationInputs(requeriments, inputName, input, idInput) {
        const element = document.getElementById(idInput);
        if (!requeriments.hasOwnProperty(inputName)) {
            console.error(`No requeriment found for input name: ${inputName}`);
            return false;
        }
        const requeriment = requeriments[inputName]; // Get the specific requeriment for this input
        try {
            if (requeriment.test(input)) {
                element.classList.add("valid");
                element.classList.remove("invalid");
                tFs[inputName] = true;
                console.log(tFs);

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
        for (let input in tFs) {
            if (!tFs[input]) {
                allElementsValid = false;
                break;
            }
        }
        const submitButton = document.getElementById("submitButton");
        (allElementsValid) ? submitButton.removeAttribute("disabled") : submitButton.setAttribute("disabled", "");
    }
    function validatePassword() {
        const passwordInput = document.querySelector('input[name="password"]'); // Cambia el nombre si es diferente
        const confirmPasswordInput = document.querySelector('input[name="confirmPassword"]'); // Asegúrate de que este campo exista
    
        if (passwordInput.value !== confirmPasswordInput.value) {
            passwordInput.classList.add("invalid");
            confirmPasswordInput.classList.add("invalid");
            tFs.password = false;
            return false;
        } else {
            passwordInput.classList.remove("invalid");
            confirmPasswordInput.classList.remove("invalid");
            tFs.password = true;
            return true;
        }
    }

    changeDataForm.addEventListener("submit", (e) => {
        if (!submitValidation()) {
            e.target.preventDefault();
            console.error("No se pueden enviar los datos porque hay errores en el formulario");
            return;
        }
        const password = document.getElementById('pass');  // Crear un objeto FormData con los datos del formulario
        const passwordConfirm = document.getElementById('conf');
        fetch(URL_API, {
            method: "PUT",
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                password: password.value,
                confirmPassword: passwordConfirm.value
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            }
        })
        .catch(error => {
            console.error(error);
        });
    });
});

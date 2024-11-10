document.addEventListener('DOMContentLoaded', () => {
    const inputs = document.querySelectorAll('.input');
    const changeDataForm = document.getElementById("formData");

    const requeriments = {
        password: /^[\w\S-¿?^*´!|#$%&/{}()=><;:,.-]{8,50}$/,
        confirmPassword: /^[\w\S-¿?^*´!|#$%&/{}()=><;:,.-]{8,50}$/

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
                validatePassword(inputs);
                submitValidation();
                
            }
        }); 
    });
    
    
    function validationInputs(requeriments, inputName, input, idInput) {
        const element = document.getElementById(idInput);
        console.log(idInput);
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
        if(allElementsValid){
            submitButton.removeAttribute("disabled");
            return true;
        } else {
            submitButton.setAttribute("disabled", "");
            return false;
        }
    }
    function validatePassword(input) {
        const passwordInput = document.querySelector('input[name="password"]'); // Cambia el nombre si es diferente
        const confirmPasswordInput = document.querySelector('input[name="confirmPassword"]'); // Asegúrate de que este campo exista
        if (passwordInput.value !== confirmPasswordInput.value) {
            passwordInput.classList.add("invalid");
            confirmPasswordInput.classList.remove("valid");
            tFs[input] = false;
            return false;
        } else {
            passwordInput.classList.remove("invalid");
            confirmPasswordInput.classList.add("valid");
            tFs[input] = true;
            return true;
        }
    }

    changeDataForm.addEventListener("submit", (e) => {
        if (!submitValidation()) {
            e.target.preventDefault();
            console.error("No se pueden enviar los datos porque hay errores en el formulario");
            return;
        }
        const password = document.getElementById('pass').value;  // Crear un objeto FormData con los datos del formulario
        const passwordConfirm = document.getElementById('conf').value;
        fetch(URL_API, {
            method: "PUT",
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                password: password,
                confirmPassword: passwordConfirm
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

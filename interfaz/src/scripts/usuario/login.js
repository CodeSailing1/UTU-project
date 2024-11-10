const requeriments = {
    email: /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+?.[a-zA-Z]{2,50}$/,
    password: /^[\w\S-¿?^*´!|#$%&/{}()=><;:,.-]{8,50}$/
};
const tFsLogIn = {
    email: false,
    password: false
};
const URL_API = '/UTU-project/logica/usuarios/login.php';

document.addEventListener('DOMContentLoaded', () => {
    const loginForm = document.getElementById("logInForm");
    const inputLogin = document.querySelectorAll("#logInForm input");

    inputLogin.forEach(input => {
        input.addEventListener("input", () => {
            const validation = validationInputs(requeriments[input.name], input.value, input.id);
            submitValidationLogin(validation);
        });
    });

    function validationInputs(requeriment, input, idInput) {
        try {
            if (requeriment.test(input)) {
                document.getElementById(idInput).classList.add("valid");
                document.getElementById(idInput).classList.remove("invalid");
                tFsLogIn[idInput] = true;
            } else {
                document.getElementById(idInput).classList.add("invalid");
                document.getElementById(idInput).classList.remove("valid");
                tFsLogIn[idInput] = false;
                throw new Error("Ingresa valores validos");
            }
        } catch (e) {
            if (!requeriment.test(input)) {
                console.error(e.message);
                return false;
            }
            return true;
        }
    }

    function submitValidationLogin() {
        let allElementsValid = true;
        for (let input in tFsLogIn) {
            if (!tFsLogIn[input]) {
                allElementsValid = false;
                break;
            }
        }
        const submitButton = document.getElementById("submit");
        (allElementsValid) ? submitButton.removeAttribute("disabled") : submit.setAttribute("disabled", "");
    }

    loginForm.addEventListener('submit', (e) => {
        e.preventDefault();
        const formData = new FormData(loginForm);  // Crear un objeto FormData con los datos del formulario


        fetch(URL_API, {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.href = '/UTU-project/interfaz/public-html/index.php';
            } else {
                console.error(data.error);
            }
        })
        .catch(error => {
            console.error("Error al enviar la solicitud: ", error);
        });
    });
});
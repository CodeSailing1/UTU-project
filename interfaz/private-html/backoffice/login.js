const requeriments = {
    email: /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,50}$/, // Fixed regex
    password: /^[\w\S-¿?^*´!|#$%&/{}()=><;:,.-]{8,50}$/
};

const tFsLogIn = {
    email: false,
    password: false
};

const URL_API = '/UTU-project/logica/admin/loginAdmin.php';

document.addEventListener('DOMContentLoaded', () => {
    const loginForm = document.getElementById("logInForm");
    const inputLogin = document.querySelectorAll("#logInForm input");
    const submitButton = document.getElementById("submit");
    submitButton.setAttribute("disabled", ""); // Disable the button initially

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
            console.error(e.message);
            return false;
        }
    }

    function submitValidationLogin() {
        let allElementsValid = Object.values(tFsLogIn).every(Boolean); // Simplified check
        (allElementsValid) ? submitButton.removeAttribute("disabled") : submitButton.setAttribute("disabled", ""); // Correct reference
    }

    loginForm.addEventListener('submit', (e) => {
        e.preventDefault();
        const formData = new FormData(loginForm);

        fetch(URL_API, {
            method: 'POST',
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.href = '/UTU-project/interfaz/private-html/backoffice/';
                } else {
                    // Show error message to the user
                    alert(data.error || "An error occurred, please try again."); // User-friendly error message
                }
            })
            .catch(error => {
                console.error("Error al enviar la solicitud: ", error);
            });
    });
});

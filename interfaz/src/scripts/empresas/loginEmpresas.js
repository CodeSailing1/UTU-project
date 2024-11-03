const requerimentsEmpresas = {
    emailEmpresa: /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+?.[a-zA-Z]{2,50}$/,
    passwordEmpresa: /^[\w\S-¿?^*´!|#$%&/{}()=><;:,.-]{8,50}$/
};
const tFsLogInEmpresas = {
    emailEmpresa: false,
    passwordEmpresa: false
};
const URL_API_EMPRESAS = '/UTU-project/logica/empresas/login.php';

document.addEventListener('DOMContentLoaded', () => {
    const loginFormEmpresas = document.getElementById("logInFormEmpresas");
    const inputLogin = document.querySelectorAll("#logInFormEmpresas input");
    inputLogin.forEach(input => {

        input.addEventListener("input", (e) => {
            const validation = validationInputs(requerimentsEmpresas[e.target.name], e.target.value, e.target.id);
            submitValidationLogin(validation);
        });
    });

    function validationInputs(requerimentEmpresas, input, idInput) {

        try {
            if (requerimentEmpresas.test(input)) {
                document.getElementById(idInput).classList.add("valid");
                document.getElementById(idInput).classList.remove("invalid");
                tFsLogInEmpresas[idInput] = true;
            } else {
                document.getElementById(idInput).classList.add("invalid");
                document.getElementById(idInput).classList.remove("valid");
                tFsLogInEmpresas[idInput] = false;
                throw new Error("Ingresa valores validos");
            }
        } catch (e) {
            if (!requerimentEmpresas.test(input)) {
                console.error(e.message);
                return false;
            }
            return true;
        }
    }

    function submitValidationLogin() {
        let allElementsValid = true;
        for (let input in tFsLogInEmpresas) {
            if (!tFsLogInEmpresas[input]) {
                allElementsValid = false;
                break;
            }
        }
        const submitButton = document.getElementById("submitEmpresas");
        (allElementsValid) ? submitButton.removeAttribute("disabled") : submit.setAttribute("disabled", "");
    }

    loginFormEmpresas.addEventListener('submit', (e) => {
        e.preventDefault();
        const formData = new FormData(loginFormEmpresas);  // Crear un objeto FormData con los datos del formulario
        

        fetch(URL_API_EMPRESAS, {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.href = '/UTU-project/interfaz/private-html/empresas/empresas.php';
            } else {
                console.error(data.error);
            }
        })
        .catch(error => {
            console.error("Error al enviar la solicitud: ", error);
        });
    });
});
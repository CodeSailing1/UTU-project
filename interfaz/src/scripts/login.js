const requeriments = {
    email:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+?.[a-zA-Z]{2,50}$/,
    password:/^[\w\S-¿?^*´!|#$%&/{}()=><;:,.-]{8,50}$/,
}
const tFsLogIn = {
    email: false,
    password:false
}
const URL_API = '/UTU-project/logica/login.php';

document.addEventListener('DOMContentLoaded', () => {

    const loginForm = document.getElementById("logInForm");
    const inputLogin = document.querySelectorAll("#logInForm input");
    console.log(inputLogin);
    
    inputLogin.forEach(input => {
        
        input.addEventListener("input", (e) => {
            let validation = validationInputs(requeriments[e.target.name], e.target.value, e.target.id);
            submitValidationLogin(validation);
        }); 
    })
    
    function validationInputs(requeriment, input, idInput) {
    
        const element = document.getElementById(idInput);
        try{
            if(requeriment.test(input)){
                element.classList.add("valid");
                element.classList.remove("invalid");
                tFsLogIn[idInput] = true;
                    
            } else{
                element.classList.add("invalid");
                element.classList.remove("valid");
                tFsLogIn[idInput] = false;
    
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
    function submitValidationLogin() {
        let allElementsValid = true;
        for(let input in tFsLogIn){
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
        const [{ value: email }, { value: passwd }] = [...inputLogin].filter((input) => ['email', 'password'].includes(input.name));

        fetch(URL_API, {
            method: "POST",
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                emailUsuario: email,
                contraseniaUsuario: passwd
            })
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
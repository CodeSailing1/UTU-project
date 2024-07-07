const requeriments = {
    name: /^[a-zA-Z\s]{2,25}$/,
    lastName: /^[a-zA-Z\s]{2,25}$/,
    email:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,50}$/,
    password:/^[\w\S-¿?^*´!|#$%&/{}()=><;:,.-]{8,50}$/,
    day: /^[0-9\s]{1,4}$/,
    month: /^[0-9\s]{1,4}$/,
    year: /^[0-9\s]{1,4}$/
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

const signUpForm = document.getElementById("signUpForm");
const inputSignUp = document.querySelectorAll("#signUpForm input");
const submit = document.getElementById("signUp");

inputSignUp.forEach(input => {
    input.addEventListener("input", (e) => {
        let validation = validationInputs(requeriments[e.target.name], e.target.value, e.target.id);
        validationInputs(requeriments[e.target.name], e.target.value, e.target.id)
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
                return true;
            } else{
                element.classList.add("invalid");
                element.classList.remove("valid");
                tFs[idInput] = false;
                throw new Error("Ingresa valores validos");
            }
    }catch(e) {
        if(!requeriment.test(input)){
            console.error(e.message);
            return false
        }
    }
}

function submitValidation(validation) {
    let allElementsValid = true;
    inputSignUp.forEach( () => {
        if (validation) {
            allElementsValid = true;   
        } else {
            allElementsValid = false;   
        }
    });
    if (allElementsValid) {
        submit.removeAttribute("disabled");
    } else {
        submit.setAttribute("disabled", "");
    }
}


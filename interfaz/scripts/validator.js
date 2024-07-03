const requeriments = {
    name: /^[a-zA-Z\s]{2,25}$/,
    lastName: /^[a-zA-Z\s]{2,25}$/,
    email: /^[a-zA_.\S]+@[a-z]+\.[a-z]{2,50}$/,
    password:/^[\w\S-¿?^*´!|#$%&/{}()=><;:,.-]{8,50}$/
}
const tFs = {
    name: false,
    lastName: false,
    email: false,
    password:false
}

const signUpForm = document.getElementById("signUpForm");
const inputSignUp = document.querySelectorAll("#signUpForm input");

inputSignUp.forEach(input => {
    input.addEventListener("input", (e) => {
        validation(requeriments[e.target.name], e.target.value, e.target.id);
    });
});

function validation(requeriment, input, tF) {

    const element = document.getElementById(tF);
    try{
        if(requeriment.test(input)){
            element.classList.add("valid");
            element.classList.remove("invalid");
            tFs[tF] = true;
        } else{
            element.classList.add("invalid");
            element.classList.remove("valid");
            tFs[tF] = false;
            throw new Error("Ingresa valores validos");
        }
    }catch(e) {
        if(!requeriment.test(input)){
            console.error(e.message);
        }
    }
    console.log(requeriment.test(input))
}
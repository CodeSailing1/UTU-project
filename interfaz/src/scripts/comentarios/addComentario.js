document.addEventListener('DOMContentLoaded', () => {
    const number = document.getElementById('characters');
    const numberShown = document.getElementById('charactersShown');
    const formComment = document.getElementById('formComment');
    const inputComment = document.getElementById('comment');
    const buttonSend = document.getElementById('sendComment');
    const regexComment = /^[a-zA-Z0-9\s]{1,300}$/;
    const URL_API_COMMENTSADD = '/UTU-project/logica/comentarios/addComments.php';
    

    let params = new URLSearchParams(location.search);
    
    let id = params.get('id');
    console.log(id);

    inputComment.addEventListener("input", (e) => {
        if(validationInputs(regexComment, e.target.name, e.target.value)){
            console.log(e.target.value.length);
            if(e.target.value.length <= 1){
                numberShown.classList.remove('d-none');
                number.classList.add('d-none');
                buttonSend.setAttribute('disabled', '');
                throw new Error("Ingresa valores validos");
            } else {
                buttonSend.removeAttribute('disabled');
                numberShown.classList.add('d-none');
                number.classList.remove('d-none');
                let maxCharacters = 300;
                let characterCount = maxCharacters - e.target.value.length;
                number.innerHTML = characterCount;
            }
        }
        
    });
    function validationInputs(requeriments, inputName, input) {
        if (inputName !== 'comment') {  // Change according to your input names
            console.error(`No requirement found for input name: ${inputName}`);
            return false;
        }
        try {
            console.log('Validating input...');
            if (requeriments.test(input)) {
                return true;
            } else {
                return false
            }
        } catch (e) {
            console.error(e.message);
            return false;
        }
    }
    
    formComment.addEventListener('submit', (e)=> {
        e.preventDefault();
        fetch(URL_API_COMMENTSADD, {
            method: 'POST',
            body: JSON.stringify({
                idProducto: id,
                commentData: inputComment.value
            })
        })
        .then(response => response.json())
        .then(data => {
            if(data.success){
                console.log('Comentario agregado exitosamente');
                location.reload();
            }
        })
        .catch(error => {
            console.error('Error al agregar el comentario: ' + error)
        })
    })
})
document.addEventListener('DOMContentLoaded', () => {
    let params = new URLSearchParams(location.search);
    
    let query = params.get('id');
    
    const url = new URL('/UTU-project/logica/comentarios/showComments.php', location.origin);

    url.searchParams.set('id', query);
    const sectionComments = document.getElementById('sectionComments');
    console.log(url)
    fetch(url)
    .then(response => response.json())
    .then(data => {
        console.log(data)
        sectionComments.innerHTML = '';
        data.forEach(comment => {
            const murkUp = `
                <article class="bg-body-tertiary rounded-2 p-2 my-2 " heigth="1000px" width="100px">
                <h3>${comment.nombreUsuario}</h3>
                    <p class="text-break">${comment.textoComentario}</p>
                    <span>${comment.fechaComentario}</span>
                </article>
            `;
            sectionComments.insertAdjacentHTML('beforeend', murkUp);
        });
    })
})
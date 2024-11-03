const API = '/UTU-project/logica/inventario/addProductInventario.php';
document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('altasABM');
    
    form.addEventListener("submit", (e) => {
        e.preventDefault();
        const form = document.getElementById('altasABM');
        const formData = new FormData(form);  // Crear un objeto FormData con los datos del formulario

        fetch(API, { // consulta fetch hacia la api de altas de productos
            method: "POST",
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
            } else {
                console.error(data.error);
            }
        })
        .catch(error => {
            console.error(error);
        });
    });
})

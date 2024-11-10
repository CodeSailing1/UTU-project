document.addEventListener("DOMContentLoaded", () => {
    const URL_API_BAJAS = "/UTU-project/logica/productos/activateProduct.php";
    const confirm = document.getElementById('activateProductos');
    const observer = new MutationObserver(() => {
        getElements();
        observer.disconnect(); // Desconectar después de configurar los elementos
    });

    function getElements() {
        const products = document.querySelectorAll(".activate");
        products.forEach((product) => {
            product.addEventListener("click", () => {
                const id = product.getAttribute("id");
                console.log(id);
                activate(id);
            });
        });
    }

    function activate(id) {
        confirm.addEventListener('click', () => {
            fetch(URL_API_BAJAS, {
                method: "PUT",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ id: id })
            })
                .then((response) => response.json())
                .then((data) => {
                    if (data.success) {
                        console.log("Producto activado exitosamente");
                        location.reload();
                    }
                })
                .catch((error) => {
                    console.error("error: " + error);
                });
        })
    }

    observer.observe(document.body, { childList: true, subtree: true });
});
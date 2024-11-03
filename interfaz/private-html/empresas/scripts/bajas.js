document.addEventListener("DOMContentLoaded", () => {
    const URL_API_BAJAS = "/UTU-project/logica/productos/deleteProducts.php";
    const confirm = document.getElementById('eliminarProducto');
    const observer = new MutationObserver(() => {
        getElements();
        observer.disconnect(); // Desconectar después de configurar los elementos
    });

    function getElements() {
        const products = document.querySelectorAll(".eliminar");
        products.forEach((product) => {
            product.addEventListener("click", () => {
                const id = product.getAttribute("id");
                console.log(id);
                deleteProduct(id);
            });
        });
    }

    function deleteProduct(id) {
        confirm.addEventListener('click', () => {
            fetch(URL_API_BAJAS, {
                method: "DELETE",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ id: id })
            })
            .then((response) => response.json())
            .then((data) => {
                if (data.success) {
                    console.log("Producto eliminado exitosamente");
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
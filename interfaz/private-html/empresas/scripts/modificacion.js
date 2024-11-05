document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("modABM");
    console.log(form);
    const URL_MODIFY = "/UTU-project/logica/productos/updateProducts.php";
    const observer = new MutationObserver(() => {
        getElements();
        observer.disconnect();
    });

    observer.observe(document.body, { childList: true, subtree: true });
        function getElements() {
            const products = document.querySelectorAll(".modificar");
            products.forEach((product) => {
                product.addEventListener("click", () => {
                    const id = product.getAttribute("id");
                    const idInput = document.getElementById("idInput");
                    idInput.value = id;
                    modifyProduct(form);
                });
            });
        }

    function modifyProduct(form) {
        form.addEventListener("submit", (e) => {
            e.preventDefault();
            const forMod = new FormData(form);
            console.log(forMod);
            fetch(URL_MODIFY, {
                method: "POST",
                body: forMod,
            })
            .then((response) => response.json())
            .then(data => {
                if (data.success) {
                    console.log('success', data.message);
                    location.reload();
                } else {
                    console.error('Error:', data.message);
                }
            })
            .catch((error) => {
                console.error("Error:", error);
            });
        });
    }
});

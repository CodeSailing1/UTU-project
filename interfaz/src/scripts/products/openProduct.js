document.addEventListener("DOMContentLoaded", () => {
    const observer = new MutationObserver(() => {
        const products = document.querySelectorAll(".imgClickeable");
        if (products.length > 0) {
            console.log(products);
            observer.disconnect(); // Desconectar el observer una vez que hemos encontrado los productos
        }
    });
    observer.observe(document.body, { childList: true, subtree: true });

    document.body.addEventListener('click', (event) => {
        const target = event.target.closest('.imgClickeable');
        if (target) {
            const idProductos = target.getAttribute('id');
            const productURL = new URL('/UTU-project/interfaz/public-html/producto.php', window.location.href);
            productURL.searchParams.set('id', idProductos);
            window.location.href = productURL.href;
        }
    });
});

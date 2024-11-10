document.addEventListener("DOMContentLoaded", function(e) {
    const observer = new MutationObserver(() => {
        const products = document.querySelectorAll(".imgClickeable");
        if (products.length > 0) {
            console.log(products);
            observer.disconnect(); // Desconectar el observer una vez que hemos encontrado los productos
        }
    });
    observer.observe(document.body, { childList: true, subtree: true });
    const buttonPestaniaPaged = document.querySelector(`aside button.btn-outline-success`);
console.log(buttonPestaniaPaged);
    document.addEventListener("click", (e) => {
        const target = e.target.closest('.pestania');
        if (target) {
            const idPestania = target.getAttribute('id');
            const containerPestania = document.querySelector(`.${idPestania}`);
            const pestania = document.querySelector(`.d-block`);

            if (containerPestania) {
                containerPestania.classList.replace('d-none', 'd-block');
                pestania.classList.replace( 'd-block', 'd-none' );
            }
        }
    })
})


document.addEventListener('DOMContentLoaded', () => {
    fetch('/UTU-project/logica/productos/showProducts.php', {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json'
        }
    }) 
    .then(response => response.json())
    .then(data => {
        const productsContainer = document.getElementById("products");
        productsContainer.innerHTML = ''; // Clear the container

        data.forEach(product => {

            const template = `
            <div class="swiper-slide product col gap-2" id="${product.idProducto}">
                <div class="card" style="width: 16rem;">
            <a href="#" class="imgClickeable" id="${product.idProducto}" >
                    <img src="/UTU-project/persistencia/assets/${product.imagenProducto}" class="card-img-top "  " style="height:200px;" alt="...">
            </a>
                <div class="card-body">
                        <h4>${product.nombreProducto}</h2>
                        <h5>${product.precioProducto}</h4>
                        <p class="card-text">${product.descripcionProducto}</p>
                        <button class="btn btn-outline-success me-2 addCart" id="${product.idProducto}">Add to Cart</button>
                    </div>
                </div>
            </div>
            `;
            productsContainer.innerHTML += template; 
        });

        if(window.location.pathname === '/UTU-project/interfaz/public-html/index.php' || window.location.pathname === '/UTU-project/interfaz/public-html/producto.php'){
            const swiperContainer = document.getElementById("swiper-container");
            const swiper = new Swiper(swiperContainer, {
                spaceBetween: 30,
                loop: true,
                
                breakpoints: {
                    640: {
                        slidesPerView: 2,
                        spaceBetween: 20,
                    },
                    768: {
                        slidesPerView: 3,
                        spaceBetween: 40,
                    },
                    1024: {
                        slidesPerView: 3,
                        spaceBetween: 50,
                    },
                    1200: {
                        slidesPerView: 4,
                        spaceBetween: 60,
                    },
                    1440: {
                        slidesPerView: 4,
                        spaceBetween: 80,
                    }
                },
                
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
            });
        }
    })
})
import {viewedProduct} from "../usuario/insertHistory.js";
import {viewedIntoProduct} from "../usuario/insertViewedIntoProduct.js";

document.addEventListener('DOMContentLoaded', () => {
    let params = new URLSearchParams(location.search);

    let query = params.get('id');

    const url = new URL('/UTU-project/logica/productos/openProduct.php', location.origin);

    url.searchParams.set('id', query);
    const id = url.searchParams.get('id');
    fetch(url)
        .then(response => response.json())
        .then(data => {
            const productPlace = document.getElementById('productPlace');
            productPlace.innerHTML = '';
            const template = `
                <div class="row">
                    <section id="product-images" class="col-8"> 
                        <img src="/UTU-project/persistencia/assets/${data.imagenProducto}" alt="" id="principal-image" class="" height="500px" style="object-fit: cover;">
                    </section>
                    <aside id="product-data" class="col bg-body-tertiary rounded-2 p-5">
                        <h3>
                            ${data.nombreProducto}
                        </h3>
                        <p>${data.precioProducto}</p>
                        <form action="" method="POST">
                            <a class="btn btn-outline-success me-2 addCart" id="${data.idProducto}">Add to Cart</a>

                            <em>
                                <ul class="list-group" style="list-style: none">
                                    <li class="list-item my-1">
                                        <form>
                                            <div class="d-flex">
                                                <select class="form-control">
                                                    <option>1</option>
                                                    <option>2</option>
                                                    <option>3</option>
                                                    <option>4</option>
                                                    <option>5</option>
                                                </select>
                                                <input class="btn btn-outline-success" type="submit" value="Valorar Producto">
                                            </div>
                                            
                                        </form>
                                    </li>
                                </ul>
                            </em>
                        </form>
                    </aside>

                        </div>
                    <div class="row">
                        <section id="product-description" class="col">
                        <h2>Descripcion del producto</h2>
                        ${data.descripcionProducto}      
                    </section>
                    </div>
            `;
            productPlace.insertAdjacentHTML('beforeend', template);
            console.log('pepe');

        })
    viewedProduct(id);
    viewedIntoProduct(id);
})
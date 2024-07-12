setTimeout(()=>{
    const cart = document.getElementById("cart");
    console.log(cart);
    const btns = document.querySelectorAll(".product-card .product-btn");
    console.log(btns);
    const cantProd = {}
    
        async function addProd(){
            btns.forEach(button => {
                button.addEventListener("click", () => {
                    let productId = button.closest(".product-card").getAttribute("id");
                    let productName = document.querySelector(`#${productId} .product-name`).textContent;
                    let productPrice = document.querySelector(`#${productId} .product-price`).textContent;
                    
                    if (!cantProd[productId]) {
                        cantProd[productId] = {
                            name: productName,
                            price: productPrice,
                            quantity: 1
                        };
                        const productLi = `
                            <li id="${productId}">
                                ${cantProd[productId].name} ${cantProd[productId].quantity}
                                <span>${cantProd[productId].price}</span>
                                <button class="del-product">X</button>   
                            </li>
                        `;
                        cart.insertAdjacentHTML (`beforeend`, productLi) ;

                    } else {
                        cantProd[productId].quantity++;
                        let precio = Number(cantProd[productId].price);
                        precio += precio;
                        const productLi = `
                            <li id="${productId}">
                                ${cantProd[productId].name} ${cantProd[productId].quantity}
                                <span>${precio}</span>
                                <button class="del-product">X</button>   
                            </li>
                        `;
                        const existingItem = document.querySelector(`#cart li[id="${productId}"]`);
                        existingItem.innerHTML = productLi;
                    }
                }); 
            }); 
        }
    
        async function delProd(){
            await addProd();
            cart.addEventListener("click", (e) => {
            
                let prodDel = e.target.parentElement;
                let productId = prodDel.getAttribute("id");
        
                if (cantProd[productId]) {
                    cantProd[productId].quantity--;
                    if (cantProd[productId].quantity === 0) {
                        delete cantProd[productId];
                        prodDel.remove();
                    } else {
                        prodDel.innerHTML = `
                        ${cantProd[productId].name} ${cantProd[productId].quantity}
                        <span>${cantProd[productId].price}</span>
                        <button class="del-product">X</button>
                        `;
                    }
                }
            });
        }
        delProd();
}, 1000);

fetch("./json/product.json",{
    method: "GET"
})
    .then(product =>{
        return product.json();
    })
    .then(data =>{
        data.forEach(mobilePhones =>{
            const markup = `
                <li class="product"><a class="products-fetched" href="${mobilePhones.url}" target="_blank"><img src="${mobilePhones.img}">hola</a></li>`;
            document.getElementById(`carrito-list`).innerHTML(`beforeend`, markup)
        })
    })
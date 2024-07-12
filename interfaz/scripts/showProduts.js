fetch("./json/product.json")
    .then(response => response.json())
    .then(data => {
        const mobilePhones = data.products[0].mobilePhones;
        for (let i = 0; i < mobilePhones.length; i++) {
            const product = mobilePhones[i];
            const markup = `
            <article class="product-card" id="${product.id}">
                <a class="product-name" href="${product.url}" target="_blank">
                    ${product.name}
                </a>
                <span class="product-price">${product.price}</span>
                <button class="product-btn" type="button">Add</button>
            </article>
            `;
            document.getElementById("products").insertAdjacentHTML("beforeend", markup);
            console.log(markup);
        }
    })

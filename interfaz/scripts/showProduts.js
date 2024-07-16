fetch("./json/product.json")
    .then(response => response.json())
    .then(data => {
        const mobilePhones = data.products[0].mobilePhones;
        for (let i = 0; i < mobilePhones.length; i++) {
            const product = mobilePhones[i];
            const markup = `
            <article class="product-card" id="${product.id}">
                <a class="product-name" href="${product.url}" target="_blank">
                  <img src="${product.img}" class="product-img">
                  ${product.name}
                </a>
                <span class="product-price">${product.price}</span>
                <div>
                  <button class="product-btn" type="button">Add</button>
                </div>
            </article>
            `;
            document.getElementById("products").insertAdjacentHTML("beforeend", markup);
            console.log(markup);
        }
    })
fetch("./json/product.json")
    .then(response => response.json())
    .then(data => {
        const mobilePhones = data.products[0].mobilePhones;
        for (let i = 0; i < mobilePhones.length; i++) {
            const product = mobilePhones[i];
            const markup = `
            <article class="product-card" id="${product.id}">
                <a class="product-name" href="${product.url}" target="_blank">
                  <img src="${product.img}">
                  ${product.name}
                </a>
                <span class="product-price">${product.price}</span>
                <div>
                  <button class="product-btn" type="button">Add</button>
                </div>
            </article>
            `;
            document.getElementById("products-1").insertAdjacentHTML("beforeend", markup);
            console.log(markup);
        }
    })

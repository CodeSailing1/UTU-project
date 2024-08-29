const img = document.getElementById("imagen");
const backward = document.getElementById("prevBtn");
const forward = document.getElementById("nextBtn");

const images = [
    `../src/img/luca-micheli-ruWkmt3nU58-unsplash.webp`,
    `../src/img/Claptransparente.png`,
    `../src/img/png-mobile-phone-png-icns-more-512.webp`
];
let position = 0;

function nextPhoto() {
    if(position >= images.length - 1) {
        position = 0;
    } else {
        position++;
    }
    render();
}

function lastPhoto() {
    if(position <= 0) {
        position = images.length - 1;
    } else {
        position--;
    }
    render();
}

function render () {
    const muckup = `
        <img src="${images[position]}" class="carrousel-image" alt="Carrousel Image"></img>
    `;
    img.innerHTML = muckup;
}

render();
forward.addEventListener("click", nextPhoto);
backward.addEventListener("click", lastPhoto);


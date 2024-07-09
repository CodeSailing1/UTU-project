let cuantity = 0;
const image = document.getElementsByClassName("carrousel-image");
const carrouselContainer = document.querySelector("article carrousel-container");
const carrousel = document.querySelector("carrousel");
const buttonBackwards = document.getElementsByClassName("carrousel-back");
const buttonForward = document.getElementsByClassName("carrousel-forward");

for(let i = 0; i<image.length; i++){cuantity++}
console.log(cuantity);
const swiperContainer = document.getElementById("swiper-container1");
        const swiper = new Swiper(swiperContainer, {
            loop: true,
            spaceBetween: 30,
            effect: "creative",
            creativeEffect: {
                prev: {
                    translate: ["-120%", 0, -500],
                },
                next: {
                    translate: ["120%", 0, -500],
                },
            },
            autoplay: {
                delay: 3000,
                disableOnInteraction: true,
            },
            pagination:{
                    el: ".swiper-pagination",
            }
        });
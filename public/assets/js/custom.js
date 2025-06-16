(function ($) {
    $(document).ready(function () {
        $('.menu-toggle').click(function () {
            $('body').toggleClass('menu-open');
            $('.mobile-menus').slideToggle(500);
        });


        var swiper1 = new Swiper(".highestSwiper", {
            loop: true,
            slidesPerView: 1,
            spaceBetween: 24,

            breakpoints: {
                768: {
                    slidesPerView: 2,
                    spaceBetween: 24,
                },
                992: {
                    slidesPerView: 3,
                    spaceBetween: 24,
                }
            },

            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            on: {
                init: function () {
                    toggleNavigation(this);
                },
                resize: function () {
                    toggleNavigation(this);
                }
            }
        });

        function toggleNavigation(swiperInstance) {
            // Count only real (non-duplicate) slides
            const totalSlides = swiperInstance.wrapperEl.querySelectorAll(".swiper-slide:not(.swiper-slide-duplicate)").length;

            let slidesPerView = 1;
            const width = window.innerWidth;
            console.log("Total Slides:", totalSlides, "Width:", width);

            if (width >= 992) slidesPerView = 3;
            else if (width >= 768) slidesPerView = 2;

            const showNav = totalSlides > slidesPerView;
            console.log("ShowNav:", showNav, "slidesPerView:", slidesPerView, "totalSlides:", totalSlides);

            const navButtons = document.querySelectorAll(".swiper-contols");
            navButtons.forEach(el => {
                el.style.display = showNav ? "d-flex" : "none";
            });
        }



        var swiper = new Swiper(".testimonalSwiper", {
            loop: true,
            slidesPerView: 1.3,
            spaceBetween: 24,

            breakpoints: {
                768: {
                    slidesPerView: 2.5,
                    spaceBetween: 24,
                },
                992: {
                    slidesPerView: 3.5,
                    spaceBetween: 24,
                }
            }
        });


        $(document).ready(function () {
            $('.gallery').magnificPopup({
                delegate: 'a',
                type: 'image',
                gallery: {
                    enabled: true
                }
            });
        });

        $(".logged-in .fa-bell").click(function () {
            $(".logged-in").toggleClass("active");
        });

    });

})(jQuery);

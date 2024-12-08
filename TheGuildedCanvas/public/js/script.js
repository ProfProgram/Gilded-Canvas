document.addEventListener('DOMContentLoaded', () => {
    const sliderTrack = document.querySelector('.slider-track');
    const prevBtn = document.querySelector('.prev-btn');
    const nextBtn = document.querySelector('.next-btn');

    let currentIndex = 0;

    function updateSlider() {
        if (sliderTrack) {
            const slideWidth = document.querySelector('.product-slide').offsetWidth;
            sliderTrack.style.transform = `translateX(-${currentIndex * slideWidth}px)`;
        }
    }

    if (prevBtn && nextBtn && sliderTrack) {
        prevBtn.addEventListener('click', () => {
            currentIndex = Math.max(currentIndex - 1, 0);
            updateSlider();
        });

        nextBtn.addEventListener('click', () => {
            const totalSlides = document.querySelectorAll('.product-slide').length;
            const maxIndex = totalSlides - Math.floor(sliderTrack.clientWidth / document.querySelector('.product-slide').clientWidth);
            currentIndex = Math.min(currentIndex + 1, maxIndex);
            updateSlider();
        });

        // Auto-slide functionality
        let autoSlide = setInterval(() => {
            const totalSlides = document.querySelectorAll('.product-slide').length;
            currentIndex = (currentIndex + 1) % totalSlides;
            updateSlider();
        }, 5000);

        sliderTrack.addEventListener('mouseover', () => clearInterval(autoSlide));
        sliderTrack.addEventListener('mouseout', () => {
            autoSlide = setInterval(() => {
                const totalSlides = document.querySelectorAll('.product-slide').length;
                currentIndex = (currentIndex + 1) % totalSlides;
                updateSlider();
            }, 5000);
        });

        window.addEventListener('resize', updateSlider);
    }
});

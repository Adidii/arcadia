let currentIndex = 0;
const slides = document.querySelectorAll(".slide");
const totalSlides = slides.length;

const updateSlides = () => {
    slides.forEach((slide, index) => {
        slide.style.opacity = index === currentIndex ? "1" : "0";
        slide.style.transition = "opacity 1s ease-in-out";
    });
};

const moveSlide = (direction) => {
    currentIndex = (currentIndex + direction + totalSlides) % totalSlides;
    updateSlides();
};

document.querySelector(".prev").addEventListener("click", () => moveSlide(-1));
document.querySelector(".next").addEventListener("click", () => moveSlide(1));

// Auto-slide
setInterval(() => moveSlide(1), 5000);

// Initialize slides
updateSlides();

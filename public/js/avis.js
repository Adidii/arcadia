// Review carousel logic
const reviewsContainer = document.getElementById('reviewsContainer');
const reviews = reviewsContainer.querySelectorAll('.review-item');
let reviewIndex = 0;

document.getElementById('review-arrow-left').addEventListener('click', () => {
    reviewIndex = (reviewIndex > 0) ? reviewIndex - 1 : reviews.length - 1;
    updateCarousel();
});

document.getElementById('review-arrow-right').addEventListener('click', () => {
    reviewIndex = (reviewIndex < reviews.length - 1) ? reviewIndex + 1 : 0;
    updateCarousel();
});

function updateCarousel() {
    reviewsContainer.style.transform = `translateX(-${reviewIndex * 100}%)`;
}

// Burger menu toggle
const menuToggle = document.querySelector('.menu-toggle');
const navLinks = document.querySelector('.nav-links');

menuToggle.addEventListener('click', () => {
    navLinks.classList.toggle('active');
    menuToggle.classList.toggle('active');
});

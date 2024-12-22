// Slider des images
let slideIndex = 0;
const imageSlides = document.querySelectorAll('.slide'); // Toutes les slides d'image
const totalImageSlides = imageSlides.length;

function showImageSlide(n) {
    imageSlides.forEach((slide, index) => {
        slide.style.display = "none"; // Cacher toutes les images
    });
    imageSlides[n].style.display = "block"; // Afficher uniquement l'image active
}

function moveImageSlide(step) {
    slideIndex = (slideIndex + step + totalImageSlides) % totalImageSlides;
    showImageSlide(slideIndex);
}

function autoImageSlide() {
    moveImageSlide(1); // Passe à la prochaine image
}

// Démarrer le slider automatique toutes les 5 secondes
setInterval(autoImageSlide, 5000);

// Slider manuel (avec boutons de navigation)
document.querySelector('.prev').addEventListener('click', function() {
    moveImageSlide(-1); // Slide précédente
});

document.querySelector('.next').addEventListener('click', function() {
    moveImageSlide(1); // Slide suivante
});

// Initialisation : affiche la première image au démarrage
showImageSlide(slideIndex);

// Navbar scroll behavior
document.addEventListener('scroll', function() {
    const navbar = document.querySelector('.navbar');
    if (window.scrollY > 50) {
        navbar.classList.add('scrolled'); // Ajouter la classe "scrolled" si le scroll dépasse 50px
    } else {
        navbar.classList.remove('scrolled'); // Retirer la classe si le scroll est inférieur à 50px
    }
});

// Slider des avis (défilement automatique)
let avisIndex = 0;
const avisSlides = document.querySelectorAll('.avis-slide');
const totalAvisSlides = avisSlides.length;

function showNextAvisSlide() {
    const avisSlider = document.querySelector('.avis-slider');
    avisIndex = (avisIndex + 1) % totalAvisSlides;
    avisSlider.style.transform = `translateX(-${avisIndex * 100}%)`; // Défilement horizontal
}

// Faire défiler les avis toutes les 4 secondes
setInterval(showNextAvisSlide, 4000);

function toggleMenu() {
    var burgerMenu = document.querySelector('.burger-menu');
    var navLinks = document.querySelector('.nav-links');

    burgerMenu.classList.toggle('active');
    navLinks.classList.toggle('active');
}

// Ouvrir le modal
function openModal(modalId) {
    document.getElementById('habitatModal' + modalId).style.display = "block";
}

// Fermer le modal
function closeModal(modalId) {
    document.getElementById('habitatModal' + modalId).style.display = "none";
}

// Fonction pour afficher la slide précédente
function prevSlide(modalId) {
    let modal = document.getElementById('habitatModal' + modalId);
    let images = modal.querySelectorAll('.carousel-image');
    let currentIndex = getActiveIndex(images);

    images[currentIndex].classList.remove('active');
    let newIndex = (currentIndex === 0) ? images.length - 1 : currentIndex - 1;
    images[newIndex].classList.add('active');
}

// Fonction pour afficher la slide suivante
function nextSlide(modalId) {
    let modal = document.getElementById('habitatModal' + modalId);
    let images = modal.querySelectorAll('.carousel-image');
    let currentIndex = getActiveIndex(images);

    images[currentIndex].classList.remove('active');
    let newIndex = (currentIndex === images.length - 1) ? 0 : currentIndex + 1;
    images[newIndex].classList.add('active');
}

// Fonction pour obtenir l'index de l'image active
function getActiveIndex(images) {
    for (let i = 0; i < images.length; i++) {
        if (images[i].classList.contains('active')) {
            return i;
        }
    }
    return 0;
}
function toggleMenu() {
    var burgerMenu = document.querySelector('.burger-menu');
    var navLinks = document.querySelector('.nav-links');

    burgerMenu.classList.toggle('active');
    navLinks.classList.toggle('active');
}

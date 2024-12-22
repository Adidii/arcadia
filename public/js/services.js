function openModal(index) {
    var modal = document.getElementById('serviceModal' + index);
    modal.style.display = 'block';
}

function closeModal(index) {
    var modal = document.getElementById('serviceModal' + index);
    modal.style.display = 'none';
}

// Fermer le modal si l'utilisateur clique en dehors du modal
window.onclick = function(event) {
    var modals = document.getElementsByClassName('modal');
    for (var i = 0; i < modals.length; i++) {
        if (event.target == modals[i]) {
            modals[i].style.display = 'none';
        }
    }
}

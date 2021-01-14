// Button Animation
function animateOption(button) {
    button.classList.add('animated');
}

function openPopup(itemId, imageUrl) {
    closePopup();

    document.querySelector('.popup').classList.remove('hideme');
    document.querySelector('.popup #recommendable_id').value = itemId;
    document.querySelector('.popup .backdrop_image').style = `background-image: url(${imageUrl})`;
}

function closePopup() {
    document.querySelector('.popup').classList.add('hideme');
}

const toggleButton = document.getElementById('toggle-button');
const toggleContent = document.getElementById('toggle-content');
toggleButton.addEventListener('click', function() {
    if (toggleContent.style.display === 'none') {
        toggleContent.style.display = 'block';
    } else {
        toggleContent.style.display = 'none';
    }
});
const pickUpButton = document.getElementById('pickUp-button');
tippy(pickUpButton, {
    content: 'ランダムで近くのレストランをピックアップするよ！',
    placement: 'top',
    animation: 'fade',
    delay: [200, 100],
    maxWidth: 'none',
    theme: 'my-custom-theme'
});
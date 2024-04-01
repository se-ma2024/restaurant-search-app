const keywordButton = document.getElementById('keyword-button');
tippy(keywordButton, {
    content: '地名や駅名を指定してみよう！',
    placement: 'top',
    animation: 'fade',
    delay: [200, 100],
    maxWidth: 'none',
    theme: 'my-custom-theme'
});
const searchButton = document.getElementById('search-button');
tippy(searchButton, {
    content: '指定した範囲内のレストランを検索するよ！',
    placement: 'top',
    animation: 'fade',
    delay: [200, 100],
    maxWidth: 'none',
    theme: 'my-custom-theme'
});
const pickUpButton = document.getElementById('pickUp-button');
tippy(pickUpButton, {
    content: 'ランダムで近くのレストランをピックアップするよ！',
    placement: 'top',
    animation: 'fade',
    delay: [200, 100],
    maxWidth: 'none',
    theme: 'my-custom-theme'
});
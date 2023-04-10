const exploreButton = document.querySelector('button.explore');
const explorePanel = document.querySelector('.explore-panel');

// explorePanel.classList.add('hide');

exploreButton.addEventListener('click', (event) => {
    explorePanel.classList.toggle('expand');
    // explorePanel.classList.toggle('hide');
});
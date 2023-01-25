const searchBox = document.getElementById('search').value;
const engine = document.getElementById('engine');
const searchButton = document.getElementById('searchButton');

searchBox.addEventListener('input', () => {
    engine.setAttribute('href'+searchBox.value);
})

searchButton.addEventListener('click',)
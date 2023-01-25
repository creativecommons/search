const searchBox = document.getElementById('search').value;
const engine = document.getElementById('engine');
const searchButton = document.getElementById('searchButton');
searchButton.addEventListener

searchBox.addEventListener('input', function searchEngine() {
    engine.setAttribute('href'+searchBox.value);
})


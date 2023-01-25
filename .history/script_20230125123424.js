const searchBox = document.querySelector("#search-value");
const engine = document.querySelector("#engine");
const searchButton = document.querySelector("#searchBtn");
let data = document.querySelectorAll('[data-engine]');
console.log(data);
let searchInput;
let link;
let card;


searchBox.addEventListener("input", searchEngine);
function searchEngine(e) {
  console.log(e.target.value);
  //   engine.setAttribute("href",`http://ccmixter.org/search?search_text=${e.target.value}&search_type=any&search_in=all`);
//   link = `http://ccmixter.org/search?search_text=${e.target.value}&search_type=any&search_in=all`;
//creating the state of the link
  searchInput = e.target.value;
}

searchButton.addEventListener("click", Navigate);
function Navigate() {
  console.log(link);
  window.open(link, "_blank");
}

for (let i = 0; i < data.length; i++) {
    data[i].addEventListener('click', cardClick);
    
}
function cardClick(e) {
    // console.log(e.target)
    let search = e.target.getAttribute('data-search');
    let searchEngine = e.target.getAttribute('data-engine');
    link = getURL(searchEngine, search, searchInput);
    console.log(link);
}

function getURL(value, search, input) {
    switch(value) {
        case 'ccmixter':
            return `${search}${input}&search_type=any&search_in=all`;
        case 'europeana':
            return 'http://www.example2.com';
        case 'flickr':
            return 'http://www.example3.com';
        default:
            return 'Invalid value';
    }
}

// searchButton.addEventListener("click", searchEngine);
// console.log(searchBox.value);

// searchBox.addEventListener("input", function searchEngine() {
//   engine.setAttribute("href","http://ccmixter.org/search?="+searchBox.value);
// });

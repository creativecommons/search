const searchBox = document.querySelector("#search-value");
const engine = document.querySelector("#engine");
const searchButton = document.querySelector("#searchBtn");
let data = document.querySelectorAll('[data-engine]');
// console.log(data);
let searchInput;
let link;
let card;

//add event listener to the search box to know
searchBox.addEventListener("input", searchEngine);
function searchEngine(e) {
  console.log(e.target.value);
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
   
    let search = e.target.parentNode.getAttribute('data-search');
    let searchEngine = e.target.parentNode.getAttribute('data-engine');
    console.log({searchEngine, search});
    link = getURL(searchEngine, search, searchInput);
    console.log(link);
}

function getURL(value, search, input) {
    console.log(value);
    switch(value) {
        case 'ccmixter':
            return `${search}${input}&search_type=any&search_in=all`;
        case 'europeana':
            return `${search}${input}`;
        case 'flickr':
            return `${search}${input}`;
        default:
            return 'Invalid value';
    }
}

// searchButton.addEventListener("click", searchEngine);
// console.log(searchBox.value);

// searchBox.addEventListener("input", function searchEngine() {
//   engine.setAttribute("href","http://ccmixter.org/search?="+searchBox.value);
// });

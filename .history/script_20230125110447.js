const searchBox = document.querySelector("#search-value");
const engine = document.quer("engine");
const searchButton = document.getElementById("searchButton");

searchBox.addEventListener("input", searchEngine);
function searchEngine(e) {
  console.log(e.target.value);
}

// searchButton.addEventListener("click", searchEngine);
// console.log(searchBox.value);

// searchBox.addEventListener("input", function searchEngine() {
//   engine.setAttribute("href","http://ccmixter.org/search?="+searchBox.value);
// });
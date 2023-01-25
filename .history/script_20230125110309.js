const searchBox = document.querySelector("#search-value");
const engine = document.getElementById("engine");
const searchButton = document.getElementById("searchButton");

searchBox.addEventlistener("onchange");
function searchEngine(e) {
  console.log(e.target.value);
}

// searchButton.addEventListener("click", searchEngine);
// console.log(searchBox.value);

// searchBox.addEventListener("input", function searchEngine() {
//   engine.setAttribute("href","http://ccmixter.org/search?="+searchBox.value);
// });

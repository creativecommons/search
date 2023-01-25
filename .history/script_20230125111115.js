const searchBox = document.querySelector("#search-value");
const engine = document.querySelector("#engine");
const searchButton = document.getElementById("searchButton");

searchBox.addEventListener("input", searchEngine);
function searchEngine(e) {
  console.log(e.target.value);
  engine.setAttribute("href","http://ccmixter.org/search?="+e.target.value);  
  engine.setAttribute("href",`()`);  
  
}



// searchButton.addEventListener("click", searchEngine);
// console.log(searchBox.value);

// searchBox.addEventListener("input", function searchEngine() {
//   engine.setAttribute("href","http://ccmixter.org/search?="+searchBox.value);
// });

const searchBox = document.getElementById("search").value;
const engine = document.getElementById("engine");
const searchButton = document.getElementById("searchButton");
searchButton.addEventListener("click", searchEngine);

searchBox.addEventListener("input", function searchEngine() {
  engine.setAttribute("href","http://ccmixter.org/search?="+searchBox.value);
});

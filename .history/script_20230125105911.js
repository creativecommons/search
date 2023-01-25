const searchBox = document.querySelector("#search-value");
const engine = document.getElementById("engine");
const searchButton = document.getElementById("searchButton");


searchBox.addEventlistener("input", function searchEngine() {
    console.log(searchBox.value);
)}

// searchButton.addEventListener("click", searchEngine);
// console.log(searchBox.value);


// searchBox.addEventListener("input", function searchEngine() {
//   engine.setAttribute("href","http://ccmixter.org/search?="+searchBox.value);
// });

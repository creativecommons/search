const searchBox = document.querySelector("#search-value");
const engine = document.querySelector("#engine");
const searchButton = document.querySelector("#searchButton");
let link 

searchBox.addEventListener("input", searchEngine);
function searchEngine(e) {
  console.log(e.target.value);
//   engine.setAttribute("href",`http://ccmixter.org/search?search_text=${e.target.value}&search_type=any&search_in=all`);  
  engine.setAttribute("href",`http://ccmixter.org/search?search_text=${e.target.value}&search_type=any&search_in=all`);  
    
}

searchButton.addEventListener("click", function(){
    location.href = "https://www.google.com";
  });



// searchButton.addEventListener("click", searchEngine);
// console.log(searchBox.value);

// searchBox.addEventListener("input", function searchEngine() {
//   engine.setAttribute("href","http://ccmixter.org/search?="+searchBox.value);
// });

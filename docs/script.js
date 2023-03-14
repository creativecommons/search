const searchBox = document.querySelector("#search-value");
const engine = document.querySelector("[data-object]");
const searchButton = document.querySelector("#searchBtn");
let data = document.querySelectorAll("[data-engine]");
let searchInput;
let link;
let card;

engine.addEventListener("click", onActiveState);
function onActiveState(e) {
  //engine.style.backgroundColor = "red";
  engine.classList.toggle;
  console.log(engine.className);
  //searchButton.stlye.backgroundColor = "red";
}

// add event listener to the search box to know what the user is typing
searchBox.addEventListener("input", searchEngine);
function searchEngine(e) {
  console.log(e.target.value);
  // create the state of the link
  searchInput = e.target.value;
}

// add event listener to the search button to know when the user clicks on it
searchButton.addEventListener("click", Navigate);
// create the function to open the link in a new tab
function Navigate() {
  if (searchInput === undefined) {
    alert("Please enter a search value");
    return;
  }
  if (link === undefined) {
    alert("Please select a search engine");
    return;
  }
  window.open(link, "_blank");
}

// add event listener to the cards to know when the user clicks on anyone of
// them
for (let i = 0; i < data.length; i++) {
  data[i].addEventListener("click", cardClick);
}

// create the function to get the data from the cards
function cardClick(e) {
  let searchUrl, searchEngine;
  console.log(e.target); //DEBUG
  if (e.target.tagName === "p") {
    searchUrl = e.target.parentNode.getAttribute("data-url");
    searchEngine = e.target.parentNode.getAttribute("data-engine");
  } else {
    searchUrl = e.target.getAttribute("data-url");
    searchEngine = e.target.getAttribute("data-engine");
  }
  console.log({ searchEngine, searchUrl, searchInput }); //DEBUG
  link = getURL(searchEngine, searchUrl, searchInput);
  console.log(link);
}

// create the function to get the link and build the search query from the
// card that the user clicked on
function getURL(value, searchUrl, input) {
  switch (value) {
    case null:
    case "":
      return "Invalid value";
    default:
      return `${searchUrl}${input}`;
  }
}

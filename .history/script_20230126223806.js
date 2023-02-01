const searchBox = document.querySelector("#search-value");
const engine = document.querySelectorAll("#engine");
const searchButton = document.querySelector("#searchBtn");
let data = document.querySelectorAll("[data-engine]");
let searchInput;
let link;
let card;


engine.addEventListener("click", onActiveState);
function onActiveState(e) {
  // engine.style.backgroundColor = "red";
  engine.classList.toggle("active");
  console.log(engine.className);
  // searchButton.stlye.backgroundColor = "red";
}
//add event listener to the search box to know what the user is typing
searchBox.addEventListener("input", searchEngine);
function searchEngine(e) {
  console.log(e.target.value);
  //creating the state of the link
  searchInput = e.target.value;
}

//add event listener to the search button to know when the user clicks on it
searchButton.addEventListener("click", Navigate);
//creating the function to open the link in a new tab
function Navigate() {
  if (searchInput === undefined) {
    alert("Please enter a search value");
    return;
  }
  window.open(link, "_blank");
}



//add event listener to the cards to know when the user clicks on anyone of them
for (let i = 0; i < data.length; i++) {
  data[i].addEventListener("click", cardClick);
}

//creating the function to get the data from the cards
function cardClick(e) {
    console.log(e.target);
  let search = e.target.parentNode.getAttribute("data-search");
  let searchEngine = e.target.parentNode.getAttribute("data-engine");
  console.log({searchEngine, search, searchInput});
  link = getURL(searchEngine, search, searchInput);
  console.log(link);
}

//creating the function to get the link and build the search query from the card that the user clicked on
function getURL(value, search, input) {
  switch (value) {
    case "ccmixter":
      return `${search}${input}&search_type=any&search_in=all`;
    case "europeana":
      return `${search}${input}`;
    case "flickr":
      return `${search}${input}`;
    case "google":
      return `${search}${input}`;
    case "googleimages":
      return `${search}${input}`;
    case "jamendo":
      return `${search}${input}`;
    default:
      return "Invalid value";
  }
}

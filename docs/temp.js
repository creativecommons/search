document.addEventListener("DOMContentLoaded", function(e){

    const searchForm = document.getElementById("searchForm");

    searchForm.addEventListener("submit", (e) => {
        e.preventDefault();
      
        // capture and process the submission
        console.log('captured cleanly!');

        let form = {};
        form.query = document.getElementById("query").value;
        form.commercial = document.getElementById("commercial").checked;
        form.modify = document.getElementById("modify").checked;
        selectedEngine = document.querySelector('input[name="search-engine"]:checked');
        form.searchEngine = selectedEngine.value;
        form.searchEngineURL = selectedEngine.dataset.url;

        // build URL & navigate to link
        let link = buildURL(form);
        navigateTo(link);
      });

      // navigate behavior
      function navigateTo(link) {

        if (link) {
            window.open(link, "_blank");
        }
      }

      // construct the URL
      function buildURL(form) {
        if (form.query === '') {
            alert("Please enter a search value");
            return;
          }
          if (form.searchEngineURL === undefined) {
            alert("Please select a search engine");
            return;
          }

        let licenseParams = getLicenseParams(form);

        return  form.searchEngineURL + form.query + licenseParams;
      }

      // construct license params by engine convention
      function getLicenseParams(form) {

        // prolly gonna need a switch here to handle this per engine, with a default fallback


        return '';
      }

});
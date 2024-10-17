document.addEventListener("DOMContentLoaded", function (e) {
  const searchForm = document.getElementById("searchForm");

  searchForm.addEventListener("submit", (e) => {
    e.preventDefault();

    // capture and process the submission
    console.log("captured cleanly!");

    let form = {};
    form.query = document.getElementById("query").value;
    form.commercial = document.getElementById("commercial").checked;
    form.modify = document.getElementById("modify").checked;
    selectedEngine = document.querySelector(
      'input[name="search-engine"]:checked',
    );
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
    if (form.query === "") {
      alert("Please enter a search value");
      return;
    }
    if (form.searchEngineURL === undefined) {
      alert("Please select a search engine");
      return;
    }

    let licenseParams = getLicenseParams(form);
    return form.searchEngineURL + form.query + licenseParams;
  }

  // construct license params by engine convention
function getLicenseParams(form) {
  let rights = "";

  // Check if commercial or modify options are selected
  if (form.commercial || form.modify) {
    switch (form.searchEngine) {
      case "ccmixter":
        rights = "&f=license:";
        if (form.commercial && form.modify) {
          rights += "cc-by,cc-by-sa";
        } else if (form.commercial) {
          rights += "cc-by,cc-by-nc";
        } else if (form.modify) {
          rights += "cc-by,cc-by-nd";
        }
        break;

      case "europeana":
        rights = "+AND+RIGHTS%3A*creative*+";
        if (form.commercial && form.modify) {
          rights += "AND+NOT+RIGHTS%3A*nc*+AND+NOT+RIGHTS%3A*nd*";
        } else if (form.commercial) {
          rights += "AND+NOT+RIGHTS%3A*nc*";
        } else if (form.modify) {
          rights += "AND+NOT+RIGHTS%3A*nd*";
        }
        break;

      case "flickr":
        rights = "&license=";
        if (form.commercial && form.modify) {
          rights += "4%2C5%2C9%2C10";
        } else if (form.commercial) {
          rights += "4%2C5%2C6%2C9%2C10";
        } else if (form.modify) {
          rights += "1%2C2%2C9%2C10";
        }
        break;

      case "google":
      case "googleimages":
        rights = "&as_rights=(cc_publicdomain|cc_attribute|cc_sharealike).-";
        if (form.commercial && form.modify) {
          rights += "(cc_noncommercial|cc_nonderived)";
        } else if (form.commercial) {
          rights += "(cc_noncommercial)";
        } else if (form.modify) {
          rights += "(cc_nonderived)";
        }
        break;

      case "jamendo":
        rights = "";
        if (form.commercial && form.modify) {
          rights += "";
        } else if (form.commercial) {
          rights += "";
        } else if (form.modify) {
          rights += "";
        }
        break;

      case "openverse":
        rights = "&license_type=";
        if (form.commercial && form.modify) {
          rights += "commercial,modification";
        } else if (form.commercial) {
          rights += "commercial";
        } else if (form.modify) {
          rights += "modification";
        }
        break;

      case "soundcloud":
        rights = "&filter.license=";
        if (form.commercial && form.modify) {
          rights += "to_modify_commercially";
        } else if (form.commercial) {
          rights += "to_use_commercially";
        } else if (form.modify) {
          rights += "to_share";
        }
        break;

      case "thingiverse":
        rights = "&license_type=";
        if (form.commercial && form.modify) {
          rights += "commercial,modification";
        } else if (form.commercial) {
          rights += "commercial";
        } else if (form.modify) {
          rights += "modification";
        }
        break;

      case "vimeo":
        rights = "&license=";
        if (form.commercial && form.modify) {
          rights += "by";
        }
        break;

      case "youtube":
        rights = "&sp=EgIwAQ%253D%253D";
        if (form.commercial && form.modify) {
          rights += ""; // Add appropriate filters for YouTube as per your requirement
        }
        break;

      default:
        rights = ""; // Default case if the search engine doesn't require any rights parameters
        break;
    }
  }

  return rights;
}

});

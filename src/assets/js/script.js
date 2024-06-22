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

      let rights;

      // engine licenses logic alphabetically
      // does nothing for now, will revisit later

      if (form.commercial || form.modify) {
        switch (form.searchEngine) {

          case "ccmixter":
            rights = '';
            if (form.commercial && form.modify) {
              rights += '&lic=by,sa,s,splus,pd,zero';
            } else if (form.commercial) {
              rights += '&lic=open';
            } else if (form.modify) {
              rights += '&lic=by,nc,sa,ncsa,s,splus,pd,zero';
            }
          break;

          case "europeana":
            rights = '+AND+RIGHTS%3A*creative*+';
            if (form.commercial && form.modify) {
              rights += 'AND+NOT+RIGHTS%3A*nc*+AND+NOT+RIGHTS%3A*nd*';
            } else if (form.commercial) {
              rights += 'AND+NOT+RIGHTS%3A*nc*';
            } else if (form.modify) {
              rights += 'AND+NOT+RIGHTS%3A*nd*';
            }
          break;

          case "flickr":
            rights = '&license=';
            if (form.commercial && form.modify) {
              rights += '4%2C5%2C9%2C10';
            } else if (form.commercial) {
              rights += '4%2C5%2C6%2C9%2C10';
            } else if (form.modify) {
              rights += '1%2C2%2C9%2C10';
            }
          break;

          case "google":
            rights = '&as_rights=(cc_publicdomain|cc_attribute|cc_sharealike).-';
            if (form.commercial && form.modify) {
              rights += '(cc_noncommercial|cc_nonderived)';
            } else if (form.commercial) {
              rights += '(cc_noncommercial)';
            } else if (form.modify) {
              rights += '(cc_nonderived)';
            }
          break;

          case "googleimages":
            rights = '&as_rights=(cc_publicdomain|cc_attribute|cc_sharealike).-';
            if (form.commercial && form.modify) {
              rights += '(cc_noncommercial|cc_nonderived)';
            } else if (form.commercial) {
              rights += '(cc_noncommercial)';
            } else if (form.modify) {
              rights += '(cc_nonderived)';
            }
          break;

          case "jamendo":
            rights = '';
            if (form.commercial && form.modify) {
              rights += '-nc%20AND%20-nd';
            } else if (form.commercial) {
              rights += '-nc';
            } else if (form.modify) {
              rights += '-nd';
            }
          break;

          case "nappy":
            rights = '';
            if (form.commercial && form.modify) {
              rights += '';
            } else if (form.commercial) {
              rights += '';
            } else if (form.modify) {
              rights += '';
            }
          break;

          case "openclipart":
            rights = '';
            if (form.commercial && form.modify) {
              rights += '';
            } else if (form.commercial) {
              rights += '';
            } else if (form.modify) {
              rights += '';
            }
          break;

          case "opengameart":
            rights = '&sort_by=count&sort_order=DESC'; // Just standard OGA search filters
             if (form.commercial && form.modify) {
               rights += '&field_art_licenses_tid[]=2&field_art_licenses_tid[]=17981'  // Include CC BY (3.0 and 4.0) licenses
               + '&field_art_licenses_tid[]=17982&field_art_licenses_tid[]=3'  // Include CC BY-SA (3.0 and 4.0) licenses
               + '&field_art_licenses_tid[]=4'  // Include CC0 license
               
               // I don't sure about permissiveness of OGA BY (3.0 and 4.0) licenses,
               // so I decided to comment this line
               //+ '&field_art_licenses_tid[]=10310&field_art_licenses_tid[]=31772'
               ;
             } else if (form.commercial) {
               rights += '';
             } else if (form.modify) {
               rights += '';
             }
          break;
            
          case "openverse":
            rights = '&license_type=';
            if (form.commercial && form.modify) {
              rights +='commercial,modification';
            } else if (form.commercial) {
              rights +='commercial';
            } else if (form.modify) {
              rights += 'modification';
            }
          break;

          case "sketchfab":
            rights = '';
            if (form.commercial && form.modify) {
              rights += "&features=downloadable"
              + "&licenses=322a749bcfa841b29dff1e8a1bb74b0b" // Include CC BY license
              + "&licenses=b9ddc40b93e34cdca1fc152f39b9f375" // Include CC BY-SA license
              + "&licenses=7c23a1ba438d4306920229c12afcb5f9"; // Include CC0
              
            } else if (form.commercial) {
              rights += '';
            } else if (form.modify) {
              rights += '';
            }
          break;

          case "soundcloud":
            rights = '';
            if (form.commercial && form.modify) {
              rights += '&filter.license=to_modify_commercially';
            } else if (form.commercial) {
              rights += '&filter.license=to_use_commercially';
            } else if (form.modify) {
              rights += '&filter.license=to_share';
            }
          break;

          case "thingiverse":
          // currently defering to openverse since 
          // thingiverse filtering is broken
            rights = '&license_type=';
            if (form.commercial && form.modify) {
              rights += 'commercial,modification';
            } else if (form.commercial) {
              rights += '';
            } else if (form.modify) {
              rights += '';
            }
          break;

          case "vimeo":
            rights = '&license=';
            if (form.commercial && form.modify) {
              rights += 'by';
            } else if (form.commercial) {
              rights += '';
            } else if (form.modify) {
              rights += '';
            }
          break;

          case "wikipedia-commons":
            rights = '';
            if (form.commercial && form.modify) {
              rights += '';
            } else if (form.commercial) {
              rights += '';
            } else if (form.modify) {
              rights += '';
            }
          break;

          case "youtube":
            rights = '&sp=EgIwAQ%253D%253D';
            if (form.commercial && form.modify) {
              rights += '';
            } else if (form.commercial) {
              rights += '';
            } else if (form.modify) {
              rights += '';
            }
          break;

          // if you want to add a new engine logic,
          // you can work from this:

          // case "default":
          //   rights = '';
          //   if (form.commercial && form.modify) {
          //     rights += '';
          //   } else if (form.commercial) {
          //     rights += '';
          //   } else if (form.modify) {
          //     rights += '';
          //   }
          // break;
        }
      } else {
        rights = '';
      }
      return rights;
    }
});

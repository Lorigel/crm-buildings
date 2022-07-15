
require("./libs/jquery/jquery.min.js");
require("./libs/bootstrap/js/bootstrap.bundle.min.js");
require("./libs/metismenu/metisMenu.min.js");
require("./libs/simplebar/simplebar.min.js");
require("./libs/node-waves/waves.min.js");
require("./pages/dashboard.init.js");


const pages = {
    Register: () => import("./pages/Register"),
    Contract: () => import("./pages/Contract"),
    User: () => import("./pages/User"),
}

async function init() {
    document.addEventListener('DOMContentLoaded', async () => {
      const { pageName } = document.body.dataset;
      if (!pageName) {
        return;
      }
  
      const pageModule = pages[pageName];
      if (!pageModule) {
        return;
      }
      const { default: page } = await pageModule();
      page.init();
  });
    

   
}


init();

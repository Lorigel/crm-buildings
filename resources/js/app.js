
const pages = {
    Register: () => import("./pages/Register"),
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

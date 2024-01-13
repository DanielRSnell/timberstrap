import lcTreeStore from "../lcTreeStore.js";
import { createElementsList, getHtmlNodes } from "../utils/htmlNodes.js";
import { createFeatureButton } from "../utils/buttons.js";
import { getDiffPaths, isEmptyObject } from '../utils/diff.js'


const initWayfinder = () => document.addEventListener("DOMContentLoaded", () => {
    // create the button
    createFeatureButton();

    // We still want this console.log statement
    // eslint-disable-next-line no-undef
    console.log(`*** lc_editor_experimental_mode: ${lc_editor_experimental_mode}`);

    // eslint-disable-next-line no-unused-vars
    document.addEventListener('lcUpdatePreview', (event) => {
      console.log('evento update')
      // console.log(event);
      // console.log('selector');
    });

    document.addEventListener('lcDocAvailable', (e) => {
      const html = document.getElementById("editing-panel-content");
      const lcDoc = e.detail.doc;


      console.log('lcMainStore.doc')
      console.log(window.lcMainStore.doc)

      html.innerHTML = createElementsList(getHtmlNodes(lcDoc.getElementById('lc-main'))).outerHTML;

      // check for doc changes
      const elementToObserve = lcDoc.documentElement;

      const observer = new MutationObserver((mutations) => {
        mutations.forEach((mutation) => {
          console.log("Change detected:", mutation.type, mutation.target);

          const newDocObj = getHtmlNodes(lcDoc.getElementById('lc-main'));
          const oldDocObj = lcTreeStore.getoldTreeObj();
          const diffObj = getDiffPaths(oldDocObj, newDocObj);

          // DEBUG ONLY
          // console.log('diffObj', isEmptyObject(diffObj));
          // console.log('diffObj', diffObj);

          if (!isEmptyObject(diffObj)) {
            const html = document.getElementById("editing-panel-content");
            html.innerHTML = createElementsList(getHtmlNodes(lcDoc.getElementById('lc-main'))).outerHTML;
          }
        });
      });

      const config = { childList: true, subtree: true };
      observer.observe(elementToObserve, config);
    });
  });

  export default initWayfinder
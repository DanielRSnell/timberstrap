import { getElementByXpath } from "../utils/htmlNodes.js";

const openProperties = () => {
  // eslint-disable-next-line no-undef
  $('body').on('click', '.lc-editor-tree-element-open-properties', function (e) {
    e.preventDefault();
    const xpath = e.currentTarget.dataset.xpath;

    // eslint-disable-next-line no-undef 
    const selector = CSSelector(getElementByXpath(xpath));

    console.log('selector', selector)

    // if 'lc-block' is in the classes, then we can use the revealSidePanel function
    // eslint-disable-next-line no-undef 
    if (getElementByXpath(xpath).matches(lc_main_parts_selector)) {
      // eslint-disable-next-line no-undef 
      revealSidePanel("edit-properties", selector, 'Section');
      // eslint-disable-next-line no-undef 
    } else if (getElementByXpath(xpath).matches(lc_containers_selector)) {
      // console.log('lc-containers-selector')
      // eslint-disable-next-line no-undef 
      revealSidePanel("edit-properties", selector, 'Container');
      // eslint-disable-next-line no-undef 
    } else if (getElementByXpath(xpath).matches(lc_rows_selector)) {
      // console.log('lc-rows-selector')
      // eslint-disable-next-line no-undef 
      revealSidePanel("edit-properties", selector, 'Row');
      // eslint-disable-next-line no-undef 
    } else if (getElementByXpath(xpath).matches(lc_columns_selector)) {
      // console.log('lc-columns-selector')
      // eslint-disable-next-line no-undef 
      revealSidePanel("edit-properties", selector, 'Column');
      // eslint-disable-next-line no-undef 
    } else if (getElementByXpath(xpath).matches(lc_blocks_selector)) {
      // console.log('lc-blocks-selector')
      // eslint-disable-next-line no-undef 
      revealSidePanel("edit-properties", selector, 'Block');
    } else {
      // per ora se non e' uno dei casi conosciuti facciamo in modo che 
      // semplicemente si chiuda il side panel
      // eslint-disable-next-line no-undef 
      $(".close-sidepanel").click();
    }
  })
}

export default openProperties
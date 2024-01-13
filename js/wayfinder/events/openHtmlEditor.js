import { getElementByXpath } from "../utils/htmlNodes.js";

const openHtmlEditor = () => {
  // eslint-disable-next-line no-undef
  $('body').on('click', '.lc-editor-tree-element-code', function (e) {
    const xpath = e.currentTarget.dataset.xpath;

    // console.log('xpath', xpath)
    // console.log('el', getElementByXpath(xpath))
    // eslint-disable-next-line no-undef
    const selector = CSSelector(getElementByXpath(xpath));

    // eslint-disable-next-line no-undef
    $(".close-sidepanel").click();
    // eslint-disable-next-line no-undef
    $(".lc-editor-close").click();
    // eslint-disable-next-line no-undef
    $("body").addClass("lc-bottom-editor-is-shown");

    // eslint-disable-next-line no-undef
    $("#lc-html-editor-window").attr("selector", selector);
    // console.log("Open html editor for: " + selector);
    // FUnzione di matteo
    // eslint-disable-next-line no-undef 
    var html = getPageHTML(selector);
    // FUnzione di matteo
    // eslint-disable-next-line no-undef 
    set_html_editor(html);
    // eslint-disable-next-line no-undef 
    $("#lc-html-editor-window").removeClass("lc-opacity-light").fadeIn(100);
    
    // FUnzione di matteo
    // eslint-disable-next-line no-undef 
    lc_html_editor.focus();
    // eslint-disable-next-line no-undef 
    $("#html-tab").click();

  })

}

export default openHtmlEditor
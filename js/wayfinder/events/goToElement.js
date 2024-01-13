const goToElement = () => {
  // eslint-disable-next-line no-undef
  $('body').on('click', '.lc-editor-tree-element-goto', function (e) {
    const previewEle = document.getElementById('previewiframe');
    e.preventDefault();
    const xpath = e.currentTarget.dataset.xpath;
    // console.log(e.currentTarget)

    // FIXME: this is not working - the whole page is scrolling so we lost the plugin
    // navigation bar
    // previewFrame is the iframe where the page is loaded
    // try catch in case something goes wrong
    try {
      previewEle.contentDocument.animate({
        scrollTop: previewEle.contentDocument.evaluate(
          xpath,
          previewEle.contentDocument,
          null,
          XPathResult.FIRST_ORDERED_NODE_TYPE,
          null).singleNodeValue.scrollIntoView()
      });
    } catch (e) {
      // console.error(e)
    }
  })
}

export default goToElement
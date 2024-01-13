
class LcTreeStore {
  constructor(params) {
    // cosi creo un singleton
    if (LcTreeStore.instance) {
      return LcTreeStore.instance;
    }
    LcTreeStore.instance = this;


    this.treeHtml = params.treeHtml
    this.oldTreeObj = params.oldTreeObj
    this.popUpIsOpen = false
    this.winbox = null
  }

  setWinbox(wbInstance) {
    this.winbox = wbInstance;
    // emit event
    const event = new CustomEvent('lcSetWinbox', { detail: { wbInstance } });
    document.dispatchEvent(event);
  }

  getWinbox() {
    return this.winbox;
  }

  setPopUpIsOpen(newPopUpIsOpen) {
    this.popUpIsOpen = newPopUpIsOpen;
  }

  getPopUpIsOpen() {
    return this.popUpIsOpen;
  }

  setoldTreeObj(newoldTreeObj) {
    // console.log('setoldTreeObj', newoldTreeObj)
    this.oldTreeObj = newoldTreeObj;
  }

  getoldTreeObj() {
    return this.oldTreeObj;
  }

  setTreeHtml(newTreeHtml) {
    this.treeHtml = newTreeHtml;
  }

  getTreeHtml() {
    return this.treeHtml;
  }
}

const lcTreeStore = new LcTreeStore({
  treeHtml: null,
  oldTreeObj: {}
})

// supporto legacy a LC
window.lcTreeStore = lcTreeStore

export default lcTreeStore
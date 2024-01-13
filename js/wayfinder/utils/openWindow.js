
// import WinBox from "winbox"; non funziona da NPM
// import WinBox from "../../node_modules/winbox/src/js/winbox.js";
import WinBox from '../winbox/js/winbox.js'
import lcTreeStore from "../lcTreeStore.js";

export function openEditingWindow() {

  const theWayFinderWinBox = new WinBox({
    // configuration:
    index: 9999999,
    id: "editing-panel-window",
    root: document.body,
    __class: ["no-full", "no-max", "no-min"],

    // appearance:
    title: "WayFinder",
    border: 4,
    __header: 25,
    icon: false,

    // initial state:
    modal: false,
    max: false,
    min: false,
    hidden: false,
    autosize: false,

    background: "var(--color-interface-bg)",
    x: "right",
    top: "70px",

    // dimension:
    width: 400,
    height: 400,
    maxheight: 1200,
    minheight: 50,
    minwidth: 200,

    //contents
    // html: createElementsList(getHtmlNodes(doc.getElementById('lc-main'))).outerHTML,
    mount: document.getElementById("editing-panel-content")
  });

  theWayFinderWinBox.removeControl("wb-max").removeControl("wb-full");
  theWayFinderWinBox.addControl({
    index: 0,
    class: "wb-like",
    // image: "assets/caret-right-fill.svg",
    // eslint-disable-next-line no-unused-vars
    click: function (event, winbox) {
      // the winbox instance will be passed as 2nd parameter
      // console.log(winbox.id);
      // "this" refers to the button which was clicked:
      this.classList.toggle("active");
    }
  });

  // when the wayfinder popup is closed remove from state
  theWayFinderWinBox.onclose = function () {
    lcTreeStore.setWinbox(null)
  }

  // save the winbox in the store
  lcTreeStore.setWinbox(theWayFinderWinBox)

}
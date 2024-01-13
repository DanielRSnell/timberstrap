import collapseTree from "./events/collapseTree.js";
import goToElement from "./events/goToElement.js";
import openProperties from "./events/openProperties.js";
import openHtmlEditor from "./events/openHtmlEditor.js";
import initWayfinder from "./events/initWayfinder.js";


// ************************************************************* //
// ************************************************************* // 
// ***************  ICONS EVENTS LISTENERS ********************* // 
// ************************************************************* // 
// ************************************************************* //
initWayfinder()

console.log("/*")
console.log("********************************************************")
console.log("********************************************************")
console.log("********************************************************")
console.log("_    _  _____   _______ _____ _   _______ ___________ ")
console.log("| |  | |/ _ \\ \\ / /  ___|_   _| \\ | |  _  \\  ___| ___ \\")
console.log("| |  | / /_\\ \\ V /| |_    | | |  \\| | | | | |__ | |_/ /")
console.log("| |/\\| |  _  |\\ / |  _|   | | | . ` | | | |  __||    / ")
console.log("\\  /\\  / | | || | | |    _| |_| |\\  | |/ /| |___| |\\ \\ ")
console.log("\\/  \\/\\_| |_/\\_/ \\_|    \\___/\\_| \\_/___/ \\____/\\_| \\_|")
console.log("*********************************************************")
console.log("********************************************************* ")
console.log("*********************************************************")
console.log("*/")

// vai all'elemento cliccato
// eslint-disable-next-line no-undef
goToElement()
// Open properties
openProperties()
// Collapse or Close the tree view
collapseTree()
// Open the HTML editor
openHtmlEditor()
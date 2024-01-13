import lcTreeStore from "../lcTreeStore.js";
import LcHtmlElement from "../models/lcHtmlElement.js";
import { makeid, generateUniqueId } from './misc.js'



const classesToShow = [
  'container', 'row', 'col', 'lc-block', 'container',
  'col-1', 'col-2', 'col-3', 'col-4', 'col-5', 'col-6',
  'col-7', 'col-8', 'col-9', 'col-10', 'col-11', 'col-12',
  'col-sm-1', 'col-sm-2', 'col-sm-3', 'col-sm-4', 'col-sm-5',
  'col-sm-6', 'col-sm-7', 'col-sm-8', 'col-sm-9', 'col-sm-10',
  'col-sm-11', 'col-sm-12', 'col-md-1', 'col-md-2', 'col-md-3',
  'col-md-4', 'col-md-5', 'col-md-6', 'col-md-7', 'col-md-8',
  'col-md-9', 'col-md-10', 'col-md-11', 'col-md-12', 'col-lg-1',
  'col-lg-2', 'col-lg-3', 'col-lg-4', 'col-lg-5', 'col-lg-6',
  'col-lg-7', 'col-lg-8', 'col-lg-9', 'col-lg-10', 'col-lg-11',
  'col-lg-12', 'col-xl-1', 'col-xl-2', 'col-xl-3', 'col-xl-4',
  'col-xl-5', 'col-xl-6', 'col-xl-7', 'col-xl-8', 'col-xl-9',
  'col-xl-10', 'col-xl-11', 'col-xl-12', 'col-xxl-1', 'col-xxl-2',
  'col-xxl-3', 'col-xxl-4', 'col-xxl-5', 'col-xxl-6', 'col-xxl-7',
  'col-xxl-8', 'col-xxl-9', 'col-xxl-10', 'col-xxl-11', 'col-xxl-12',
  'col-xxl-auto', 'col-xl-auto', 'col-lg-auto', 'col-md-auto',
]


export function createElementsList(htmlNodes) {

  // freeze the last object tree value used
  lcTreeStore.setoldTreeObj(htmlNodes)

  const list = new LcHtmlElement('ul', {
    classList: ['p-list-tree'],
    id: 'lc-editor-tree-id',
  }).create().getElement()



  const createListItem = (node) => {
    const listItem = document.createElement('li');
    listItem.classList.add('list__wayfinder__el')
    listItem.classList.add('p-list-tree__item')

    // create carret icon
    const carret = document.createElement('icon')
    carret.classList.add('lc-editor-tree-carret')
    carret.classList.add('lc-editor-tree-element-note')
    carret.classList.add('mdi')

    if (node.children && node.children.length > 0) {
      carret.classList.add('mdi-menu-right')
    } else {
      carret.classList.add('mdi-square-medium')
    }




    listItem.id = makeid(12)
    listItem.classList.add('notopen')
    listItem.classList.add('lc-editor-tree-li-node')
    listItem.classList.add('draggable')
    listItem.draggable = true
    const label = document.createElement('a');

    label.innerText = node.tagName + (node.id ? `#${node.id}` : '') + (node.name ? `[name="${node.name}"]` : '') + (node.classList ? `.${node.classList.filter((classe) => classesToShow.includes(classe)).join('.')}` : '');
    // label.dataset.xpath = node.xpath;
    // label.dataset.classes = node.classList;
    // label.id = node.xpath;
    label.classList.add('lc-editor-tree-element-note');

    const ancor = document.createElement('a')
    ancor.classList.add('lc-editor-tree-element-open-properties')
    ancor.classList.add('lc-tree-utility')
    // ancor.classList.add('d-none')
    ancor.dataset.xpath = node.xpath
    const iconOne = document.createElement('span')
    iconOne.classList.add('mdi')
    iconOne.classList.add('mdi-cog-outline')
    ancor.appendChild(iconOne)

    const ancorTwo = document.createElement('a')
    ancorTwo.classList.add('lc-editor-tree-element-code')
    ancorTwo.classList.add('lc-tree-utility')
    // ancorTwo.classList.add('d-none')
    ancorTwo.dataset.xpath = node.xpath
    const iconTwo = document.createElement('span')
    iconTwo.classList.add('mdi')
    iconTwo.classList.add('mdi-xml')
    ancorTwo.appendChild(iconTwo)


    const ancorThree = document.createElement('a')
    ancorThree.classList.add('lc-editor-tree-element-goto')
    ancorThree.classList.add('lc-tree-utility')
    // ancorThree.classList.add('d-none')
    ancorThree.dataset.xpath = node.xpath
    const iconThree = document.createElement('span')
    iconThree.classList.add('mdi')
    iconThree.classList.add('mdi-eye')
    ancorThree.appendChild(iconThree)

    listItem.appendChild(carret)
    listItem.appendChild(label);
    listItem.appendChild(ancor)
    listItem.appendChild(ancorThree)
    listItem.appendChild(ancorTwo)



    if (node.children && node.children.length > 0) {
      const childrenList = document.createElement('ul');
      childrenList.id = generateUniqueId()
      childrenList.classList.add('p-list-tree')
      childrenList.classList.add('sublist__ul')
      childrenList.classList.add('list__wayfinder__el')

      // childrenList.style.display = 'none'
      childrenList.classList.add('d-none')


      for (const childNode of node.children) {
        const childListItem = createListItem(childNode);
        childrenList.appendChild(childListItem);
      }
      listItem.appendChild(childrenList);
    }
    return listItem;
  };
  if (htmlNodes.children && htmlNodes.children.length > 0) {
    for (const node of htmlNodes.children) {
      const listItem = createListItem(node);
      list.appendChild(listItem);
    }
  }
  return list;
}


export function getHtmlNodes(element) {
  if (!element) {
    return null;
  }
  const nodes = {};
  nodes.tagName = element.tagName.toLowerCase();
  nodes.xpath = getXPath(element);
  if (element.id) {
    nodes.id = element.id;
  }
  if (element.classList.length > 0) {
    nodes.classList = Array.from(element.classList);
  }
  if (element.getAttribute('name')) {
    nodes.name = element.getAttribute('name');
  }
  if (element.children.length > 0) {
    nodes.children = [];
    for (let i = 0; i < element.children.length; i++) {
      nodes.children.push(getHtmlNodes(element.children[i]));
    }
  }
  return nodes;
}


export function getElementByXpath(path) {
  var doc = window.lcMainStore.getDoc()
  return doc.evaluate(path, doc, null, XPathResult.FIRST_ORDERED_NODE_TYPE, null).singleNodeValue;
}

export function getXPath(node) {
  // node doesn't exist the xpath is empty
  if (!node) {
    return '';
  }

  // we don't care to have #document[0] in the path so just use
  // a slash
  if (node.nodeType === Node.DOCUMENT_NODE) {
    return "/";
  }

  if (node.nodeType === Node.ATTRIBUTE_NODE) {
    return getXPath(node.ownerElement) + "/@" + node.nodeName;
  }
  if (node.nodeType === Node.TEXT_NODE) {
    return getXPath(node.parentNode) + "/text()";
  }
  let index = 1;
  let sibling = node.previousSibling;
  while (sibling) {
    if (sibling.nodeType === node.nodeType && sibling.nodeName === node.nodeName) {
      index++;
    }
    sibling = sibling.previousSibling;
  }
  // for arrays
  let xpath = node.nodeName.toLowerCase() + "[" + index + "]";
  return getXPath(node.parentNode) + "/" + xpath;
}

export function CSSelector(el) {
  var names = [];
  while (el.parentNode) {
    if (el.nodeName == "MAIN" && el.id == "lc-main") {
      names.unshift(el.nodeName + '#' + el.id);
      break;
    } else {
      if (el === el.ownerDocument.documentElement || el === el.ownerDocument.body) {
        names.unshift(el.tagName);
      } else {
        for (var c = 1, e = el; e.previousElementSibling; e = e.previousElementSibling, c++) { /* empty */ }
        names.unshift(el.tagName + ':nth-child(' + c + ')');
      }
      el = el.parentNode;
    }
  }
  return names.join(' > ');
}
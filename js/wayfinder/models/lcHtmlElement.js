export default class LcHtmlElement {
  constructor(tagName, attr = {}) {
    this.tagName = tagName || 'div';
    this.classList = attr.classList || [];
    this.id = attr.id || '';
    this.style = attr.style || {};
    this.innerText = attr.innerText || '';
    this.element = null;
  }

  // Create the actual HTML element
  create() {
    this.element = document.createElement(this.tagName);
    this._applyClasses();
    this._applyId();
    this._applyStyles();
    this._applyInnerText();

    // return this allows for method chaining
    return this;
  }

  // Return the actual DOM element
  getElement() {
    return this.element;
  }

  getRawHtml() {
    return this.element ? this.element.outerHTML : '';
  }

  // Private method to apply classes to the element
  _applyClasses() {
    if (this.classList.length) {
      this.classList.forEach(c => this.element.classList.add(c));
    }
  }

  // Private method to apply ID to the element
  _applyId() {
    if (this.id) {
      this.element.id = this.id;
    }
  }

  // Private method to apply styles to the element
  _applyStyles() {
    for (let prop in this.style) {
      this.element.style[prop] = this.style[prop];
    }
  }

  // Private method to apply inner text to the element
  _applyInnerText() {
    if (this.innerText) {
      this.element.innerText = this.innerText;
    }
  }
}

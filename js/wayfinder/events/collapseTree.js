const collapseTree = () => {
  // eslint-disable-next-line no-undef 
  $('body').on('click', '.lc-editor-tree-element-note', function (e) {
    // prendi il parent
    const parent = e.currentTarget.parentNode
    const childrenUl = Array.from(parent.children).filter(child => child.tagName === 'UL');
    // apri i children
    for (const child of childrenUl) {
      if (child.classList.contains('d-none')) {
        child.classList.remove('d-none')
        parent.classList.remove('notopen')
        // parent.getElementsByClassName('lc-editor-tree-carret')[0].classList.remove('mdi-menu-right')
        // get icon tag from children
        Array.from(parent.children).forEach(child => {
          if (child.tagName === 'ICON') {
            child.classList.remove('mdi-menu-right')
            child.classList.add('mdi-menu-down')
          }
        })
        // ).classList.remove('mdi-menu-down')
      } else {
        parent.classList.add('notopen')
        child.classList.add('d-none')
        Array.from(parent.children).forEach(child => {
          if (child.tagName === 'ICON') {
            child.classList.add('mdi-menu-right')
            child.classList.remove('mdi-menu-down')
          }
        })
      }
    }
  })
}

export default collapseTree
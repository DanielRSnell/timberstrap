import lcTreeStore from "../lcTreeStore.js"
import { openEditingWindow } from "./openWindow.js"


export function createFeatureButton() {
  const menu = document.getElementById('extras-submenu')

  const menuItem = document.createElement('a')
  menuItem.classList.add('open-main-wayfinder')

  menuItem.innerHTML = `<i class="fa fa-search"></i> Open Wayfinder`
  // menu.appendChild(menuItem)
  menu.appendChild(menuItem)

  menuItem.addEventListener('click', function () {
    // aprilo solo se gia aperto
    if (lcTreeStore.getWinbox() == null) {
      openEditingWindow();
    } else {
      // console.log('wayfinder already open')
    }
  })
}

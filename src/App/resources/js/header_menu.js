
// タブに対してクリックイベントを適用
const menus = document.getElementsByClassName('nav-menu');
for (let i = 0; i < menus.length; i++) {
  menus[i].onmouseenter = openNavMenu;
  menus[i].onmouseleave = closeNavMenu;
}

// タブをクリックすると実行する関数
function openNavMenu() {
  console.log('open');
  // 引数で指定したセレクターと一致する直近の祖先要素を取得
  const ancestorEle = this.closest('.menu-group');
  // タブのclassの値を変更
  this.classList.add('is-active');
  // コンテンツのclassの値を変更
  const groupMenus = ancestorEle.getElementsByClassName('nav-menu');
  const arrayTabs = Array.prototype.slice.call(groupMenus);
  const index = arrayTabs.indexOf(this);
  ancestorEle.getElementsByClassName('drop-down')[index].classList.add('is-show');
};

// タブをクリックすると実行する関数
function closeNavMenu() {
  console.log('close');
  // 引数で指定したセレクターと一致する直近の祖先要素を取得
  const ancestorEle = this.closest('.menu-group');
  // タブのclassの値を変更
  ancestorEle.getElementsByClassName('is-active')[0].classList.remove('is-active');
  // コンテンツのclassの値を変更
  ancestorEle.getElementsByClassName('is-show')[0].classList.remove('is-show');
};

// document.addEventListener('DOMContentLoaded', function () {

// });

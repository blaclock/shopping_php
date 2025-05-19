
// タブに対してクリックイベントを適用
const menus = document.getElementsByClassName('nav-menu');
for (let i = 0; i < menus.length; i++) {
  menus[i].onmouseenter = openNavMenu;
  menus[i].onmouseleave = closeNavMenu;
}

// メニューをホバーした時の処理
function openNavMenu() {
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

// メニューから離れた時の処理
function closeNavMenu() {
  // 引数で指定したセレクターと一致する直近の祖先要素を取得
  const ancestorEle = this.closest('.menu-group');
  // タブのclassの値を変更
  ancestorEle.getElementsByClassName('is-active')[0].classList.remove('is-active');
  // コンテンツのclassの値を変更
  ancestorEle.getElementsByClassName('is-show')[0].classList.remove('is-show');
};


// カスタマー画面のスマホでヘッダーの検索ボタンが押された場合
const searchBtn = document.getElementById('searchBtn');
searchBtn.addEventListener('click', openModal);

function openModal() {
  const modalWindow = document.getElementsByClassName('modal')[0];
  modalWindow.classList.remove('hidden');
  modalWindow.classList.add('block');
}

const closeBtn = document.getElementById('closeBtn');
closeBtn.addEventListener('click', closeModal);

function closeModal() {
  const modalWindow = document.getElementsByClassName('modal')[0];
  modalWindow.classList.remove('block');
  modalWindow.classList.add('hidden');
}

// // 管理者画面のスマホでヘッダーのメニューボタンが押された場合
// const openMenuBtn = document.getElementById('openMenuBtn');
// openMenuBtn.addEventListener('click', openHeaderMenu);

// function openHeaderMenu() {
//   const modalWindow = document.getElementsByClassName('modal')[0];
//   modalWindow.classList.remove('hidden');
//   modalWindow.classList.add('flex');
// }

// const closeMenuBtn = document.getElementById('closeMenuBtn');
// closeMenuBtn.addEventListener('click', closeHeaderMenu);

// function closeHeaderMenu() {
//   const modalWindow = document.getElementsByClassName('modal')[0];
//   modalWindow.classList.remove('flex');
//   modalWindow.classList.add('hidden');
// }

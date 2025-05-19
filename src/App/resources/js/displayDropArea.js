
// タブに対してクリックイベントを適用
let filter = document.getElementsByClassName('filter');
filter = Array.from(filter);
filter.forEach(element => {
  element.onmouseleave = closeSortMenu;
  element.onclick = clickSortMenu;
});

// ドロップエリアから離れると実行する関数
function closeSortMenu() {
  const dropArea = this.getElementsByClassName('dropArea');
  dropArea[0].classList.add('hidden');
  dropArea[0].classList.remove('flex');
};

// タブをクリックすると実行する関数
function clickSortMenu() {
  const dropArea = this.getElementsByClassName('dropArea');
  if (dropArea[0].classList.contains('hidden')) {
    dropArea[0].classList.add('flex');
    dropArea[0].classList.remove('hidden');
  }
};

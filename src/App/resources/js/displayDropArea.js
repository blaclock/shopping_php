
// タブに対してクリックイベントを適用
let filter = document.getElementsByClassName('filter');
filter = Array.from(filter);
filter.forEach(element => {
  element.onmouseenter = openSortMenu;
  element.onmouseleave = closeSortMenu;
});

// タブをクリックすると実行する関数
function openSortMenu() {
  const dropArea = this.getElementsByClassName('dropArea');
  dropArea[0].style.display = 'flex';
};

// タブをクリックすると実行する関数
function closeSortMenu() {
  const dropArea = this.getElementsByClassName('dropArea');
  dropArea[0].style.display = 'none';
};

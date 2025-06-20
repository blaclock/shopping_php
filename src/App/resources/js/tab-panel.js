
// タブに対してクリックイベントを適用
let tabs = document.getElementsByClassName('tab');
tabs = Array.from(tabs);
tabs.forEach(element => {
  element.addEventListener('click', tabSwitch);
});

// タブをクリックすると実行する関数
function tabSwitch() {
  // 引数で指定したセレクターと一致する直近の祖先要素を取得
  const ancestorEle = this.closest('.tab-panel');
  // タブのclassの値を変更
  ancestorEle.getElementsByClassName('is-active')[0].classList.remove('is-active');
  this.classList.add('is-active');
  // コンテンツのclassの値を変更
  ancestorEle.getElementsByClassName('is-show')[0].classList.remove('is-show');
  const groupTabs = ancestorEle.getElementsByClassName('tab');
  const arrayTabs = Array.prototype.slice.call(groupTabs);
  const index = arrayTabs.indexOf(this);
  ancestorEle.getElementsByClassName('panel')[index].classList.add('is-show');
};

// document.addEventListener('DOMContentLoaded', function () {
//   // タブに対してクリックイベントを適用
//   const tabs = document.getElementsByClassName('tab');
//   for (let i = 0; i < tabs.length; i++) {
//     tabs[i].addEventListener('click', tabSwitch);
//   }

//   // タブをクリックすると実行する関数
//   function tabSwitch() {
//     // 引数で指定したセレクターと一致する直近の祖先要素を取得
//     const ancestorEle = this.closest('.tab-panel');
//     // タブのclassの値を変更
//     ancestorEle.getElementsByClassName('is-active')[0].classList.remove('is-active');
//     this.classList.add('is-active');
//     // コンテンツのclassの値を変更
//     ancestorEle.getElementsByClassName('is-show')[0].classList.remove('is-show');
//     const groupTabs = ancestorEle.getElementsByClassName('tab');
//     const arrayTabs = Array.prototype.slice.call(groupTabs);
//     const index = arrayTabs.indexOf(this);
//     ancestorEle.getElementsByClassName('panel')[index].classList.add('is-show');
//   };
// });

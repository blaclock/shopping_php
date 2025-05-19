// タブに対してクリックイベントを適用
let scores = document.getElementsByClassName('score');
scores = Array.from(scores);
scores.forEach(element => {
  element.addEventListener('click', scoreSwitch);
});

// タブをクリックすると実行する関数
function scoreSwitch() {
  this.style.background = "orange";

  let el = this.parentNode.previousElementSibling;

  // クリックされた星より前の星の色を変える
  while (el) {
    el.children[0].style.background = 'orange';
    el = el.previousElementSibling;
  };

  el = this.parentNode.nextElementSibling;
  // クリックされた星より後ろの星の色を変える
  while (el) {
    el.children[0].style.background = 'rgb(75, 85, 99)';
    el = el.nextElementSibling;
  };

}

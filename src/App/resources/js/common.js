// トップへ戻るボタン
const toTopBtn = document.getElementById('toTopBtn');
toTopBtn.addEventListener('click', toTopScroll);

function toTopScroll() {
  window.scroll({ top: 0, behavior: "smooth" });
}

// スクロールされたら表示
window.addEventListener("scroll", scroll_event);
function scroll_event() {
  if (window.pageYOffset > 100) {
    toTopBtn.style.opacity = "1";
  } else if (window.pageYOffset < 100) {
    toTopBtn.style.opacity = "0";
  }
}

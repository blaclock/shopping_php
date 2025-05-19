// タブに対してクリックイベントを適用
let quantities = document.getElementsByClassName('quantity');
quantities = Array.from(quantities);
quantities.forEach(element => {
  element.addEventListener('change', updateQuantity);
});

// タブをクリックすると実行する関数
function updateQuantity() {
  cart_id = this.closest('.cart-info').nextElementSibling.value;
  // 削除の場合
  if (this.value == 0) {
    window.location.href = "http://localhost:50080/cart/delete?cart_id=" + cart_id;
  } else {
    // カートの商品の数量を変更する場合
    window.location.href = "http://localhost:50080/cart/update?cart_id=" + cart_id + "&quantity=" + this.value;
  }
}

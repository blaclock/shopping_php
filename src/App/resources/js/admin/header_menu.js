// 管理者画面のスマホでヘッダーのメニューボタンが押された場合
const openMenuBtn = document.getElementById('openMenuBtn');
openMenuBtn.addEventListener('click', openHeaderMenu);

function openHeaderMenu() {
  const modalWindow = document.getElementsByClassName('sidebar')[0];
  modalWindow.classList.remove('hidden');
  modalWindow.classList.add('flex');
}

const closeMenuBtn = document.getElementById('closeMenuBtn');
closeMenuBtn.addEventListener('click', closeHeaderMenu);

function closeHeaderMenu() {
  const modalWindow = document.getElementsByClassName('sidebar')[0];
  modalWindow.classList.remove('flex');
  modalWindow.classList.add('hidden');
}

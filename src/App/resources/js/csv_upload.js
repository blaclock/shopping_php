var dropZone = document.getElementById('drop-zone');
var preview = document.getElementById('file-name');
var fileInput = document.getElementById('csv');

dropZone.addEventListener('dragover', function (e) {
  e.stopPropagation();
  e.preventDefault();
  this.style.background = '#e1e7f0';
}, false);

dropZone.addEventListener('dragleave', function (e) {
  e.stopPropagation();
  e.preventDefault();
  this.style.background = '#ffffff';
}, false);

fileInput.addEventListener('change', function () {
  previewFile(this.files[0]);
});

dropZone.addEventListener('drop', function (e) {
  e.stopPropagation();
  e.preventDefault();
  this.style.background = '#ffffff'; //背景色を白に戻す
  var files = e.dataTransfer.files; //ドロップしたファイルを取得
  if (files.length > 1) return alert('アップロードできるファイルは1つだけです。');
  fileInput.files = files; //inputのvalueをドラッグしたファイルに置き換える。
  previewFile(files[0]);
}, false);

function previewFile(file) {
  /* FileReaderで読み込み、プレビュー画像を表示。 */
  var fileName = document.createElement('span');
  preview.innerHTML = file.name;
  fileInput = file;
  preview.appendChild(fileName);
}

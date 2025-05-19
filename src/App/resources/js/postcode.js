const postcodeBtn = document.getElementById('postcodeBtn');
postcodeBtn.addEventListener('click', searchAddress);

function searchAddress() {
  var xhr = new XMLHttpRequest();
  postcode = document.getElementById('zip').value;
  console.log(postcode);

  if (postcode.match(/[0-9]{3}\-[0-9]{4}/) === null) {
    alert('正確な郵便番号を入力してください。');
    return false; //ページ遷移をしない	
  } else {
    xhr.open('GET', '/postcode?zip=' + postcode);
    xhr.send();
    xhr.onreadystatechange = function () {
      // if (xhr.readyState === 4 && xhr.status === 200) {  //データ取得後の処理内容 
      if (xhr.readyState === 4 && xhr.status === 200) {  //データ取得後の処理内容 
        data = xhr.responseText;
        if (data == '') {
          alert('該当する郵便番号はありません');
        } else {
          document.getElementById('address').value = data;
        }
      }
    }
  }
}

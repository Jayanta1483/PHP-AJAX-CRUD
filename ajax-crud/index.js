
function displayRecords(url, element){
fetch(url).then(response => response.text().then(text => element.innerHTML += text ));
}

let displayUrl = 'backend.php';
let table = document.getElementById("myTable");

displayRecords(displayUrl, table);

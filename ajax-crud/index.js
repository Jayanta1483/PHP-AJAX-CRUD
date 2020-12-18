function displayRecords(url, element, option) {

    fetch(url, option).then(response => response.text().then(text => element.innerHTML = text));
}

let displayUrl = 'backend.php';
let table = document.getElementById("tBody");

displayRecords(displayUrl, table);


function deleteRecord(id) {
    let cnfrm = confirm("Are You Sure?");
    if (cnfrm) {
        let delData = new URLSearchParams();
        delData.append("operation", "delete");
        delData.append("id", id);
        const delOption = {
            method: "POST",
            body: delData
        };
        fetch(displayUrl, delOption).then(() => displayRecords(displayUrl, table))
    }
}



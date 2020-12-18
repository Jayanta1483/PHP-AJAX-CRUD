function displayRecords(url, element, option) {

    fetch(url, option).then(response => response.text().then(text => element.innerHTML = text));
}

let url = 'backend.php';
let table = document.getElementById("tBody");
let showData = new URLSearchParams();
showData.append("operation", "display")
const displayOption = {
    method: "POST",
    body: showData
}

displayRecords(url, table, displayOption);


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
        fetch(url, delOption).then(() => displayRecords(url, table, displayOption))
    }
}

let submit = document.getElementById("submit");
let fname = document.getElementById("fname");
let lname = document.getElementById("lname");
let email = document.getElementById("email");
let city = document.getElementById("city");

submit.addEventListener("click", () => {

    let insertData = new URLSearchParams();
    insertData.append("operation", "insert");
    insertData.append("fname", fname.value);
    insertData.append("lname", lname.value);
    insertData.append("email", email.value);
    insertData.append("city", city.value);


    const insertOption = {
        method: "POST",
        body: insertData
    };
    fetch(url, insertOption).then(() => displayRecords(url, table, displayOption))
    fname.value = lname.value = email.value = city.value = "";
})


let myForm = document.getElementById("myForm");

function showRecord(id) {
    let profileData = new URLSearchParams();
    profileData.append("operation", "profile");
    profileData.append("id", id)

    let profileOption = {
        method: "POST",
        body: profileData
    }

    displayRecords(url, myForm, profileOption)
}

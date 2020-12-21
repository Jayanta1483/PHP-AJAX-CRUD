function displayRecords(url, element, option) {
     
    fetch(url, option).then(response => response.text().then(text => element.innerHTML = text));
}

let url = 'backend.php';
let table = document.getElementById("tBody");


let showData = new URLSearchParams();
showData.append("operation", "display");
const displayOption = {
    method: "POST",
    body: showData
}

displayRecords(url, table, displayOption);

let pageData = new URLSearchParams();
pageData.append("operation", "pagination");
const pageOption = {
    method:"POST",
    body:pageData
}

let pageNum;
fetch(url, pageOption).then(response => response.text().then(text =>{
    pageNum = Number(text) / 4;
    
}))

const pagi = document.getElementById("pagination");
console.log(pageNum)

for(let i = 1; i <= pageNum; i++){
    pagi.innerHTML = console.log(i)//'<button class="page" value="'+i+'">'+i+'</button>');
    
}

const pagination = document.querySelectorAll(" .page");
console.log(pagination)

pagination.forEach(element => element.onclick = (e) => {

    console.log(e.target.value)
    let showData = new URLSearchParams();
    showData.append("operation", "display");
    showData.append("page", e.target.value)

    const displayPageOption = {
        method: "POST",
        body: showData
    }
    displayRecords(url, table, displayPageOption);
})



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
let fn = document.getElementById("fn");
let ln = document.getElementById("ln");
let em = document.getElementById("em");
let ct = document.getElementById("ct");

const updateBtn = document.getElementById("subEdit");
let btnValue = updateBtn.value;

function showRecord(id) {
    let profileData = new URLSearchParams();
    profileData.append("operation", "profile");
    profileData.append("id", id)

    let profileOption = {
        method: "POST",
        body: profileData
    }

    fetch(url, profileOption).then(response => response.json()).then(json => {
        console.log(json)
        btnValue = json.id;
        fn.value = json.fname;
        ln.value = json.lname;
        em.value = json.email;
        ct.value = json.city;
    })
}





updateBtn.addEventListener("click", updateRecord)

function updateRecord() {

    let updateData = new URLSearchParams();
    updateData.append("operation", "update");
    updateData.append("id", btnValue);
    updateData.append("fn", fn.value);
    updateData.append("ln", ln.value);
    updateData.append("em", em.value);
    updateData.append("ct", ct.value);

    console.log(btnValue, fn.value);
    let updateOption = {
        method: "POST",
        body: updateData
    }

    fetch(url, updateOption).then(() => displayRecords(url, table, displayOption));
}












//FOR PRELOADING

let preloader = document.getElementById("loader");
let body = document.getElementById("page-top");
body.onload = () => preloader.style.display = "none";
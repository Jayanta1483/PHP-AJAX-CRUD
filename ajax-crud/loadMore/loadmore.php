<?php
require "connection.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <!-- <script src="index.js" defer></script> -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<body>
    <div class="container mr-auto mt-4">
        <div class="card shadow mb-4 mt-4">
            <div class="card-body">
                <div class="table-responsive" id="dataTable">
                    <table class="table table-bordered" id="myTable">
                        <thead class="text-center  bg-info text-white" >
                            <tr>
                                <th>#</th>
                                <th>FIRST NAME</th>
                                <th>LAST NAME</th>
                                <th>EMAIL ID</th>
                                <th>CITY</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>









    <script>
        const myTable = document.getElementById("myTable");
        fetch("backend2.php").then(response => response.text().then(text => myTable.innerHTML += text));
        
        function loadMore(id) {
            const url = 'backend2.php';
            const param = new URLSearchParams();
            param.append("lastId", id);
            let option = {
                method: "POST",
                body: param
            }
            fetch(url, option).then(response => response.text().then(text => {
                const pagination = document.getElementById("pagination");
                const loadBtn = document.getElementById("loadBtn");
                if(text){
                    pagination.remove();
                    myTable.innerHTML += text;
                }else{
                    loadBtn.classList.add("disabled")
                    loadBtn.innerText = "FINISHED"
                }
                   

                }

            ));
        }
    </script>
</body>

</html>
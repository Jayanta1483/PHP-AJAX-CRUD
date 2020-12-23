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
                <div class="table-responsive">
                    <table class="table table-bordered" id="myTable">
                        <thead class="text-center  bg-info text-white">
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
        $(document).ready(function(){
            $.ajax({
                  type:"POST",
                  url:"backend2.php",
                  success:(response)=>{
                      $("#myTable").html(response)
                  }
              })
          function loadMore(lastId){
              let data = `lastId:${lastId}`;
              $.ajax({
                  type:"POST",
                  url:"backend2.php",
                  data:data,
                  success:(response)=>{
                      console.log(response)
                  }
              })
          }
        })
    </script>
</body>

</html>
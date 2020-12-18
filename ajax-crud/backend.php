<?php
require "connection.php";

$select = "SELECT `stu_id`, `firstname`, `lastname`, `email`, `city` FROM `students`";
$result = $connect->query($select);

if ($result->num_rows > 0){
    $index = 1;
    while($row = $result->fetch_assoc()){
     echo   '<tbody>
            <tr class="text-center">
               <td>'.htmlspecialchars($index).'</td>
               <td>'.htmlspecialchars($row["firstname"]).'</td>
               <td>'.htmlspecialchars($row["lastname"]).'</td>
               <td>'.htmlspecialchars($row["email"]).'</td>
               <td>'.htmlspecialchars($row["city"]).'</td>
               <td><span style="color:green;"><i class="fas fa-edit"></i></span></td>
               <td><button style="border:none;background:rgba(0,0,0,0);" onclick="deleteRecord("'.htmlspecialchars($row["stu_id"]).'")"><span style="color:red;"><i class="fas fa-trash"></i></span></button></td>
            </tr>
            </tbody>';

            $index++;
    }
}


//extract($_POST);

if(isset($_POST["operation"]) && $_POST["operation"]!==""){
    $operation = mysqli_real_escape_string($connect, $_POST["operation"]);
    $id = mysqli_real_escape_string($connect, $_POST["id"]);

    if($operation === "delete"){
        $delete = "DELETE FROM `students` WHERE stu_id = ?";
        $stmt = $connect->prepare($delete);
        $stmt->bind_param("i",$id);
        $stmt->execute();

    }
}


?>
<?php
require "connection.php";

$select = "SELECT `stu_id`, `firstname`, `lastname`, `email`, `city` FROM `students`";
$result = $connect->query($select);

if ($result->num_rows > 0){
    $index = 1;
    while($row = $result->fetch_assoc()){
     echo   '<tbody>
            <tr class="text-center">
               <td>'.$index.'</td>
               <td>'.$row["firstname"].'</td>
               <td>'.$row["lastname"].'</td>
               <td>'.$row["email"].'</td>
               <td>'.$row["city"].'</td>
            </tr>
            </tbody>';

            $index++;
    }
}

?>
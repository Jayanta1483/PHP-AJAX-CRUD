<?php
require "connection.php";

if (isset($_POST["lastId"]) && $_POST["lastId"] !== "") {
    $offset = $_POST["lastId"];
} else {
    $offset = 0;
}

$limit = 4;

$select = "SELECT * FROM `students` ORDER BY `firstname` LIMIT $offset,$limit";
$result = $connect->query($select);
$output = "";
if (!empty($result) && $result->num_rows > 0) {
    $index = 1;
    while ($row = $result->fetch_assoc()) {

        $output .= '<tbody class="text-primary">
                     <tr class="text-center">
                         <td>' . $index . '</td>
                         <td>' . htmlspecialchars(ucwords($row["firstname"])) . '</td>
                         <td>' . htmlspecialchars(ucwords($row["lastname"])) . '</td>
                         <td>' . $row["email"] . '</td>
                         <td>' . htmlspecialchars(ucwords($row["city"])) . '</td>
                      </tr>
                 </tbody>
                 ';

        $index++;
    }
    $output .= '<div class="text-center"><button class="btn btn-info text-white" onclick="loadMore()">LOAD MORE</button></div>';
echo $output;



} else {


}

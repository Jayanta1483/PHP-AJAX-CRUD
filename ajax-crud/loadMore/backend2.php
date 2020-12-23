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
$last_id = $offset + $limit;
if (!empty($result) && $result->num_rows > 0) {
    $index = $last_id - 3;
    $output .= '
                <tbody class="text-primary">';

    while ($row = $result->fetch_assoc()) {

        $output .= '
                     <tr class="text-center">
                         <td>' . $index . '</td>
                         <td>' . htmlspecialchars(ucwords($row["firstname"])) . '</td>
                         <td>' . htmlspecialchars(ucwords($row["lastname"])) . '</td>
                         <td>' . $row["email"] . '</td>
                         <td>' . htmlspecialchars(ucwords($row["city"])) . '</td>
                      </tr>
                 
                 ';

        $index++;
    }
    $output .= '    </tbody>
    <tbody id="pagination">
    <tr class="text-center">
                        <td colspan="5"><button class="btn btn-info text-white" onclick="loadMore('.$last_id.')">LOAD MORE</button></td>
                    </tr></tbody>';

    echo $output;
} else {
}

<?php

require "connection.php";






if (isset($_POST["operation"]) && $_POST["operation"] !== "") {
    $operation = mysqli_real_escape_string($connect, $_POST["operation"]);

    // FOR DISPLAY RECORDS:

    if ($operation === "display") {

        if (isset($_POST["page"]) && $_POST["page"] !== "") {
            $page = mysqli_real_escape_string($connect, $_POST["page"]);
        } else {
            $page = 1;
        }

        $limit = 4;
        $offset = ($page - 1) * $limit;

        $select = "SELECT * FROM `students` ORDER BY `firstname` LIMIT $offset, $limit";
        $result = $connect->query($select);
        $output = "";

        if (!empty($result) && $result->num_rows > 0) {
            $index = $offset + 1;


            $output .= '<table class="table table-success table-striped table-hover" width="100%" cellspacing="0" id="myTable" style="color:black;">
                         <thead>
                         <tr class="text-center">
                         <th>#</th>
                         <th>FIRST NAME</th>
                         <th>LAST NAME</th>
                         <th>EMAIL</th>
                         <th>CITY</th>
                         <th>EDIT</th>
                         <th>DELETE</th>

                     </tr>

                 </thead>';

            while ($row = $result->fetch_assoc()) {
                $output .= '<tbody>
                              <tr class="text-center">
                                  <td>' . htmlspecialchars($index) . '</td>
                                  <td>' . htmlspecialchars(ucwords($row["firstname"])) . '</td>
                                  <td>' . htmlspecialchars(ucwords($row["lastname"])) . '</td>
                                  <td>' . htmlspecialchars($row["email"]) . '</td>
                                  <td>' . htmlspecialchars(ucwords($row["city"])) . '</td>
                                  <td><button style="border:none;background:rgba(0,0,0,0);" onclick="showRecord(' . htmlspecialchars($row["stu_id"]) . ')" data-bs-toggle="modal" data-bs-target="#updateModal"><span style="color:green;"><i class="fas fa-edit"></i></span></button></td>
                                  <td><button style="border:none;background:rgba(0,0,0,0);" onclick="deleteRecord(' . htmlspecialchars($row["stu_id"]) . ')"><span style="color:red;"><i class="fas fa-trash"></i></span></button></td>
                             </tr>
                         </tbody>';

                $index++;
            }



            $sel = "select * from students";
            $res = $connect->query($sel);
            $total_records = $res->num_rows;
            $total_pages = ceil($total_records / $limit);
            $start = ($offset + 1);
            $end = ($offset + $limit);
            $remaining_records = ($total_records - $offset);
            if ($remaining_records >= 4) {
                $output .= ' 
                       </table>
                       <div id="pagination">
                       <span>Showing ' . $start . ' to ' . $end . ' out of ' . $total_records . ' entries</span>
                       <span style="float:right;">';
            } else if ($remaining_records < 4 && $remaining_records > 1) {

                $output .= ' 
                       </table>
                       <div id="pagination">
                       <span>Showing ' . $start . ' to ' . $total_records . ' out of ' . $total_records . ' entries</span>
                       <span style="float:right;">';
            } else {
                $output .= ' 
                       </table>
                       <div id="pagination">
                       <span>Showing ' . $start . ' out of ' . $total_records . ' entries</span>
                       <span style="float:right;">';
            }
            for ($i = 1; $i <= $total_pages; $i++) {
                if ($i == $page) {
                    $class = "active";
                } else {
                    $class = "";
                }
                $output .= '<button class="btn btn-success ' . $class . ' mr-1" onclick="displayRecords(' . $i . ')">' . $i . '</button>';
            }

            $output .= '</span>
                        </div>';

            echo $output;
        } else {
            echo '<h4 class="text-center text-danger">Sorry...No Data to Display !!</h4>';
            die();
        }
    }

    //FOR PAGINATION:

    if ($operation === "pagination") {
        $select = "SELECT * FROM `students`";
        $result = $connect->query($select);
        if (!empty($result) && $result->num_rows > 0) {
            echo $result->num_rows;
        }
    }


    //FOR DELETE RECORDS:

    if ($operation === "delete") {
        $id = mysqli_real_escape_string($connect, $_POST["id"]);
        $delete = "DELETE FROM `students` WHERE stu_id = ?";
        $stmt = $connect->prepare($delete);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
    }

    //FOR INSERT RECORDS:

    if ($operation === "insert") {
        $fname = mysqli_real_escape_string($connect, $_POST["fname"]);
        $lname = mysqli_real_escape_string($connect, $_POST["lname"]);
        $email = mysqli_real_escape_string($connect, $_POST["email"]);
        $city = mysqli_real_escape_string($connect, $_POST["city"]);

        $insert = "INSERT INTO `students`(`firstname`, `lastname`, `email`, `city`) VALUES (?,?,?,?)";
        $stmt = $connect->prepare($insert);
        $stmt->bind_param("ssss", $fname, $lname, $email, $city);
        $stmt->execute();
        $stmt->close();
    }

    //FOR DISPLAY PROFILE:

    if ($operation === "profile") {
        $profile_id = mysqli_real_escape_string($connect, $_POST["id"]);

        $sel = "SELECT `stu_id`, `firstname`, `lastname`, `email`, `city` FROM `students` WHERE `stu_id` = ?";
        $stmt = $connect->prepare($sel);
        $stmt->bind_param("i", $profile_id);
        $stmt->execute();
        $stmt->bind_result($stu_id, $fname, $lname, $email, $city);

        while ($stmt->fetch()) {
            $response = array("id" => $stu_id, "fname" => $fname, "lname" => $lname, "email" => $email, "city" => $city);
            $response = json_encode($response);
            echo $response;
        }
        $stmt->close();
    }

    //FOR UPDATE PROFILE:

    if ($operation === "update") {
        $fname = mysqli_real_escape_string($connect, $_POST["fn"]);
        $lname = mysqli_real_escape_string($connect, $_POST["ln"]);
        $email = mysqli_real_escape_string($connect, $_POST["em"]);
        $city = mysqli_real_escape_string($connect, $_POST["ct"]);
        $update_id = mysqli_real_escape_string($connect, $_POST["id"]);

        var_dump($fname);

        $update = "UPDATE `students` SET `firstname`=?,`lastname`=?,`email`=?,`city`=? WHERE `stu_id` = ?";
        $stmt = $connect->prepare($update);
        $stmt->bind_param("ssssi", $fname, $lname, $email, $city, $update_id);
        $stmt->execute();
        $stmt->close();
        echo "Updated Successfully !!";
    }
}


$connect->close();

<?php
require "connection.php";




//extract($_POST);

if (isset($_POST["operation"]) && $_POST["operation"] !== "") {
    $operation = mysqli_real_escape_string($connect, $_POST["operation"]);

    if ($operation === "display") {

        $select = "SELECT `stu_id`, `firstname`, `lastname`, `email`, `city` FROM `students`";
        $result = $connect->query($select);

        if ($result->num_rows > 0) {
            $index = 1;
            while ($row = $result->fetch_assoc()) {
                echo   '<tbody>
            <tr class="text-center">
               <td>' . htmlspecialchars($index) . '</td>
               <td>' . htmlspecialchars(ucwords($row["firstname"])) . '</td>
               <td>' . htmlspecialchars(ucwords($row["lastname"])) . '</td>
               <td>' . htmlspecialchars($row["email"]) . '</td>
               <td>' . htmlspecialchars(ucwords($row["city"])) . '</td>
               <td><button style="border:none;background:rgba(0,0,0,0);" onclick="showRecord(' . $row["stu_id"] . ')" data-bs-toggle="modal" data-bs-target="#updateModal"><span style="color:green;"><i class="fas fa-edit"></i></span></button></td>
               <td><button style="border:none;background:rgba(0,0,0,0);" onclick="deleteRecord(' . $row["stu_id"] . ')"><span style="color:red;"><i class="fas fa-trash"></i></span></button></td>
            </tr>
            </tbody>';

                $index++;
            }
        }
    }


    if ($operation === "delete") {
        $id = mysqli_real_escape_string($connect, $_POST["id"]);
        $delete = "DELETE FROM `students` WHERE stu_id = ?";
        $stmt = $connect->prepare($delete);
        $stmt->bind_param("i", $id);
        $stmt->execute();
    }

    if ($operation === "insert") {
        $fname = mysqli_real_escape_string($connect, $_POST["fname"]);
        $lname = mysqli_real_escape_string($connect, $_POST["lname"]);
        $email = mysqli_real_escape_string($connect, $_POST["email"]);
        $city = mysqli_real_escape_string($connect, $_POST["city"]);

        $insert = "INSERT INTO `students`(`firstname`, `lastname`, `email`, `city`) VALUES (?,?,?,?)";
        $stmt = $connect->prepare($insert);
        $stmt->bind_param("ssss", $fname, $lname, $email, $city);
        $stmt->execute();
    }

    if ($operation === "profile") {
        $profile_id = mysqli_real_escape_string($connect, $_POST["id"]);

        $sel = "SELECT `stu_id`, `firstname`, `lastname`, `email`, `city` FROM `students` WHERE `stu_id` = ?";
        $stmt = $connect->prepare($sel);
        $stmt->bind_param("i", $profile_id);
        $stmt->execute();
        $stmt->bind_result($stu_id, $fname, $lname, $email, $city);

        while ($stmt->fetch()) {
            echo  '<div class="mb-3">
                   <input type="text" class="form-control" id="fname" placeholder="First Name" required value="' . htmlspecialchars(ucwords($fname)) . '">
                </div>
                <div class="mb-3">
                   <input type="text" class="form-control" id="lname" placeholder="Last Name" required value="' . htmlspecialchars(ucwords($lname)) . '">
                </div>
                <div class="mb-3">
                   <input type="email" class="form-control" id="email" placeholder="Email ID" required value="' . htmlspecialchars(ucwords($email)) . '">
                </div>
                <div class="mb-3">
                   <input type="text" class="form-control" id="city" placeholder="City" required value="' . htmlspecialchars(ucwords($city)) . '">
                </div>';
        }
    }
}

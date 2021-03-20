<?php

$conn = mysqli_connect('localhost', 'root', "", 'ajax_crud');

extract($_POST);
// var_dump($_GET['action']);
// die();

// view part 

if (isset($_POST['readRecord'])) {
    $data = '<table class="table table-bordered table-striped">
            <tr>
            <th>No</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Edit</th>
            <th>Delete</th>
            </tr>';
    $display = "SELECT * FROM information ORDER BY id DESC ";
    $result =  mysqli_query($conn, $display);

    if (mysqli_num_rows($result) > 0) {
        $number = 1;
        while ($row = mysqli_fetch_array($result)) {
            $data .= '<tr>
                      <td>' . $number . '</td>
                      <td>' . $row['firstname'] . '</td>
                      <td>' . $row['lastname'] . '</td>
                      <td>' . $row['email'] . '</td>
                      <td>' . $row['phone'] . '</td>
                      <td><button onclick="EditUser(' . $row['id'] . ')" class="btn btn-warning">Edit</button></td>
                      <td><button onclick="DeleteUser(' . $row['id'] . ')" class="btn btn-danger">Delete</button></td>
                      </tr>';
            $number++;
        }
    }
    $data .= '</table>';
    echo $data;
}


// insert part 
if ($_GET['action'] == 'insert') {

    $query = "INSERT INTO `information`(`firstname`, `lastname`, `email`, `phone`)
     VALUES ('$firstname','$lastname','$email','$phone')";

    mysqli_query($conn, $query);
}

// delete part 

if (isset($_POST['deleteid'])) {
    $userid = $_POST['deleteid'];

    $deletequery = "DELETE FROM information where id='$userid'";
    mysqli_query($conn, $deletequery);
}


// edit part 

if (isset($_POST['id']) && isset($_POST['id']) != "") {
    $userid = $_POST['id'];
    $query = "SELECT * FROM information WHERE id = '$userid'";
    //var_dump($query);
    if (!$result = mysqli_query($conn, $query)) {
        exit(mysqli_error($conn));
    }
    $response = array();

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {

            $response = $row;
        }
    } else {
        $response['status'] = 200;
        $response['massage'] = "Data not found";
    }
    echo json_encode($response);
} else {
    $response['status'] = 200;
    $response['massage'] = "invalid request!";
}

// update part

if (isset($_POST['hidden_user_id'])) {

    $id = $_POST['hidden_user_id'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    $query = "UPDATE information SET firstname='$firstname',lastname='$lastname',email='$email',phone='$phone' WHERE id = '$id' ";
    mysqli_query($conn, $query);
}

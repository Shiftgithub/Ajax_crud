<!DOCTYPE html>
<html>

<head>
    <title>Ajax_crud</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> -->
    <link rel="stylesheet" href="bootstrap.css">
</head>

<body>
    <div class="container">
        <h1 class="bg-dark text-white text-center">Ajax Crud</h1>

        <div class="d-flex justify-content-end">

            <!-- Button to Open the Modal -->
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                Create
            </button>
        </div>
        <h2 class="text-danger">All Records</h2>
        <div id="records_contant">
        </div>
        <!-- The Modal -->
        <div class="modal" id="myModal">
            <div class="modal-dialog">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Ajax Crud</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="firstname">First Name </label>
                            <input type="text" name="firstname" value="" id="firstname"
                                placeholder="Enter your first name" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="lastname">Last Name </label>
                            <input type="text" name="lastname" value="" id="lastname" placeholder="Enter your last name"
                                class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="email">Email </label>
                            <input type="email" name="email" value="" id="email" placeholder="Enter your email address"
                                class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone </label>
                            <input type="text" name="phone" value="" id="phone" placeholder="Enter your phone number"
                                class="form-control">
                        </div>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" data-dismiss="modal"
                            onclick="addRecord()">Submit</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>

                </div>
            </div>
        </div>

        <!-- update part -->
        <!-- The Modal -->
        <div class="modal" id="updateUserModal">
            <div class="modal-dialog">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Ajax Crud</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="update_firstname">First Name </label>
                            <input type="text" name="update_firstname" value="" id="update_firstname"
                                placeholder="Enter your first name" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="update_lastname">Last Name </label>
                            <input type="text" name="update_lastname" value="" id="update_lastname"
                                placeholder="Enter your last name" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="update_email">Email </label>
                            <input type="email" name="update_email" value="" id="update_email"
                                placeholder="Enter your email address" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="update_phone">Phone </label>
                            <input type="text" name="update_phone" value="" id="update_phone"
                                placeholder="Enter your phone number" class="form-control">
                        </div>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-info" data-dismiss="modal"
                            onclick="UpdateUser()">Update</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <input type="hidden" name="" id="hidden_user_id">
                    </div>

                </div>
            </div>
        </div>
    </div>
    <script src="jquery.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script type="text/javascript">
    // all time show view
    $(document).ready(function() {
        readRecords();
    });

    // view part 
    function readRecords() {
        var readRecord = "readRecord";
        $.ajax({
            url: "processing.php",
            type: 'post',
            data: {
                readRecord: readRecord
            },
            success: function(data, status) {
                $('#records_contant').html(data);
            }
        });

    }

    // insert part

    function addRecord() {
        var firstname = $('#firstname').val();
        var lastname = $('#lastname').val();
        var email = $('#email').val();
        var phone = $('#phone').val();

        $.ajax({
            url: "processing.php?action=insert",
            type: 'post',
            data: {
                firstname: firstname,
                lastname: lastname,
                email: email,
                phone: phone
            },
            success: function(data, status) {
                readRecords();
            }

        });
    }

    // delete part 

    function DeleteUser(deleteid) {
        var conf = confirm("Are you sure");
        if (conf == true) {
            $.ajax({
                url: "processing.php",
                type: "post",
                data: {
                    deleteid: deleteid
                },
                success: function(data, status) {
                    readRecords();
                }
            });
        }
    }

    // Edit part 

    function EditUser(id) {

        $('#hidden_user_id').val(id);

        $.post("processing.php", {
                id: id
            },
            function(data, status) {
                var user = JSON.parse(data);
                $('#update_firstname').val(user.firstname);
                $('#update_lastname').val(user.lastname);
                $('#update_email').val(user.email);
                $('#update_phone').val(user.phone);
            });
        $('#updateUserModal').modal("show");

    }

    // update part 

    function UpdateUser() {
        console.log('hidden_user_id');
        var firstname = $('#update_firstname').val();
        var lastname = $('#update_lastname').val();
        var email = $('#update_email').val();
        var phone = $('#update_phone').val();

        var hidden_user_id = $('#hidden_user_id').val();

        console.log(hidden_user_id);

        $.post("processing.php", {
                hidden_user_id: hidden_user_id,
                firstname: firstname,
                lastname: lastname,
                email: email,
                phone: phone
            },
            function(data, status) {
                $('#updateUserModal').modal("hide");
                readRecords();
            }
        );
    }
    </script>
</body>

</html>
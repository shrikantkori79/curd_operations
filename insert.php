
<?php

use Dom\Document;

    $conn = mysqli_connect("localhost","root","","curd") or die("Connection failed: " . mysqli_connect_error());
    $msg="";
    if(isset($_POST['insert']))
        {
           
            $name = mysqli_real_escape_string($conn, $_POST['name']);
            $fname = mysqli_real_escape_string($conn, $_POST['fname']);
            $dob = mysqli_real_escape_string($conn, $_POST['dob']);
            $gen = mysqli_real_escape_string($conn, $_POST['gen']);
            $mobno = mysqli_real_escape_string($conn, $_POST['mobno']);

        $sql = "INSERT INTO student_info(`nam`, `fnam`, `dob`, `gen`, `mobno`) VALUES ('$name','$fname','$dob','$gen','$mobno')";
            $result = mysqli_query($conn,$sql) or die(mysqli_error($conn));
            if($result)
            {
                $msg='<div class="alert alert-success" role="alert">
                        Data inserted successfully!
                        </div>';
            }
            else
            {
                $msg='<div class="alert alert-danger" role="alert">
                        Data not inserted successfully!
                        </div>';
            }
        }
     elseif(isset($_GET['act']) && $_GET['act'] === 'delete')
     {
            echo "delete";
            $id = mysqli_real_escape_string($conn, $_GET['id']);
            $sql = "DELETE FROM student_info WHERE id='$id'";
            $result = mysqli_query($conn,$sql) or die(mysqli_error($conn));
            if($result)
            {
                $msg='<div class="alert alert-success" role="alert">
                        Data deleted successfully!
                        </div>';
            }
            else
            {
                $msg='<div class="alert alert-danger" role="alert">
                        Data not deleted successfully!
                        </div>';
            }
     }
     elseif(isset($_GET['act'])&&($_GET['act'])==='update')
        {
            echo "update";
           
        }
  // view using modal
        elseif(isset($_GET['act'])&&($_GET['act'])==='view')
        {
            echo "view";
             $id = mysqli_real_escape_string($conn, $_GET['id']);
             echo $id;
             $result = mysqli_query($conn, "SELECT * FROM student_info WHERE id='$id'") or die(mysqli_error($conn));
             $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
             echo $row['id'];
             $id=$row['id'];
             $name=$row['nam'];
             $fname=$row['fnam'];
             $gen=$row['gen'];
             $dob=$row['dob'];

         
        }       
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>curd operation</title>

    <script src="/node_modules/bootstrap/dist/js/bootstrap.bundle.js"></script>
    <link rel="stylesheet" href="/node_modules/bootstrap/dist/css/bootstrap.css">
    <link rel="stylesheet" href="/node_modules/bootstrap-icons/font/bootstrap-icons.css">
    <style>
        .btn-primary:hover
         {
        background-color: #dc3545;
        border-color: #dc3545;
        color: white;
        }
    </style>

    
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-4">

            </div>

            <div class="col-8" style="margin-top: 50px;" >
                <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <?php 
                        echo $msg;
                    ?>
                    <div class="mb-2">
                        <label for="name">NAME</label>
                        <div>
                            <input type="text" name="name" id="name" required>
                        </div>
                    </div>
                    <div class="mb-2">
                        <label for="fname">Father Name</label>
                        <div>
                            <input type="text" name="fname" id="fname" required>
                        </div>
                    </div>
                    <div class="mb-2">
                        <label for="dob">Date of Birth</label>
                        <div>
                            <input type="date" name="dob" id="dob" required>
                        </div>
                    </div>
                    <div class="mb-2">
                        <label for="gender">Gender</label>
                        <div>
                            <input type="radio" name="gen" id="male" value="male" required> Male
                            <input type="radio" name="gen" id="female" value="female" required> Female
                        </div>  
                    </div>
                    <div>
                        <label for="mobno">Mobile No</label>
                        <div>
                            <input type="text" name="mobno" id="mobno" required>
                        </div>
                    </div>
                    <div class="mt-4">
                        <button style="margin-left: 50px;margin-bottom: 20px;" type="submit" name="insert" id="insert" class="btn btn-primary">Insert</button>
                                          
                    </div>
                </form>
            </div>

        </div>

            <div>
                <?php
                        $sql = "SELECT * FROM student_info";
                        $result = mysqli_query($conn, $sql) or die("Query failed: " . mysqli_error($conn)); 
                        $rowcount = mysqli_num_rows($result);
                        $row='';
                        if($rowcount > 0)
                        {
                            
                            while($rows = mysqli_fetch_array($result, MYSQLI_ASSOC))
                            {
                                $row.= '<tr>
                                            <td>'.$rows['id'].'</td>
                                            <td>'.$rows['nam'].'</td>
                                            <td>'.$rows['fnam'].'</td>
                                            <td>'.$rows['gen'].'</td>
                                            <td>'.$rows['dob'].'</td>
                                            
                                            <td>
                                                 <a href="?act=view&id='.$rows['id'].'" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#studentModal">View</a> 
                                                <a href="?act=update&id='.$rows['id'].'" class="btn btn-primary">Update</a> 
                                                <a href="?act=delete&id='.$rows['id'].'" class="btn btn-danger">delete</a></td>
                                            </tr>';
                            }
                        }
                      
                    ?>
    
                <table class="table">
                    <thead>
                        <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Name</th>
                        <th scope="col">Father Name</th>
                        <th scope="col">Gender</th>
                        <th scope="col">Date Of Birth</th>
                        <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php echo $row;?>
                        
                    </tbody>
                </table>

            </div>


        <div class="modal fade" id="studentModal" tabindex="-1">
        <div class="modal-dialog">
        <div class="modal-content">

        <div class="modal-header">
        <h5 class="modal-title">Student Details</h5>
        <button type="button" class="btn-close"
        data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
            <p><strong>ID:</strong> <?php echo isset($id) ? $id : ''; ?></p>
            <p><strong>Name:</strong> <?php echo isset($name) ? $name : ''; ?></p>
            <p><strong>Father Name:</strong> <?php echo isset($fname) ? $fname : ''; ?></p>
            <p><strong>Gender:</strong> <?php echo isset($gen) ? $gen : ''; ?></p>
            <p><strong>Date of Birth:</strong> <?php echo isset($dob) ? $dob : ''; ?></p>
        </div>

        </div>
        </div>
        </div>
</div>

</body>
</html>




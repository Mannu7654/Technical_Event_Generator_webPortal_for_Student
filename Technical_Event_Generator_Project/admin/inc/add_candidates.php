<?php 
    if(isset($_GET['added']))
    {
?>
        <div class="alert alert-success my-3" role="alert">
            Candidate has been added successfully.
        </div>
<?php 
    }else if(isset($_GET['largeFile'])) {
?>
        <div class="alert alert-danger my-3" role="alert">
            Candidate image is too large, please upload small file (you can upload any image upto 2mbs.).
        </div>
<?php
    }else if(isset($_GET['invalidFile']))
    {
?>
        <div class="alert alert-danger my-3" role="alert">
            Invalid image type (Only .jpg, .png files are allowed) .
        </div>
<?php
    }else if(isset($_GET['failed']))
    {
?>
        <div class="alert alert-danger my-3" role="alert">
            Image uploading failed, please try again.
        </div>
<?php
    }

?>



<?php 
    if(isset($_GET['id']))
    {
        $d_id = $_GET['id'];
        mysqli_query($db, "DELETE FROM candidate_details WHERE id = '". $d_id ."'") OR die(mysqli_error($db));
?>
       <div class="alert alert-danger my-3" role="alert">
            Registered candidates has been deleted successfully!
        </div>
<?php

    }
?>


<div class="row my-3">
    <div class="col-4">
        <h3>Add New Teacher/ Student</h3>
        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <select class="form-control" name="event_id" required> 
                    <option value=""> Select Events </option>
                    <?php 
                        $fetchingEvents = mysqli_query($db, "SELECT * FROM tech_event") OR die(mysqli_error($db));
                        $isAnyEventAdded = mysqli_num_rows($fetchingEvents);
                        if($isAnyEventAdded > 0)
                        {
                            while($row = mysqli_fetch_assoc($fetchingEvents))
                            {
                                $event_id = $row['id'];
                                $event_name = $row['event_topic'];
                                $allowed_candidates = $row['no_of_candidates'];

                                // Now checking how many candidates are added in this election 
                                $fetchingCandidate = mysqli_query($db, "SELECT * FROM candidate_details WHERE event_id = '". $event_id ."'") or die(mysqli_error($db));
                                $added_candidates = mysqli_num_rows($fetchingCandidate);

                                if($added_candidates < $allowed_candidates)
                                {
                        ?>
                                <option value="<?php echo $event_id; ?>"><?php echo $event_name; ?></option>
                        <?php
                                }
                            }
                        }else {
                    ?>
                            <option value=""> Please add event first </option>
                    <?php
                        }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <input type="text" name="candidate_name" placeholder="Teacher/Student Name" class="form-control" required />
            </div>
            <div class="form-group">
                <input type="file" name="candidate_photo" class="form-control" required />
            </div>
            <div class="form-group">
                <input type="text" name="candidate_details" placeholder="Teacher/Student Details" class="form-control" required />
            </div>
            <input type="submit" value="Add Candidate" name="addCandidateBtn" class="btn btn-success" />
        </form>
    </div>   

    <br><br><br>

    <div class="col-8">
        <h3>Teacher/Student Details</h3>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">S.No</th>
                    <th scope="col">Photo</th>
                    <th scope="col">Name</th>
                    <th scope="col">Details</th>
                    <th scope="col">Events</th>
                    <th scope="col">Action </th>
                    
                </tr>
            </thead>
            <tbody>
                <?php 
                    $fetchingData = mysqli_query($db, "SELECT * FROM candidate_details") or die(mysqli_error($db)); 
                    $isAnyCandidateAdded = mysqli_num_rows($fetchingData);

                    if($isAnyCandidateAdded > 0)
                    {
                        $sno = 1;
                        while($row = mysqli_fetch_assoc($fetchingData))
                        {
                            $id= $row["id"];
                            $event_id = $row['event_id'];
                            $fetchingEventName = mysqli_query($db, "SELECT * FROM tech_event WHERE id = '". $event_id ."'") or die(mysqli_error($db));
                            $execFetchingEventNameQuery = mysqli_fetch_assoc($fetchingEventName);
                            $event_name = $execFetchingEventNameQuery['event_topic'];

                            $candidate_photo = $row['candidate_photo'];

                ?>
                            <tr>
                                <td><?php echo $sno++; ?></td>
                                <td> <img src="<?php echo $candidate_photo; ?>" class="candidate_photo" />    </td>
                                <td><?php echo $row['candidate_name']; ?></td>
                                <td><?php echo $row['candidate_details']; ?></td>
                                <td><?php echo $event_name; ?></td>
                                <td> 
                                    <a href="#" class="btn btn-sm btn-warning"> Edit </a>
                                    <button class="btn btn-sm btn-danger" onclick="checkdelete(<?php echo $id; ?>)"> Delete </button>
                                </td>
                            </tr>   
                <?php
                        }
                    }else {
            ?>
                        <tr> 
                            <td colspan="7"> No any teacher/student is added yet. </td>
                        </tr>
            <?php
                    }
                ?>
            </tbody>    
        </table>
    </div>
</div>

<br><br><br>

<script>

    function checkdelete(e_id) 
    {
        let d= confirm('Are you sure you want to delete candidates ?'); 

        if(d == true)
        {
            location.assign("index.php?addCandidatePage=1&id=" + e_id);
        }
    }
</script>

<?php 

    if(isset($_POST['addCandidateBtn']))
    {
        $event_id = mysqli_real_escape_string($db, $_POST['event_id']);
        $candidate_name = mysqli_real_escape_string($db, $_POST['candidate_name']);
        $candidate_details = mysqli_real_escape_string($db, $_POST['candidate_details']);
        $inserted_by = $_SESSION['username'];
        $inserted_on = date("Y-m-d");

        // Photograph Logic Starts
        $targetted_folder = "../assets/images/candidate_photos/";
        $candidate_photo = $targetted_folder . rand(1000, 9999) . "_" . rand(1111, 9999) . $_FILES['candidate_photo']['name'];
        $candidate_photo_tmp_name = $_FILES['candidate_photo']['tmp_name'];
        $candidate_photo_type = strtolower(pathinfo($candidate_photo, PATHINFO_EXTENSION));
        $allowed_types = array("jpg", "png", "jpeg");        
        $image_size = $_FILES['candidate_photo']['size'];

        if($image_size < 3000000) // 3 MB
        {
            if(in_array($candidate_photo_type, $allowed_types))
            {
                if(move_uploaded_file($candidate_photo_tmp_name, $candidate_photo))
                {
                    // inserting into db
                    mysqli_query($db, "INSERT INTO candidate_details(event_id, candidate_name, candidate_details, candidate_photo, inserted_by, inserted_on) VALUES('". $event_id ."', '". $candidate_name ."', '". $candidate_details ."', '". $candidate_photo ."', '". $inserted_by ."', '". $inserted_on ."')") or die(mysqli_error($db));

                    echo "<script> location.assign('index.php?addCandidatePage=1&added=1'); </script>";


                }else {
                    echo "<script> location.assign('index.php?addCandidatePage=1&failed=1'); </script>";                    
                }
            }else {
                echo "<script> location.assign('index.php?addCandidatePage=1&invalidFile=1'); </script>";
            }
        }else {
            echo "<script> location.assign('index.php?addCandidatePage=1&largeFile=1'); </script>";
        }

        // Photograph Logic Ends
        




        
      ?>

      <?php

    }



?>
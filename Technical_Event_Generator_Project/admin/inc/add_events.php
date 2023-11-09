
<?php 
    if(isset($_GET['added']))
    {
?>
        <div class="alert alert-success my-3" role="alert">
            Technical Event has been added successfully.
        </div>
<?php 
    }else if(isset($_GET['delete_id']))
    {
        $d_id = $_GET['delete_id'];
        mysqli_query($db, "DELETE FROM tech_event WHERE id = '". $d_id ."'") OR die(mysqli_error($db));
?>
       <div class="alert alert-danger my-3" role="alert">
            Technical Event has been deleted successfully!
        </div>
<?php

    }
?>




<div class="row my-3">
    <div class="col-4">
        <h3>Add New Technical Event</h3>
        <form method="POST">
            <div class="form-group">
                <input type="text" name="event_topic" placeholder="Event Topic" class="form-control" required />
            </div>
            <div class="form-group">
                <input type="number" name="number_of_candidates" placeholder="No of Candidates" class="form-control" required />
            </div>
            <div class="form-group">
                <input type="text" onfocus="this.type='Date'" name="starting_date" placeholder="Starting Date" class="form-control" required />
            </div>
            <div class="form-group">
                <input type="text" onfocus="this.type='Date'" name="ending_date" placeholder="Ending Date" class="form-control" required />
            </div>
            <input type="submit" value="Add Technical Event" name="addEventBtn" class="btn btn-success" />
        </form>
    </div>

    <div class="col-8">
        <h3>Upcoming Events</h3>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">S.No</th>
                    <th scope="col">Event Name</th>
                    <th scope="col">Candidates</th>
                    <th scope="col">Starting Date</th>
                    <th scope="col">Ending Date</th>
                    <th scope="col">Status </th>
                    <th scope="col">Action </th>
                    
                </tr>
            </thead>
            <tbody>
                <?php 
                    $fetchingData = mysqli_query($db, "SELECT * FROM tech_event") or die(mysqli_error($db)); 
                    $isAnyEventAdded = mysqli_num_rows($fetchingData);

                    if($isAnyEventAdded > 0)
                    {
                        $sno = 1;
                        while($row = mysqli_fetch_assoc($fetchingData))
                        {
                            $event_id = $row['id'];
                ?>
                            <tr>
                                <td><?php echo $sno++; ?></td>
                                <td><?php echo $row['event_topic']; ?></td>
                                <td><?php echo $row['no_of_candidates']; ?></td>
                                <td><?php echo $row['starting_date']; ?></td>
                                <td><?php echo $row['ending_date']; ?></td>
                                <td><?php echo $row['status']; ?></td>
                                <td> 
                                    <a href="#" class="btn btn-sm btn-warning"> Edit </a>
                                    <button class="btn btn-sm btn-danger" onclick="DeleteData(<?php echo $event_id; ?>)"> Delete </button>
                                </td>
                            </tr>
                <?php
                        }
                    }else {
            ?>
                        <tr> 
                            <td colspan="7"> No any event is added yet. </td>
                        </tr>
            <?php
                    }
                ?>
            </tbody>    
        </table>
    </div>
</div>


<script>
    const DeleteData = (e_id) => 
    {
        let c = confirm("Are you really want to delete it?");

        if(c == true)
        {
            location.assign("index.php?addEventPage=1&delete_id=" + e_id);
        }
    }
</script>

<?php 

    if(isset($_POST['addEventBtn']))
    {
        $event_topic = mysqli_real_escape_string($db, $_POST['event_topic']);
        $number_of_candidates = mysqli_real_escape_string($db, $_POST['number_of_candidates']);
        $starting_date = mysqli_real_escape_string($db, $_POST['starting_date']);
        $ending_date = mysqli_real_escape_string($db, $_POST['ending_date']);
        $inserted_by = $_SESSION['username'];
        $inserted_on = date("Y-m-d");


        $date1=date_create($inserted_on);
        $date2=date_create($starting_date);
        $diff=date_diff($date1,$date2);
        
        
        if((int)$diff->format("%R%a") > 0)
        {
            $status = "InActive";
        }else {
            $status = "Active";
        }

        // inserting into db
        mysqli_query($db, "INSERT INTO tech_event(event_topic, no_of_candidates, starting_date, ending_date, status, inserted_by, inserted_on) VALUES('". $event_topic ."', '". $number_of_candidates ."', '". $starting_date ."', '". $ending_date ."', '". $status ."', '". $inserted_by ."', '". $inserted_on ."')") or die(mysqli_error($db));
        
    ?>
            <script> location.assign("index.php?addEventPage=1&added=1"); </script>
    <?php

    }






?>
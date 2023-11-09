<?php 
    require_once("../../admin/inc/config.php");
    

    if(isset($_POST['e_id']) AND isset($_POST['c_id']) AND isset($_POST['v_id']))
    {
        $event_date = date("Y-m-d");
        $event_time = date("h:i:s a");

        mysqli_query($db, "INSERT INTO registered_candidate(event_id, even_id, candidate_id, event_date, event_time) VALUES('". $_POST['e_id'] ."', '". $_POST['v_id'] ."','". $_POST['c_id'] ."','". $event_date ."','". $event_time ."')") or die(mysqli_error($db));

        echo "Success";
    }

?>
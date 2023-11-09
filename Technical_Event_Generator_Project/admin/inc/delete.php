<?php 
    include("config.php");

    $id=$_GET['id'];

    $sql="DELETE FROM `candidate_details` WHERE `id`= '$id'";
    $result=mysqli_query($db,$sql);

    if($result){
        echo "<script>alert('Record deleted')</script>";
        ?>

        <meta http-equiv="refresh" content="0; url= http://localhost/Technical_Event_Generator_Project/admin/index.php?addCandidatePage=1" />

        <?php
    }else{

        echo "<script>alert('Failed to delete')</script>";
    }

?>
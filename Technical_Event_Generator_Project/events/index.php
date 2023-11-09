<?php 
    require_once("inc/header.php");
    require_once("inc/navigation.php");
?>

    <div class="row my-3">
        <div class="col-12">
            <h3> Event Details </h3>

            <?php 
                $fetchingActiveEvents = mysqli_query($db, "SELECT * FROM tech_event WHERE status = 'Active'") or die(mysqli_error($db));
                $totalActiveEvents = mysqli_num_rows($fetchingActiveEvents);

                if($totalActiveEvents > 0) 
                {
                    while($data = mysqli_fetch_assoc($fetchingActiveEvents))
                    {
                        $event_id = $data['id'];
                        $event_topic = $data['event_topic'];    
                ?>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th colspan="4" class="bg-green text-white"><h5> EVENT TOPIC: <?php echo strtoupper($event_topic); ?></h5></th>
                                </tr>
                                <tr>
                                    <th> Photo </th>
                                    <th> Candidate Details </th>
                                    <th> Register for Event </th>
                                    <th> Action </th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php 
                                $fetchingCandidates = mysqli_query($db, "SELECT * FROM candidate_details WHERE event_id = '". $event_id ."'") or die(mysqli_error($db));

                                while($candidateData = mysqli_fetch_assoc($fetchingCandidates))
                                {
                                    $candidate_id = $candidateData['id'];
                                    $candidate_photo = $candidateData['candidate_photo'];

                                    // Fetching Candidate Votes 
                                    $fetchingEvents = mysqli_query($db, "SELECT * FROM registered_candidate WHERE candidate_id = '". $candidate_id . "'") or die(mysqli_error($db));
                                    $totalEvents = mysqli_num_rows($fetchingEvents);

                            ?>
                                    <tr>
                                        <td> <img src="<?php echo $candidate_photo; ?>" class="candidate_photo"> </td>
                                        <td><?php echo "<b>" . $candidateData['candidate_name'] . "</b><br />" . $candidateData['candidate_details']; ?></td>
                                        <td><?php echo $totalEvents; ?></td>
                                        <td>
                                    <?php
                                            $checkIfEventCasted = mysqli_query($db, "SELECT * FROM registered_candidate WHERE even_id = '". $_SESSION['user_id'] ."' AND event_id = '". $event_id ."'") or die(mysqli_error($db));    
                                            $isEventCasted = mysqli_num_rows($checkIfEventCasted);

                                            if($isEventCasted > 0)
                                            {
                                                $eventCastedData = mysqli_fetch_assoc($checkIfEventCasted);
                                                $eventCastedToCandidate = $eventCastedData['candidate_id'];

                                                if($eventCastedToCandidate == $candidate_id)
                                                {
                                    ?>

                                                    <img src="../assets/images/eventReg1.gif" width="150px;">
                                    <?php
                                                }
                                            }else {
                                    ?>
                                                <button class="btn btn-md btn-success" onclick="CastEvent(<?php echo $event_id; ?>, <?php echo $candidate_id; ?>, <?php echo $_SESSION['user_id']; ?>)"> <img src="../assets/images/eventReg2.gif" width="150px;">  </button>
                                    <?php
                                            }

                                            
                                    ?>


                                    </td>
                                    </tr>
                            <?php
                                }
                            ?>
                            </tbody>

                        </table>
                <?php
                    
                    }
                }else {
                    echo "No any active election.";
                }
            ?>

            
        </div>
    </div>


<script>
    const CastEvent = (event_id, customer_id, even_id) => 
    {
        $.ajax({
            type: "POST", 
            url: "inc/ajaxCalls.php",
            data: "e_id=" + event_id + "&c_id=" + customer_id + "&v_id=" + even_id, 
            success: function(response) {
                
                if(response == "Success")
                {
                    location.assign("index.php?eventCasted=1");
                }else {
                    location.assign("index.php?eventNotCasted=1");
                }
            }
        });
    }

</script>

<br><br><br><br>

<?php
    require_once("inc/footer.php");
?>
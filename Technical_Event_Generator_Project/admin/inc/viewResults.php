<?php 
    $event_id = $_GET['viewResult'];

?>

<div class="row my-3">
        <div class="col-12">
            <h3> Event Registration Results </h3>

            <?php 
                $fetchingActiveEvents = mysqli_query($db, "SELECT * FROM tech_event WHERE id = '". $event_id ."'") or die(mysqli_error($db));
                $totalActiveEvents = mysqli_num_rows($fetchingActiveEvents);

                if($totalActiveEvents > 0) 
                {
                    while($data = mysqli_fetch_assoc($fetchingActiveEvents))
                    {
                        $evebt_id = $data['id'];
                        $event_topic = $data['event_topic'];    
                ?>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th colspan="4" class="bg-green text-white"><h5> EVent TOPIC: <?php echo strtoupper($event_topic); ?></h5></th>
                                </tr>
                                <tr>
                                    <th> Photo </th>
                                    <th> Candidate Details </th>
                                    <th> Registration of Events </th>
                                    <!-- <th> Action </th> -->
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


            <hr>
            <h3>Voting Details</h3>
            <?php 
                $fetchingEventDetails = mysqli_query($db, "SELECT * FROM registered_candidate WHERE event_id = '". $event_id ."'");
                $number_of_events = mysqli_num_rows($fetchingEventDetails);

                if($number_of_events > 0)
                {
                    $sno = 1;
            ?>
                    <table class="table">
                        <tr>
                            <th>S.No</th>
                            <th>Voter Name</th>
                            <th>Contact No</th>
                            <th>Voted To</th>
                            <th>Date </th>
                            <th>Time</th>
                        </tr>

            <?php
                    while($data = mysqli_fetch_assoc($fetchingEventDetails))
                        {
                            $even_id = $data['even_id'];
                            $candidate_id = $data['candidate_id'];
                            $fetchingUsername = mysqli_query($db, "SELECT * FROM users WHERE id = '". $even_id ."'") or die(mysqli_error($db));
                            $isDataAvailable = mysqli_num_rows($fetchingUsername);
                            $userData = mysqli_fetch_assoc($fetchingUsername);
                            if($isDataAvailable > 0)
                            {
                                $username = $userData['username'];
                                $contact_no = $userData['contact_no'];
                            }else {
                                $username = "No_Data";
                                $contact_no = $userData['contact_no'];
                            }


                            $fetchingCandidateName = mysqli_query($db, "SELECT * FROM candidate_details WHERE id = '". $candidate_id ."'") or die(mysqli_error($db));
                            $isDataAvailable = mysqli_num_rows($fetchingCandidateName);
                            $candidateData = mysqli_fetch_assoc($fetchingCandidateName);
                            if($isDataAvailable > 0)
                            {
                                $candidate_name = $candidateData['candidate_name'];
                            }else {
                                $candidate_name = "No_Data";
                            }
                ?>
                            <tr>
                                <td><?php echo $sno++; ?></td>
                                <td><?php echo $username; ?></td>
                                <td><?php echo $contact_no; ?></td>
                                <td><?php echo $candidate_name; ?></td>
                                <td><?php echo $data['event_date']; ?></td>
                                <td><?php echo $data['event_time']; ?></td>
                            </tr>
                <?php
                        }
                        echo "</table>";
                    }else {
                        echo "No any vote detail is available!";
                    }







                ?>
            </table>
            
        </div>
    </div>



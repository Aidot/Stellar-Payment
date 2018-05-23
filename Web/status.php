<?php
    require('./include/connect.php');
    $id = $_GET['txn_id'];
    $query = "SELECT * FROM invoices WHERE id='$id'";
    $sql_query = mysqli_query($dbConnect, $query);
    if (($sql_numrows_one = mysqli_num_rows($sql_query)) == 1) {
        $sql_fetch = mysqli_fetch_assoc($sql_query);
        $status_text = $sql_fetch['status'] == 0 ? 'Waiting for the payment...' : 'Complete!';
        $output = array(
            'error' => 'ok',
            'result' => array(
                'status' => $sql_fetch['status'],
                'status_text' => $status_text,
                'time_expires' => strtotime($sql_fetch['date']) + 0.5*60*60,
            ),
        );
        header('Content-type: application/json');
        print_r(json_encode($output));
    }
?>

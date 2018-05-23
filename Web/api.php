<?php
    $param = $_REQUEST['jsondata'];

    // log for debugging
    // $file = 'log.txt';
    // $current = file_get_contents($file);
    // $current .= $param;
    // file_put_contents($file, $current);

    $arr = json_decode($param, true);

    $memo = $arr['memo'];
    $txn_id = $arr['id'];
    $send_address = $arr['source_account'];

    require('./include/connect.php');

    $query_one = "UPDATE invoices
        SET txn_id='$txn_id', send_address='$send_address', plain='$param', status=100
        WHERE memo='$memo'";
    $sql_query_one = mysqli_query($dbConnect, $query_one);

    if ($sql_query_one) {
        $output = array(
            'msg' => 'ok',
            'ledger' => $arr['ledger'],
            'memo' => $arr['memo'],
            'paging_token' => $arr['paging_token'],
        );
    } else {
        $output = array(
            'msg' => 'error',
        );
    };

    header('Content-type: application/json');
    print_r(json_encode($output));
    mysqli_close($dbConnect);
    exit();
?>

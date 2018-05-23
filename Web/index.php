<?php
    if ($_POST) {
        require('./include/connect.php');
        $code = 'XLM';
        $amount = $_REQUEST['amount'];
        $memo = str_pad(mt_rand(0, 999999), 6, "0", STR_PAD_BOTH);

        // Change to your recive address, you can generate keys at https://www.stellar.org/laboratory/#account-creator?network=test
        // It must the same address used in listen.js
        $receive_address = 'GBQ623Q6Z77EXWWFLC3NKHOEEWL3HEKHLNJDIIP26G7OLZRRDDT4R2LO';
        $query_one = "INSERT INTO  invoices
            (amount,memo,receive_address,coin_code)
            VALUES
            ('$amount','$memo','$receive_address','$code')";
        $sql_query_one = mysqli_query($dbConnect, $query_one);

        if ($sql_query_one) {
            $invoiceID = mysqli_insert_id($dbConnect);
            header("Location: invoice.php?id=$invoiceID");
            return true;
        }
        mysqli_close($dbConnect);
    	exit();
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1,  maximum-scale=1">
        <title>Order Form</title>
        <link rel="stylesheet" href="./assets/api.css">
        <link href="//cdn.bootcss.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    </head>
    <body>
        <div id="page-wrap">
            <div class="paybox-wrap">
                <div class="paybox-head">
                    <h3>Order</h3>
                </div>
                <div class="paybox-body">
                    <div class="paybox-table">
                        <form action="./" method="post">
                            <div class="paybox-td paybox-info">
                                <h4><i class="fa fa-diamond"></i> XLM Amount :</h4>
                                <input name="amount" class="info-item" type="text" value="" />
                                <h4><i class="fa fa-hashtag"></i> Send To Address:</h4>
                                <div class="info-item">
                                    GBQ623Q6Z77EXWWFLC3NKHOEEWL3HEKHLNJDIIP26G7OLZRRDDT4R2LO
                                </div>
                            </div>
                            <div class="paybox-submit">
                                <input type="submit" value="Continue &rarr;">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>


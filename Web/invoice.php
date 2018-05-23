<?php
    require('./include/connect.php');
    $id = $_GET['id'];
    $query = "SELECT * FROM invoices WHERE id='$id'";
    $sql_query = mysqli_query($dbConnect, $query);
    if (($sql_numrows_one = mysqli_num_rows($sql_query)) == 1) {
        $sql_fetch = mysqli_fetch_assoc($sql_query);
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1,  maximum-scale=1">
        <title>Invoice #<?php echo $sql_fetch['id']; ?></title>
        <link rel="stylesheet" href="./assets/api.css">
        <link href="//cdn.bootcss.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    </head>
    <body>
        <div id="page-wrap">
            <div class="paybox-wrap">
                <div class="paybox-head">
                    <h3>Payment</h3>
                </div>
                <div class="paybox-body">
                    <div class="paybox-meta">
                        <div class="paybox-row">
                            <div class="paybox-col-1">
                                <h4>Payment ID:</h4>
                                <em><?php echo $sql_fetch['id']; ?></em>
                            </div>
                            <div class="paybox-col-1">
                                <h4>Amount:</h4>
                                <em>
                                    ≈ <span class="amount-usd"></span> USD
                                </em>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                    <div class="paybox-table">
                        <div class="paybox-td paybox-info">
                            <h4><i class="fa fa-diamond"></i> Send this exact amount of:</h4>
                            <div class="info-item">
                                <?php echo $sql_fetch['amount']; ?> <?php echo $sql_fetch['coin_code']; ?>
                            </div>
                            <h4><i class="fa fa-hashtag"></i> Send To Address:</h4>
                            <div class="info-item">
                                <?php echo $sql_fetch['receive_address']; ?>
                            </div>
                            <h4><i class="fa fa-tags">*</i> MEMO:</h4>
                            <div class="info-item">
                                <?php echo $sql_fetch['memo']; ?>
                            </div>
                        </div>
                        <div class="paybox-td paybox-qr">
                            <img style="padding: 24px 0 0 16px;" width="118" src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=<?php echo $sql_fetch['receive_address']; ?>" alt="">
                        </div>
                    </div>
                </div>
                <div class="paybox-foot">
                    <div class="paybox-status">
                        <i class="fa fa-info-circle"></i>
                        <span>waiting for the payment...</span>
                        <!-- Sorry, this invoice has expired -->
                    </div>
                </div>
            </div>
        </div>
    </body>
    <script src="//cdn.bootcss.com/jquery/1.12.3/jquery.min.js"></script>
    <script type="text/javascript">
        var txn_id = '<?php echo $sql_fetch['id']; ?>';
        var status = 0;
        var xamount = <?php echo $sql_fetch['amount'];?>;
    </script>
    <script src="./assets/api.js"></script>
</html>
<?php
    mysqli_close($dbConnect);
    exit();
?>

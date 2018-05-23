$(document).ready(function() {
  $.get('./status.php', {txn_id: txn_id}, function(data, textStatus, xhr) {
      time_expires = data.result.time_expires;
      status = data.result.status;
      if (status < 100) {
          setInterval(TransactionStatusUpdate,5000);
      };
      $('.paybox-status span').text(data.result.status_text);
  });

  function TransactionStatusUpdate() {
    UpdateStatus(txn_id);
  };

  function UpdateStatus(txn_id) {
      var _url = "./status.php";
      $.ajax({
          type: "GET",
          data: 'txn_id='+ txn_id,
          url: _url,
          dataType: "json",
          success: function (data) {
  			status = data.result.status;
  			if (status == 100) {
  				window.location.reload();
  			}
              $('.paybox-status span').text(data.result.status_text)
          }
      });
  };

  function XLM2USD(amount) {
      $.get('https://api.coinmarketcap.com/v1/ticker/stellar/', function(data, textStatus, xhr) {
          if (data) {
              var usd = amount * parseFloat(data[0].price_usd);
              $('.amount-usd').text(Math.round(usd*10000)/10000);
          }
      });
  };

  XLM2USD(xamount);

});



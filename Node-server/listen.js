var EventSource = require('eventsource');
// Gernerate your keys at https://www.stellar.org/laboratory/#account-creator?network=test
// Change GBQ623Q6Z77EXWWFLC3NKHOEEWL3HEKHLNJDIIP26G7OLZRRDDT4R2LO to your receive address
var SourceUri = 'https://horizon-testnet.stellar.org/accounts/GBQ623Q6Z77EXWWFLC3NKHOEEWL3HEKHLNJDIIP26G7OLZRRDDT4R2LO/transactions';
var fs = require('fs');

fs.readFile('paging_token.txt', function(err, buf) {

  var lastToken = buf.toString();
  if (lastToken) {
    SourceUri = SourceUri + '?cursor=' + lastToken;
  }

  var es = new EventSource(SourceUri);
  es.onmessage = function(message) {
      var result = message.data ? JSON.parse(message.data) : message;
      console.log('\n');
      console.log('\x1b[5m%s\x1b[0m\x1b[32m%s\x1b[35m%s\x1b[0m', '*', ' NEW PAYMENT: ',`#${result.paging_token}`);
      var params = {
        id: result.id,
        paging_token: result.paging_token,
        hash: result.hash,
        ledger: result.ledger,
        created_at: result.created_at,
        source_account: result.source_account,
        source_account_sequence: result.source_account_sequence,
        fee_paid: result.fee_paid,
        memo: result.memo,
        signatures: result.signatures,
      };
      console.log(params);
      if (!!params) {
        SendData(params);
      };
  };
  es.onerror = function(error) {
      console.log('An error occured!');
  }
});


function SendData(data) {

  var request = require('request');
  var options = {
    uri: 'https://yours.com/folder/api.php', // Change this line to your api link.
    method: 'POST',
    json: true,
    form: {
      'jsondata' : JSON.stringify(data),
    }
  };

  request(options, function (error, response, body) {
    if (!error && response.statusCode == 200) {
      console.log('\x1b[2m%s\x1b[0m\x1b[32m%s\x1b[0m\x1b[7m%s\x1b[0m', '+', ' MEMO ', body.memo);
      savePagingToken(body.paging_token);
    }
  });

};

function savePagingToken(token) {
  // In most cases, you should save this to a local database or file so that
  // you can load it next time you stream new payments.
  fs.writeFile('paging_token.txt', token, function(err, data){
      if (err) console.log(err);
      console.log("PageToken: "+ token +" Written.");
  });
}

function loadLastPagingToken() {
  // Get the last paging token from a local database or file
}
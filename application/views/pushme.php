<!DOCTYPE html>
<head>
  <title>Pusher </title>
  <script src="https://js.pusher.com/5.0/pusher.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  
  <script>

    // Enable pusher logging - don't include this in production
    Pusher.logToConsole = true;

    var pusher = new Pusher('2778d2ac0fc0d4a099af', {
      cluster: 'ap2',
      forceTLS: true
    });

    var channel = pusher.subscribe('channelpush');
    channel.bind('my-event', function(data) {

        var not = data.message
        alert('Your OTP is : '+data.message);
        

    });
    
  </script>
  <div id="division"></div>
</head>
<body>
  
</body>
</html>
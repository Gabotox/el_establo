<?php
require '../config/config.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    
</head>
<body>
  <div id="paypal-button-container"></div>
 
  <!-- Replace the "test" client-id value with your client-id -->
  <script src="https://www.paypal.com/sdk/js?client-id=<?php  echo CLIENT_ID ?>&currency=MXN"></script>
  <script>
    paypal.Buttons({
        style: {
          color: 'blue',
          shape: 'pill'
        },
        createOrder: function(data,actions){
            return actions.order.create({
                purchase_units: [{
                    amount:{
                        value: 10000.00
                    }
                }]

            });
        },
        onApprove: function(data,actions){
            actions.order.capture().then(function(detalles){

                console.log(detalles);

            });

        },
        onCancel: function(data){
            alert("pago cancelado");
            console.log(data);
        }
    }).render('#paypal-button-container');
  </script>
    
</body>
</html>

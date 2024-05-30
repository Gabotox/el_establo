<?php
// SDK de Mercado Pago
require_once '../vendor/autoload.php';
use MercadoPago\Client\Preference\PreferenceClient;
use MercadoPago\MercadoPagoConfig;

// Agrega credenciales (reemplace con su token de acceso de producción)
MercadoPagoConfig::setAccessToken("TEST-5622736659025444-042817-e7c5506725397d2ca18bc6f40a47167d-653174302");
$client = new PreferenceClient();



$back_urls = array(
  "success" => "http://localhost/el_establo/php/captura2.php",
  "failure" => "http://localhost/el_establo/php/fallo.php"
);
$preference = $client->create([
  "items" => array(
     array(
      "title" => "Mi producto",
      "quantity" => 1,
      "id" => '0001', // ID de producto opcional
      "unit_price" => 20000,
      "currency_id" => 'COP'
     )
    ),
    'back_urls'=> $back_urls
]);

// Establecer URLs de redireccionamiento para éxito y fracaso


// Redireccionar automáticamente al usuario al sitio después de la aprobación
$preference->auto_return = "approved";
$preference->binary_mode = true; // Use el modo binario para obtener información de pago adicional (opcional)

$data['preference_id'] = $preference->id;


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    
</head>
<body>

<h3>Mercado pago</h3>

<div class="checkout-btn"></div>
<p>El ID de preferencia es: <?php echo $preference->id; ?></p>
<script src="https://sdk.mercadopago.com/js/v2"></script>


    
<script>
    const mp = new MercadoPago('TEST-63fac173-6c47-48fd-95a9-a8b579b869f1', {
        locale: 'es-CO' // Establecer idioma a español (Colombia)
    });

    mp.checkout({
        preference:{
            id:'<?php echo $preference->id; ?>'
        },
        render:{
            container:'.checkout-btn',
            label: 'Pagar por MP'
        }
    })

   

   
</script>
</body>
</html>
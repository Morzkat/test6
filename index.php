<?php

$conn = new mysqli("localhost","root","123",'tarea6');

$conn->connect_errno ? die('Error al conectar') : null;

if ($_POST)
{

  $cedula = $_POST['cedula'];
  $name = $_POST['name'];
  $last_N = $_POST['last_N'];
  $email = $_POST['email'];
  $tel = $_POST['tel'];
  $coment = $_POST['comment'];
  $lat = $_POST['lat'];
  $lenght = $_POST['lenght'];
  $ip = $_SERVER['SERVER_ADDR'];

  $sql = "INSERT INTO people (cedula, name, last_Name, email, tel, comment, latitude,lenght,IP)
  VALUES
  ('$cedula','$name','$last_N', '$email', '$tel', '$coment','$lat','$lenght','$ip')";
if (  $conn->query($sql))
{
  echo "<h3> Registrado </h3>";
}

else
{
  echo "<h3> Error al registrar </h3>";
}
}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tarea 6</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">

    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.2/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <style media="screen">
      body
      {

        background-image: url("img/0.jpg");
        background-size: 100%;
      }
    </style>
  </head>
  <body>

<form class="" action="index.php" method="post" style="float:left">
  <h4>Cedula</h4>
  <input type="number" name="cedula" value="">

  <h4>Nombre</h4>
  <input type="text" name="name" value="">

  <h4>Apellido</h4>
  <input type="text" name="last_N" value="">

  <h4>Email</h4>
  <input type="email" name="email" value="">

  <h4>Telefono</h4>
  <input type="text" name="tel" value="">

  <input type="hidden" name="lat" id = "lat" value="" readonly>

  <input type="hidden" name="lenght" id = "lenght" value="" readonly>

  <h4>Comentario</h4>
  <textarea name="comment" rows="8" cols="80"></textarea>

  <input type="submit" name="" value="Enviar">
</form>

<div id="map" style="width:30%;height:400px;"></div>



<script type="text/javascript">

var lng;
var lat;

if (navigator.geolocation)
{
    navigator.geolocation.getCurrentPosition(
      function (position)
      {
        lat = position.coords.latitude;
        lng =  position.coords.longitude;

        document.getElementById("lat").value = lat;
        document.getElementById("lenght").value = lng;

      });
}

function initMap()
{
  lat = document.getElementById("lat").value;
  lng = document.getElementById("lenght").value ;
  var latLng = {lat: 18.5390528, lng: -69.865022};

  var map = new google.maps.Map(document.getElementById('map'), {
    zoom: 4,
    center: latLng
  });

  <?php

   $sql = $conn->query("SELECT * FROM people ORDER BY id DESC");


   while ($row = mysqli_fetch_object($sql))
   {
     $data[] = $row;
   }
   foreach ($data as $key)
   {
     echo "  var latLng = {lat: {$key->latitude}, lng: {$key->lenght}};
     var marker = new google.maps.Marker({
         position: latLng,
         map: map
       });";
   }
  ?>

}

</script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAjxYHCPX_hReHZ0B0iFIbL1y8rpdTIu_4&callback=initMap"
 type="text/javascript"></script>

  </body>
</html>

<?php
$db_host = 'localhost';
    $db_username = 'root';
    $db_password = 'root';
    $db_name = 'printful_uzd';
    $table='uzdevumi';
    $connection= mysqli_connect( $db_host, $db_username, $db_password, $db_name);
if(!$connection)
    {
    die("Servera, kļūda, lūdzu mēģiniet vēlāk:".mysqli_connect_error());
    }
?>
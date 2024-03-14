<?php
$dbConn = pg_connect("host=postgres dbname=".getenv('POSTGRES_DB')." user=".getenv('POSTGRES_USER')." password=".getenv('POSTGRES_PASSWORD'));
// ... le reste de votre code
?>

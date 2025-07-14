<?php
$con = pg_connect("host=localhost dbname=agmsdb user=postgres password=9011sumit");

if (!$con) {
    echo "Connection Failed: " . pg_last_error();
}
?>

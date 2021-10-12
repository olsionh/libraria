<?php


      $connection = new mysqli("localhost","root","","librarionline");
      if ($connection->connect_error) {
          die("Connection failed: ".$connection->connect_error);
      }

?>

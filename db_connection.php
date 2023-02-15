<?php

    $con = new mysqli("localhost","wp_user","TurkusoSosna01!","dfilmut");

// Check connection
if ($con -> connect_errno) {
  echo "Failed to connect to MySQL: " . $con -> connect_error;
  exit();
} else {

}

?>
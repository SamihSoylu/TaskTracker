<?php
  /**
  *
  *   @author Samih Soylu
  *
  **/
# Link up with separate database
$conn = new mysqli($config['db']['host'], $config['db']['username'], $config['db']['password'], $config['db']['database']);


if ($conn->connect_errno) {
    printf("Connect failed: %s\n", $conn->connect_error);

    $file_name = 'db';
    $the_error = $conn->connect_error;
    //e_log($the_error, $file_name);

    exit();
}

$GLOBALS['mysqli'] = $conn;

?>
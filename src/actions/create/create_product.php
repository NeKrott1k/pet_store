<?php

$product = $_POST["a"];
echo(json_encode(["message"=>$product]));
?>
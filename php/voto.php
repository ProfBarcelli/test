<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");

if($_SERVER["REQUEST_METHOD"]!="POST") {
    echo "Errore";
    exit;
}
$obj = json_decode(file_get_contents("php://input"), true);

$what=$obj["what"];
$who = $obj["docente"];
if($what=="favorvole" || $what=="contrario" || $what=="astenuto") {
    file_put_contents("voto.txt",$who.",".$what."\n",FILE_APPEND);
    echo "Voto inviato";
} else {
    echo "Errore";
}
?>
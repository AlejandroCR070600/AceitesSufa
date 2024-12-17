<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = intval($_POST['buscar']);
    echo "$id";
}

?>

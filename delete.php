<?php
if($_SERVER["REQUEST_METHOD"]=="POST"){
    $filedeletepath = $_SERVER['DOCUMENT_ROOT'] . '/images/' . $_POST['Image'];
    unlink($filedeletepath);

    include "connection_database.php";
    $sql = "DELETE FROM `news` WHERE `news`.`Id` = ?";
    $conn->prepare($sql)->execute([$_POST['Id']]);
}
?>

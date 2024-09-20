<?php

require_once "includes/conn.php";
require_once "includes/helpers.php";
require_once "includes/logged.php";

if (isset($_GET['id'])) {

    $sql = "DELETE FROM `testimonials` WHERE id = ?";
    $stmt = $conn->prepare($sql);

    $id = $_GET['id'];

    $stmt->execute([$id]);
}

header('Location: testimonials.php');
die();

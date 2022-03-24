<?php
include "partials/header.php";
require "users/users.php";

$user = [
    'id' => '',
    'name' => '',
    'username' => '',
    'email' => '',
    'phone' => '',
    'website' => ''
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = createUser($_POST);

    uploadImage($_FILES['picture'], $user);

    header("Location: index.php");
}

include '_form.php';
include 'partials/footer.php';
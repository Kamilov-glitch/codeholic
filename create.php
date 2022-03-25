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

$errors=[
    'name' => "",
    'username' => "",
    'email' => "",
    'phone' => "",
    'website' => "",
];

$isValid = true;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = array_merge($user, $_POST);

    $isValid = validateUser($_POST, $errors)[0];
    $errors = validateUser($_POST, $errors)[1];

    if ($isValid) {

        $user = createUser($_POST);

        uploadImage($_FILES['picture'], $user);

        header("Location: index.php");
    }
}

include '_form.php';
include 'partials/footer.php';
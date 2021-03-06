<?php
include "partials/header.php";
require "users/users.php";

if (!isset($_GET['id'])) {
    include "partials/not_found.php";
    exit;
}
$userId = $_GET['id'];

$user = getUserById($userId);
if (!$user) {
    include "partials/not_found.php";
    exit;
}

$errors=[
    'name' => "",
    'username' => "",
    'email' => "",
    'phone' => "",
    'website' => "",
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $isValid = validateUser($_POST, $errors)[0];
    $errors = validateUser($_POST, $errors)[1];
    if ($isValid) {
        $user = updateUser($_POST, $userId);
        uploadImage($_FILES['picture'], $user);
        header("Location: index.php");
    }
}


?>

<?php include '_form.php' ?>

<?php include 'partials/footer.php' ?>



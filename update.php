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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = updateUser($_POST, $userId);

    if (isset($_FILES['picture'])) {
        if (!is_dir(__DIR__ . "/users/images")) {
            mkdir(__DIR__ . "/users/images");
        }
        $fileName = $_FILES['picture']['name'];
        $dotPosition = strpos($fileName, ".");
        $extension = substr($fileName, $dotPosition + 1);
        move_uploaded_file($_FILES['picture']['tmp_name'], __DIR__ . "/users/images/$userId.$extension");
        $user['extension'] = $extension;
        updateUser($user, $userId);
    }


    header("Location: index.php");
}


?>
<div class="container">
    <div class="card">
        <div class="card-header">
            <h3>Update user: <b><?php echo $user['name'] ?></b></h3>
        </div>
        <div class="card-body">
            <form method="POST" enctype="multipart/form-data"
                  action="">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input name="name" value="<?php echo $user['name']?>" class="form-control">
                </div>
                <div class="form-group">
                    <label for="username">Username</label>
                    <input name="username" value="<?php echo $user['username']?>" class="form-control">
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input name="email" value="<?php echo $user['email']?>" class="form-control">
                </div>
                <div class="form-group">
                    <label for="phone">Phone</label>
                    <input name="phone" value="<?php echo $user['phone']?>" class="form-control">
                </div>
                <div class="form-group">
                    <label for="website">Website</label>
                    <input name="website" value="<?php echo $user['website']?>" class="form-control">
                </div>
                <div class="form-group">
                    <label for="picture">Image</label>
                    <input name="picture" type="file" class="form-control-file">
                </div>

                <button class="btn btn-success">Submit</button>
            </form>
        </div>
    </div>
</div>


<?php include 'partials/footer.php' ?>



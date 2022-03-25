<?php

function getUsers() {
    return json_decode(file_get_contents("users/users.json"), true);
}

function getUserById($id) {
    $users = getUsers();
    foreach ($users as $user) {
        if ($user['id'] == $id) {
            return $user;
        }
    }
    return null;
}

function createUser($data) {
    $users = getUsers();

    $data['id'] = rand(1000000, 2000000);

    $users[] = $data;
    putJson($users);
    return $data;
}

function updateUser($data, $id) {
    $updateUser = [];
    $users = getUsers();
    foreach ($users as $i=>$user) {
        if ($user['id'] == $id) {
            $users[$i] = $updateUser = array_merge($user, $data); // read more in this part
        }
    }
    putJson($users);
    return $updateUser;
}

function deleteUser($id) {
    $users = getUsers();
    foreach ($users as $i => $user) {
        if ($user['id'] == $id) {
            array_splice($users, $i, 1);
        }
    }
    putJson($users);
}

function uploadImage($file, $user) {

    if (isset($_FILES['picture']) && $_FILES['picture']['name']) {
        if (!is_dir(__DIR__ . "/images")) {
            mkdir(__DIR__ . "/images");
        }
        $fileName = $file['name'];
        $dotPosition = strpos($fileName, ".");
        $extension = substr($fileName, $dotPosition + 1);
        move_uploaded_file($file['tmp_name'], __DIR__ . "/images/${user['id']}.$extension");
        $user['extension'] = $extension;
        updateUser($user, $user['id']);
    }
}

function putJson($users) {
    file_put_contents(__DIR__ . '/users.json', json_encode($users, JSON_PRETTY_PRINT));
}

function validateUser($post, $errors) {
    $name = $post['name'];
    $username = $post['username'];
    $email = $post['email'];
    $phone = $post['phone'];
    $website = $post['website'];
    $isValid = true;
    if (!$name) {
        $isValid = false;
        $errors['name'] = "Name is mandatory";
    }
    if (!$username || strlen($username) < 6 || strlen($username) > 16) {
        $isValid = false;
        $errors['username'] = "Username is required and it must be more than 6 and less than 16 characters";
    }

    if (!$email && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $isValid = false;
        $errors['email'] = "Email address is not valid";
    }

    if (!filter_var($phone, FILTER_VALIDATE_INT)) {
        $isValid = false;
        $errors['phone'] = "This must be a valid phone number";
    }

    if (!filter_var($website, FILTER_VALIDATE_DOMAIN)) {
        $isValid = false;
        $errors['website'] = "This must be a valid website";
    }
    return [$isValid, $errors];
}
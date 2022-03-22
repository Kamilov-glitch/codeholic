<?php

function getUsers() {
    return json_decode(file_get_contents("users.json"), true);
}

function getUserById($id) {

}

function createUser($data) {

}

function updateUser($data, $id) {
    
}

function deleteUser($id) {

}
<?php
function registerUser($username, $email, $password, $role) {
    global $conn;

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $username, $email, $hashed_password, $role);

    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
}

function loginUser($username, $password) {
    global $conn;

    $stmt = $conn->prepare("SELECT id, username, password, role FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            return true;
        }
    }
    return false;
}

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function isArtist() {
    return isLoggedIn() && $_SESSION['role'] === 'artist';
}

function isBuyer() {
    return isLoggedIn() && $_SESSION['role'] === 'buyer';
}

function redirectIfNotLoggedIn() {
    if (!isLoggedIn()) {
        header("Location: login.php");
        exit();
    }
}

function redirectIfNotArtist() {
    redirectIfNotLoggedIn();
    if (!isArtist()) {
        header("Location: index.php");
        exit();
    }
}

function redirectIfNotBuyer() {
    redirectIfNotLoggedIn();
    if (!isBuyer()) {
        header("Location: index.php");
        exit();
    }
}
?>
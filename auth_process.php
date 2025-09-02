<?php
session_start();
require_once 'config.php';

if (isset($_POST['register_btn'])) { 
    $name = $_POST['name']; 
    $email = $_POST['email']; 
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $check_email = $conn->query("SELECT email FROM users WHERE email = '$email'");
    if ($check_email->num_rows > 0) {
        $_SESSION['alerts'][] = [
            'type' => 'error', 
            'message' => 'Email đã tồn tại!' 
        ];
        $_SESSION['active_form'] = 'register';
    } else {
        $conn->query("INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$password')"); 
        $_SESSION['alerts'][] = [
            'type' => 'success', 
            'message' => 'Đăng ký thành công' 
        ];
        $_SESSION['active_form'] = 'login';
    }

    header('Location: index.php');
    exit();
}

if (isset($_POST['login_btn'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $result = $conn->query("SELECT * FROM users WHERE email = '$email'");
    $user = $result->num_rows > 0 ? $result->fetch_assoc() : null;

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['name'] = $user['name'];
        $_SESSION['alerts'][] = [
            'type' => 'success',
            'message' => 'Đăng nhập thành công'
        ];
    } else {
        $_SESSION['alerts'][] = [
            'type' => 'error',
            'message' => 'Sai email hoặc mật khẩu'
        ];
        $_SESSION['active_form'] = 'login';
    }

    header('Location: index.php');
    exit();
}
?>
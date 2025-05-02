<?php
include_once '../utils/auth.php';
include_once '../utils/jwt.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if (authenticate($username, $password)) {
        $token = generate_jwt(['user' => $username]);
        setcookie('token', $token, time() + 3600, '/');
        header('Location: ../private/index.php');
        exit;
    } else {
        $error = "Đăng nhập thất bại!";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Trang Đăng Nhập</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <h1>Đăng Nhập</h1>
    <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
    <form method="POST">
        <label>Tên người dùng: <input type="text" name="username"></label><br>
        <label>Mật khẩu: <input type="password" name="password"></label><br>
        <button type="submit">Đăng Nhập</button>
    </form>
</body>
</html>

<?php
function authenticate($username, $password) {
    // Giả lập xác thực người dùng
    return $username === 'admin' && $password === 'password123';
}
?>

<?php
function generate_jwt($payload) {
    // Giả lập tạo JWT
    return base64_encode(json_encode($payload));
}

function validate_jwt($token) {
    // Giả lập xác thực JWT
    $payload = json_decode(base64_decode($token), true);
    return isset($payload['user']);
}
?>

<?php
if ($_SERVER['HTTP_X_ADMIN'] === 'true') {
    echo "Flag: " . file_get_contents('../flags/admin_header_bypass.txt');
} else {
    http_response_code(403);
    echo "Truy cập bị từ chối.";
}
?>

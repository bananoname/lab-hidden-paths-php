<?php
if ($_GET['debug'] === '1') {
    echo "Flag: " . file_get_contents('../flags/found_secret_console.txt');
} else {
    echo "Không có gì ở đây.";
}
?>

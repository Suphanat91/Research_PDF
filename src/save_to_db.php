<?php
file_put_contents('debug.log', date('Y-m-d H:i:s') . " - Method: " . $_SERVER['REQUEST_METHOD'] . "\n", FILE_APPEND);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    file_put_contents('debug.log', print_r($_POST, true), FILE_APPEND);
    echo json_encode(['success' => true, 'message' => 'Data received']);
} else {
    file_put_contents('debug.log', "Invalid request method\n", FILE_APPEND);
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
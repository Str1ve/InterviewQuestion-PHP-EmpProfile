<?php
header('Content-Type: application/json');

$file = '../data/employees.json';

if (file_exists($file)) {
    $json = file_get_contents($file);
    $data = json_decode($json, true);
    echo json_encode($data);
} else {
    echo json_encode([]);
}
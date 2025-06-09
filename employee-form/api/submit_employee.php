<?php
header("Content-Type: application/json");

// Helper function for sanitization
function sanitize($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

// Validate and collect input
$fields = [
    'name', 'gender', 'marital_status', 'phone', 'email',
    'address', 'dob', 'nationality', 'hire_date', 'department'
];

$data = [];
$errors = [];

foreach ($fields as $field) {
    if (empty($_POST[$field])) {
        $errors[] = "Field '$field' is required.";
    } else {
        $data[$field] = sanitize($_POST[$field]);
    }
}

// Specific validations
if (!preg_match('/^\d{10}$/', $data['phone'])) {
    $errors[] = "Phone number must be 10 digits.";
}

if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Invalid email format.";
}

if (!empty($errors)) {
    echo json_encode(['success' => false, 'message' => implode(' ', $errors)]);
    exit;
}

// Store in JSON file
$file = '../data/employees.json';
$employees = [];

if (file_exists($file)) {
    $json = file_get_contents($file);
    $employees = json_decode($json, true);
}

$employees[] = $data;
file_put_contents($file, json_encode($employees, JSON_PRETTY_PRINT));

echo json_encode(['success' => true, 'message' => 'Employee added successfully.']);
?>
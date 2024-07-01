<?php
require_once 'config.php'; 

function insert_admin_if_not_exists($pdo) {
    $adminEmail = 'thomas.n@compfest.id';
    $adminPassword = password_hash('Admin123', PASSWORD_DEFAULT);
    $adminFullName = 'Thomas N';

    // Cek apakah admin sudah ada
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$adminEmail]);
    $admin = $stmt->fetch();

    if (!$admin) {
        // Jika admin belum ada, masukkan ke database
        $stmt = $pdo->prepare("INSERT INTO users (full_name, email, phone_number, password, role) VALUES (?, ?, ?, ?, 'Admin')");
        $stmt->execute([$adminFullName, $adminEmail, '08123456789', $adminPassword]);
    }
}

// Panggil fungsi untuk memastikan admin ada di database
insert_admin_if_not_exists($pdo);
?>

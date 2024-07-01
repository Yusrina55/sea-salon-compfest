<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

require '../config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $star_rating = $_POST['star_rating'];
    $comment = $_POST['comment'];

    $query = "INSERT INTO reviews (user_id, star_rating, comment) VALUES (?, ?, ?)";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$user_id, $star_rating, $comment]);

    // Redirect to dashboard with success message
    header('Location: dashboard_customer.php?review_success=1');
    exit;
}
?>

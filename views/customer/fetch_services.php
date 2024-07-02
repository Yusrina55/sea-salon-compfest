<?php
require '../config.php';

if (isset($_GET['branch_id'])) {
    $branch_id = $_GET['branch_id'];
    $services_query = "SELECT id, name FROM services WHERE branch_id = ?";
    $stmt = $pdo->prepare($services_query);
    $stmt->execute([$branch_id]);
    $services = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($services);
}
?>

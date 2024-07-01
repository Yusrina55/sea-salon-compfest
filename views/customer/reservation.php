<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require '../config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $service_id = $_POST['service_id'];
    $reservation_date = $_POST['reservation_date'];
    $user_id = $_SESSION['user_id'];

    $reservation_query = "INSERT INTO reservations (user_id, service_id, reservation_date) 
                          VALUES (:user_id, :service_id, :reservation_date)";
    $stmt = $pdo->prepare($reservation_query);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->bindParam(':service_id', $service_id, PDO::PARAM_INT);
    $stmt->bindParam(':reservation_date', $reservation_date, PDO::PARAM_STR);

    if ($stmt->execute()) {
        echo "Reservation made successfully.";
    } else {
        echo "Error: " . $reservation_query . "<br>" . $pdo->errorInfo()[2];
    }
}

// Fetch available services
$services_query = "SELECT * FROM services";
$services = $pdo->query($services_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <title>Make a Reservation</title>
</head>
<body>
    <div class="container mx-auto mt-10">
        <h1 class="text-3xl font-bold mb-5">Make a Reservation</h1>
        <form method="POST" action="">
            <select name="service_id" class="border p-2 w-full mb-4">
                <?php while ($row = $services->fetch(PDO::FETCH_ASSOC)): ?>
                    <option value="<?php echo htmlspecialchars($row['id']); ?>"><?php echo htmlspecialchars($row['name']); ?></option>
                <?php endwhile; ?>
            </select>
            <input type="datetime-local" name="reservation_date" class="border p-2 w-full mb-4" required>
            <button type="submit" class="bg-blue-500 text-white py-2 px-4">Make Reservation</button>
        </form>
    </div>
</body>
</html>

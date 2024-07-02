<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require '../config.php';

// Fetch branches
$branches_query = "SELECT * FROM branches";
$branches = $pdo->query($branches_query)->fetchAll();

// Fetch services based on selected branch (handled by JavaScript)
$services = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $phone_number = $_POST['phone_number'];
    $service_id = $_POST['service_id'];
    $reservation_date = $_POST['reservation_date'];
    $branch_id = $_POST['branch_id'];
    $user_id = $_SESSION['user_id'];

    $reservation_query = "INSERT INTO reservations (user_id, service_id, reservation_date, phone_number, branch_id) 
                          VALUES (?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($reservation_query);
    if ($stmt->execute([$user_id, $service_id, $reservation_date, $phone_number, $branch_id])) {
        echo "<script>alert('Reservation made successfully.'); window.location.href='dashboard_customer.php';</script>";
    } else {
        echo "Error: " . $stmt->errorInfo()[2];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <title>Make a Reservation</title>
    <script>
        function fetchServices(branchId) {
            fetch('fetch_services.php?branch_id=' + branchId)
                .then(response => response.json())
                .then(data => {
                    let serviceSelect = document.getElementById('service_id');
                    serviceSelect.innerHTML = '';
                    data.forEach(service => {
                        let option = document.createElement('option');
                        option.value = service.id;
                        option.textContent = service.name;
                        serviceSelect.appendChild(option);
                    });
                });
        }
    </script>
</head>
<body>
    <div class="container mx-auto mt-10">
        <h1 class="text-3xl font-bold mb-5">Make a Reservation</h1>
        <form method="POST" action="">
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                <input type="text" id="name" name="name" class="mt-1 block w-full p-2 border border-gray-300 rounded-md" required>
            </div>
            <div class="mb-4">
                <label for="phone_number" class="block text-sm font-medium text-gray-700">Active Phone Number</label>
                <input type="text" id="phone_number" name="phone_number" class="mt-1 block w-full p-2 border border-gray-300 rounded-md" required>
            </div>
            <div class="mb-4">
                <label for="branch_id" class="block text-sm font-medium text-gray-700">Select Branch</label>
                <select id="branch_id" name="branch_id" class="mt-1 block w-full p-2 border border-gray-300 rounded-md" onchange="fetchServices(this.value)" required>
                    <option value="">Select Branch</option>
                    <?php foreach ($branches as $branch): ?>
                        <option value="<?php echo $branch['id']; ?>"><?php echo htmlspecialchars($branch['name']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-4">
                <label for="service_id" class="block text-sm font-medium text-gray-700">Type of Service</label>
                <select id="service_id" name="service_id" class="mt-1 block w-full p-2 border border-gray-300 rounded-md" required>
                    <option value="">Select Service</option>
                </select>
            </div>
            <div class="mb-4">
                <label for="reservation_date" class="block text-sm font-medium text-gray-700">Date and Time</label>
                <input type="datetime-local" id="reservation_date" name="reservation_date" class="mt-1 block w-full p-2 border border-gray-300 rounded-md" required>
            </div>
            <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded-md">Make Reservation</button>
        </form>
    </div>
</body>
</html>

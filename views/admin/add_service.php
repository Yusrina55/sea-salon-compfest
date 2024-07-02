<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'Admin') {
    header('Location: login.php');
    exit();
}

require '../config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $service_name = $_POST['service_name'];
    $branch_id = $_POST['branch_id'];
    $duration = $_POST['duration'];

    $service_query = "INSERT INTO services (name, branch_id, duration) 
                      VALUES (?, ?, ?)";
    $stmt = $pdo->prepare($service_query);
    $stmt->execute([$service_name, $branch_id, $duration]);
    
    echo "<script>alert('Service created successfully.'); window.location.href='dashboard_admin.php';</script>";
}

// Fetch branches
$branches_query = "SELECT * FROM branches";
$branches = $pdo->query($branches_query)->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <title>Create Service</title>
</head>
<body>
    <div class="container mx-auto mt-10">
        <h1 class="text-3xl font-bold mb-5">Create New Service</h1>
        <form method="POST" action="">
            <div class="mb-4">
                <label for="service_name" class="block text-sm font-medium text-gray-700">Service Name</label>
                <input type="text" id="service_name" name="service_name" class="mt-1 block w-full p-2 border border-gray-300 rounded-md" required>
            </div>
            <div class="mb-4">
                <label for="branch_id" class="block text-sm font-medium text-gray-700">Select Branch</label>
                <select id="branch_id" name="branch_id" class="mt-1 block w-full p-2 border border-gray-300 rounded-md" required>
                    <?php foreach ($branches as $branch): ?>
                        <option value="<?php echo $branch['id']; ?>"><?php echo htmlspecialchars($branch['name']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-4">
                <label for="duration" class="block text-sm font-medium text-gray-700">Service Duration (in minutes)</label>
                <input type="number" id="duration" name="duration" class="mt-1 block w-full p-2 border border-gray-300 rounded-md" required>
            </div>
            <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded-md">Create Service</button>
        </form>
    </div>
</body>
</html>

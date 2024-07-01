<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

require '../config.php';

$user_id = $_SESSION['user_id'];

// Query untuk mengambil data pengguna berdasarkan user_id
$query = "SELECT full_name FROM users WHERE id = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$user_id]);
$user = $stmt->fetch();

if (!$user) {
    die("User not found"); // Handle jika user tidak ditemukan
}

$customer_name = $user['full_name']; // Ambil nama lengkap pengguna
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Review</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mx-auto">
        <h1 class="text-2xl font-bold">Create Review</h1>
        <form action="create_review.php" method="post" class="mt-4">
            <div class="mb-4">
                <label for="customer_name" class="block text-sm font-medium text-gray-700">Customer Name</label>
                <input type="text" id="customer_name" name="customer_name" value="<?php echo htmlspecialchars($customer_name); ?>" class="mt-1 block w-full p-2 border border-gray-300 rounded-md" readonly>
            </div>
            <div class="mb-4">
                <label for="star_rating" class="block text-sm font-medium text-gray-700">Star Rating</label>
                <select id="star_rating" name="star_rating" class="mt-1 block w-full p-2 border border-gray-300 rounded-md">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </select>
            </div>
            <div class="mb-4">
                <label for="comment" class="block text-sm font-medium text-gray-700">Comment</label>
                <textarea id="comment" name="comment" rows="4" class="mt-1 block w-full p-2 border border-gray-300 rounded-md"><?php echo isset($comment) ? htmlspecialchars($comment) : ''; ?></textarea>
            </div>
            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md">Submit Review</button>
        </form>
    </div>
</body>
</html>

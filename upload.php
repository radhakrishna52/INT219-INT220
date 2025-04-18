<?php
require_once 'includes/config.php';
redirectIfNotArtist();

$error = '';
$success = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $price = floatval($_POST['price']);
    $image = $_FILES['image'];

    if (empty($title) || empty($price) || empty($image['name'])) {
        $error = 'Please fill in all required fields.';
    } elseif ($price <= 0) {
        $error = 'Price must be greater than 0.';
    } else {
        $result = uploadArtwork($title, $description, $price, $image);
        if ($result === true) {
            $success = 'Artwork uploaded successfully!';
        } else {
            $error = $result;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Artwork - Virtual Exhibition</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body class="bg-gray-100">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg">
        <div class="max-w-6xl mx-auto px-4">
            <div class="flex justify-between">
                <div class="flex space-x-7">
                    <a href="index.php" class="flex items-center py-4 px-2">
                        <span class="font-semibold text-gray-500 text-lg">Virtual Exhibition</span>
                    </a>
                </div>
                <div class="hidden md:flex items-center space-x-1">
                    <a href="index.php" class="py-4 px-2 text-gray-500 font-semibold hover:text-blue-500 transition duration-300">Home</a>
                    <a href="gallery.php" class="py-4 px-2 text-gray-500 font-semibold hover:text-blue-500 transition duration-300">Gallery</a>
                    <a href="dashboard/artist.php" class="py-4 px-2 text-gray-500 font-semibold hover:text-blue-500 transition duration-300">Dashboard</a>
                    <a href="upload.php" class="py-4 px-2 text-blue-500 border-b-4 border-blue-500 font-semibold">Upload Art</a>
                    <a href="logout.php" class="py-4 px-2 text-gray-500 font-semibold hover:text-blue-500 transition duration-300">Logout</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Upload Section -->
    <section class="container mx-auto px-6 py-10">
        <div class="max-w-3xl mx-auto bg-white rounded-lg shadow-md p-8">
            <h1 class="text-3xl font-bold text-center text-gray-800 mb-8">Upload New Artwork</h1>

            <?php if ($error): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6" role="alert">
                    <span class="block sm:inline"><?php echo $error; ?></span>
                </div>
            <?php endif; ?>

            <?php if ($success): ?>
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
                    <span class="block sm:inline"><?php echo $success; ?></span>
                </div>
            <?php endif; ?>

            <form action="upload.php" method="POST" enctype="multipart/form-data" class="space-y-6">
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Artwork Title *</label>
                    <input type="text" id="title" name="title" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                    <textarea id="description" name="description" rows="4" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                </div>

                <div>
                    <label for="price" class="block text-sm font-medium text-gray-700 mb-1">Price ($) *</label>
                    <input type="number" id="price" name="price" min="0.01" step="0.01" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label for="image" class="block text-sm font-medium text-gray-700 mb-1">Artwork Image *</label>
                    <div class="mt-1 flex items-center">
                        <label for="image" class="cursor-pointer bg-white py-2 px-3 border border-gray-300 rounded-md shadow-sm text-sm leading-4 font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Choose File
                        </label>
                        <input id="image" name="image" type="file" accept="image/*" required class="hidden">
                        <span id="file-name" class="ml-3 text-sm text-gray-500">No file chosen</span>
                    </div>
                    <p class="mt-1 text-sm text-gray-500">JPEG, PNG, or GIF (Max 5MB)</p>
                </div>

                <div class="pt-4">
                    <button type="submit" class="w-full bg-blue-600 text-white py-3 px-4 rounded-lg hover:bg-blue-700 transition duration-300 font-medium">
                        Upload Artwork
                    </button>
                </div>
            </form>
        </div>
    </section>

    <!-- Footer -->
  <footer class="bg-gray-800 text-white ">
            <div class="border-t border-gray-700 mt-6 pt-6 text-center">
                <p>@Abhay @Akansha @Radhakrishna , @Pawan</p>
            </div>
    </footer>

    <script>
        // Display selected file name
        document.getElementById('image').addEventListener('change', function(e) {
            const fileName = e.target.files[0] ? e.target.files[0].name : 'No file chosen';
            document.getElementById('file-name').textContent = fileName;
        });
    </script>
</body>
</html>
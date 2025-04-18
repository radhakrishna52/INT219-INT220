<?php
require_once 'includes/config.php';

if (!isset($_GET['id'])) {
    header("Location: gallery.php");
    exit();
}

$artwork_id = intval($_GET['id']);
$artwork = getArtworkById($artwork_id);

if (!$artwork) {
    header("Location: gallery.php");
    exit();
}

// Handle purchase
$purchase_error = '';
$purchase_success = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['purchase']) && isBuyer()) {
    if (purchaseArtwork($artwork_id, $_SESSION['user_id'], $artwork['price'])) {
        $purchase_success = 'Artwork purchased successfully! You can view it in your dashboard.';
    } else {
        $purchase_error = 'Purchase failed. Please try again.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $artwork['title']; ?> - Virtual Exhibition</title>
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
                    <?php if (isLoggedIn()): ?>
                        <a href="dashboard/<?php echo $_SESSION['role']; ?>.php" class="py-4 px-2 text-gray-500 font-semibold hover:text-blue-500 transition duration-300">Dashboard</a>
                        <?php if (isArtist()): ?>
                            <a href="upload.php" class="py-4 px-2 text-gray-500 font-semibold hover:text-blue-500 transition duration-300">Upload Art</a>
                        <?php endif; ?>
                        <a href="logout.php" class="py-4 px-2 text-gray-500 font-semibold hover:text-blue-500 transition duration-300">Logout</a>
                    <?php else: ?>
                        <a href="login.php" class="py-4 px-2 text-gray-500 font-semibold hover:text-blue-500 transition duration-300">Login</a>
                        <a href="register.php" class="py-2 px-4 bg-blue-500 text-white font-semibold rounded-lg hover:bg-blue-400 transition duration-300">Register</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <!-- Artwork Detail Section -->
    <section class="container mx-auto px-6 py-10">
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="md:flex">
                <div class="md:w-1/2">
                    <img src="<?php echo $artwork['image_path']; ?>" alt="<?php echo $artwork['title']; ?>" class="w-full h-full object-cover">
                </div>
                <div class="p-8 md:w-1/2">
                    <h1 class="text-3xl font-bold text-gray-800 mb-2"><?php echo $artwork['title']; ?></h1>
                    <p class="text-gray-600 mb-4">By <?php echo $artwork['artist_name']; ?></p>
                    <p class="text-2xl font-semibold text-blue-600 mb-6">$<?php echo number_format($artwork['price'], 2); ?></p>

                    <div class="mb-6">
                        <h2 class="text-xl font-semibold text-gray-800 mb-2">Description</h2>
                        <p class="text-gray-700"><?php echo $artwork['description'] ?: 'No description provided.'; ?></p>
                    </div>

                    <div class="mb-6">
                        <h2 class="text-xl font-semibold text-gray-800 mb-2">Details</h2>
                        <ul class="text-gray-700">
                            <li class="mb-1"><span class="font-medium">Uploaded:</span> <?php echo date('F j, Y', strtotime($artwork['created_at'])); ?></li>
                            <li class="mb-1"><span class="font-medium">Artist:</span> <?php echo $artwork['artist_name']; ?></li>
                            <li class="mb-1"><span class="font-medium">Price:</span> $<?php echo number_format($artwork['price'], 2); ?></li>
                        </ul>
                    </div>

                    <?php if ($purchase_error): ?>
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline"><?php echo $purchase_error; ?></span>
                        </div>
                    <?php endif; ?>

                    <?php if ($purchase_success): ?>
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline"><?php echo $purchase_success; ?></span>
                        </div>
                    <?php endif; ?>

                    <?php if (isBuyer()): ?>
                        <form method="POST" action="artwork.php?id=<?php echo $artwork_id; ?>">
                            <button type="submit" name="purchase" class="w-full bg-blue-600 text-white py-3 px-4 rounded-lg hover:bg-blue-700 transition duration-300 font-medium">
                                Purchase This Artwork
                            </button>
                        </form>
                    <?php elseif (!isLoggedIn()): ?>
                        <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded relative" role="alert">
                            <span class="block sm:inline">You need to <a href="login.php" class="text-blue-600 hover:underline">login</a> as a buyer to purchase this artwork.</span>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

  <footer class="bg-gray-800 text-white ">
            <div class="border-t border-gray-700 mt-6 pt-6 text-center">
                <p>@Abhay @Akansha @Radhakrishna , @Pawan</p>
            </div>
    </footer>
</body>
</html>
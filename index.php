<?php require_once 'includes/config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Virtual Art Exhibition</title>
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

    <!-- Hero Section -->
    <div class="pt-1 relative">
      <video autoplay muted loop class="w-full h-[100vh] object-cover">
      <source src="assets/videos/backgroundvideo.mp4" type="video/mp4">
    </video>
          <div class="absolute inset-0 flex items-center justify-center z-10 bg-black bg-opacity-40">
    <div class="text-center text-white">
      <h1 class="text-4xl md:text-6xl font-bold mb-4">Welcome to the Virtual Exhibition</h1>
      <p class="text-lg md:text-2xl">Experience art like never before</p>
    </div>
  </div>
    </div>

    <!-- Featured Artworks -->
    <section class="container mx-auto px-6 py-10">
        <h2 class="text-3xl font-bold text-center text-gray-800 mb-8">Featured Artworks</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <?php
            $artworks = getAllArtworks();
            $featured = array_slice($artworks, 0, 3);
            foreach ($featured as $art): ?>
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <img src="<?php echo $art['image_path']; ?>" alt="<?php echo $art['title']; ?>" class="w-full h-64 object-cover">
                <div class="p-4">
                    <h3 class="font-bold text-xl mb-2"><?php echo $art['title']; ?></h3>
                    <p class="text-gray-700 mb-2">By <?php echo $art['artist_name']; ?></p>
                    <p class="text-gray-700 mb-4">$<?php echo number_format($art['price'], 2); ?></p>
                    <a href="artwork.php?id=<?php echo $art['id']; ?>" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition duration-300">View Details</a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white ">
            <div class="border-t border-gray-700 mt-6 pt-6 text-center">
                <p>@Abhay @Akansha @Radhakrishna , @Pawan</p>
            </div>
    </footer>
</body>
</html>
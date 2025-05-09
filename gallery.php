<?php require_once 'includes/config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gallery - Virtual Exhibition</title>
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
                    <a href="gallery.php" class="py-4 px-2 text-blue-500 border-b-4 border-blue-500 font-semibold">Gallery</a>
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

    <!-- Gallery Section -->
    <section class="container mx-auto px-6 py-10">
        <h1 class="text-3xl font-bold text-center text-gray-800 mb-8">Art Gallery</h1>

        <!-- Search and Filter -->
        <div class="mb-8 flex flex-col md:flex-row justify-between items-center">
            <div class="w-full md:w-1/3 mb-4 md:mb-0">
                <input type="text" id="search" placeholder="Search artworks..." class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="flex space-x-4">
                <select id="sort" class="px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="newest">Newest First</option>
                    <option value="oldest">Oldest First</option>
                    <option value="price-high">Price: High to Low</option>
                    <option value="price-low">Price: Low to High</option>
                </select>
                <button id="filter-btn" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition duration-300">Apply</button>
            </div>
        </div>

        <!-- Artworks Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6" id="artworks-grid">
            <?php
            $artworks = getAllArtworks();
            foreach ($artworks as $art): ?>
            <div class="bg-white rounded-lg shadow-md overflow-hidden artwork-item" data-title="<?php echo strtolower($art['title']); ?>" data-date="<?php echo strtotime($art['created_at']); ?>" data-price="<?php echo $art['price']; ?>">
                <img src="<?php echo $art['image_path']; ?>" alt="<?php echo $art['title']; ?>" class="w-full h-64 object-cover">
                <div class="p-4">
                    <h3 class="font-bold text-xl mb-2"><?php echo $art['title']; ?></h3>
                    <p class="text-gray-700 mb-2">By <?php echo $art['artist_name']; ?></p>
                    <p class="text-gray-700 mb-4">$<?php echo number_format($art['price'], 2); ?></p>
                    <a href="artwork.php?id=<?php echo $art['id']; ?>" class="block text-center bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition duration-300">View Details</a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <!-- No Results Message (hidden by default) -->
        <div id="no-results" class="hidden text-center py-10">
            <h3 class="text-xl font-semibold text-gray-600">No artworks found matching your criteria.</h3>
            <p class="text-gray-500 mt-2">Try adjusting your search or filter.</p>
        </div>
    </section>

  <footer class="bg-gray-800 text-white ">
            <div class="border-t border-gray-700 mt-6 pt-6 text-center">
                <p>@Abhay @Akansha @Radhakrishna , @Pawan</p>
            </div>
    </footer>

    <script src="assets/js/main.js"></script>
</body>
</html>
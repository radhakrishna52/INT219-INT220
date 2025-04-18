<?php
require_once '../includes/config.php';
redirectIfNotBuyer();

$purchases = getBuyerPurchases($_SESSION['user_id']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buyer Dashboard - Virtual Exhibition</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body class="bg-gray-100">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg">
        <div class="max-w-6xl mx-auto px-4">
            <div class="flex justify-between">
                <div class="flex space-x-7">
                    <a href="../index.php" class="flex items-center py-4 px-2">
                        <span class="font-semibold text-gray-500 text-lg">Virtual Exhibition</span>
                    </a>
                </div>
                <div class="hidden md:flex items-center space-x-1">
                    <a href="../index.php" class="py-4 px-2 text-gray-500 font-semibold hover:text-blue-500 transition duration-300">Home</a>
                    <a href="../gallery.php" class="py-4 px-2 text-gray-500 font-semibold hover:text-blue-500 transition duration-300">Gallery</a>
                    <a href="buyer.php" class="py-4 px-2 text-blue-500 border-b-4 border-blue-500 font-semibold">Dashboard</a>
                    <a href="../logout.php" class="py-4 px-2 text-gray-500 font-semibold hover:text-blue-500 transition duration-300">Logout</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Dashboard Section -->
    <section class="container mx-auto px-6 py-10">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800">Buyer Dashboard</h1>
            <p class="text-gray-600">Welcome back, <?php echo $_SESSION['username']; ?>!</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h3 class="text-lg font-semibold text-gray-800 mb-2">Total Purchases</h3>
                <p class="text-3xl font-bold text-blue-600"><?php echo count($purchases); ?></p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h3 class="text-lg font-semibold text-gray-800 mb-2">Total Spent</h3>
                <p class="text-3xl font-bold text-blue-600">
                    $<?php
                    $total = 0;
                    foreach ($purchases as $purchase) {
                        $total += $purchase['amount'];
                    }
                    echo number_format($total, 2);
                    ?>
                </p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h3 class="text-lg font-semibold text-gray-800 mb-2">Favorite Artist</h3>
                <p class="text-3xl font-bold text-blue-600">Coming Soon</p>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-800">Your Purchases</h2>
            </div>

            <?php if (empty($purchases)): ?>
                <div class="p-6 text-center">
                    <p class="text-gray-600">You haven't purchased any artworks yet.</p>
                    <a href="../gallery.php" class="mt-4 inline-block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition duration-300">Browse Gallery</a>
                </div>
            <?php else: ?>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Artwork</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Artist</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Purchase Date</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php foreach ($purchases as $purchase): ?>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <img src="<?php echo $purchase['image_path']; ?>" alt="<?php echo $purchase['title']; ?>" class="h-10 w-10 rounded-full object-cover">
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900"><?php echo $purchase['title']; ?></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900"><?php echo $purchase['artist_name']; ?></div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">$<?php echo number_format($purchase['amount'], 2); ?></div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-500"><?php echo date('M j, Y', strtotime($purchase['purchase_date'])); ?></div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="../artwork.php?id=<?php echo $purchase['artwork_id']; ?>" class="text-blue-600 hover:text-blue-900">View</a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
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
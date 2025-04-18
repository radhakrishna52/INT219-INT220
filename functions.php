<?php
function getAllArtworks() {
    global $conn;
    $sql = "SELECT a.*, u.username as artist_name FROM artworks a JOIN users u ON a.artist_id = u.id";
    $result = $conn->query($sql);
    return $result->fetch_all(MYSQLI_ASSOC);
}

function getArtworkById($id) {
    global $conn;
    $stmt = $conn->prepare("SELECT a.*, u.username as artist_name FROM artworks a JOIN users u ON a.artist_id = u.id WHERE a.id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

function getArtistArtworks($artist_id) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM artworks WHERE artist_id = ?");
    $stmt->bind_param("i", $artist_id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}

function getBuyerPurchases($buyer_id) {
    global $conn;
    $stmt = $conn->prepare("SELECT p.*, a.title, a.image_path, u.username as artist_name
                           FROM purchases p
                           JOIN artworks a ON p.artwork_id = a.id
                           JOIN users u ON a.artist_id = u.id
                           WHERE p.buyer_id = ?");
    $stmt->bind_param("i", $buyer_id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}

function uploadArtwork($title, $description, $price, $image) {
    global $conn;

    // Handle file upload
    $target_dir = UPLOAD_DIR;
    $target_file = $target_dir . basename($image["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if image file is a actual image
    $check = getimagesize($image["tmp_name"]);
    if($check === false) {
        return "File is not an image.";
    }

    // Check file size (5MB max)
    if ($image["size"] > 5000000) {
        return "Sorry, your file is too large.";
    }

    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
        return "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    }

    // Generate unique filename
    $new_filename = uniqid() . '.' . $imageFileType;
    $target_path = $target_dir . $new_filename;

    if (move_uploaded_file($image["tmp_name"], $target_path)) {
        // Insert into database
        $stmt = $conn->prepare("INSERT INTO artworks (title, description, artist_id, price, image_path) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssids", $title, $description, $_SESSION['user_id'], $price, $target_path);

        if ($stmt->execute()) {
            return true;
        } else {
            return "Database error: " . $conn->error;
        }
    } else {
        return "Sorry, there was an error uploading your file.";
    }
}

function purchaseArtwork($artwork_id, $buyer_id, $amount) {
    global $conn;

    $stmt = $conn->prepare("INSERT INTO purchases (artwork_id, buyer_id, amount) VALUES (?, ?, ?)");
    $stmt->bind_param("iid", $artwork_id, $buyer_id, $amount);

    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
}
?>
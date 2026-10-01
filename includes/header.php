<?php
// Database connection (Apne actual database details ke sath update karein)
$conn = new mysqli("localhost", "root", "", "bhagirath");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$current_page = basename($_SERVER['PHP_SELF']);

$meta_query = "SELECT meta_title, meta_key, meta_desc FROM meta WHERE page_url = '$current_page' LIMIT 1";
$meta_result = $conn->query($meta_query);
$meta_data = $meta_result->fetch_assoc();

$schema_query = "SELECT schema_markup FROM page_schemas WHERE page_url = '$current_page' LIMIT 1";
$schema_result = $conn->query($schema_query);
$schema_data = $schema_result->fetch_assoc();

$logo_query = "SELECT logo_path FROM logos WHERE location = 'header' AND is_active = 1 ORDER BY uploaded_at DESC LIMIT 1";
$logo_result = $conn->query($logo_query);
$logo_data = $logo_result->fetch_assoc();
$logo_path = $logo_data ? $logo_data['logo_path'] : 'default-logo.png';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title><?php echo $meta_data['meta_title'] ?? 'Premium Gym & Fitness'; ?></title>
    <meta name="description" content="<?php echo $meta_data['meta_desc'] ?? ''; ?>">
    <meta name="keywords" content="<?php echo $meta_data['meta_key'] ?? ''; ?>">
    
    <?php if(!empty($schema_data['schema_markup'])): ?>
        <?php echo $schema_data['schema_markup']; ?>
    <?php endif; ?>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

<header class="main-header">
    <nav class="navbar">
        <!-- Dynamic Logo -->
        <a href="index.php" class="logo">
            <img src="admin/uploads/<?php echo htmlspecialchars($logo_path); ?>" alt="Premium Gym Logo">
        </a>

        <!-- Navigation Links -->
        <ul class="nav-links" id="nav-links">
            <li><a href="index.php">Home</a></li>
            <li><a href="about.php">About Us</a></li>
            <li><a href="classes.php">Classes</a></li>
            <li><a href="trainers.php">Trainers</a></li>
            <li><a href="contact.php">Contact</a></li>
        </ul>

        <!-- Call to Action -->
        <a href="join.php" class="btn-join">Join Now</a>

        <!-- Mobile Hamburger Menu -->
        <div class="menu-toggle" onclick="toggleMenu()">
            <i class="fas fa-bars"></i>
        </div>
    </nav>
</header>

<script>
    function toggleMenu() {
        document.getElementById('nav-links').classList.toggle('active');
    }
</script>
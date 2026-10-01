<?php
include 'config/connect.php';
$current_page = basename($_SERVER['PHP_SELF']);
if (empty($current_page)) {
    $current_page = 'index.php'; 
}

$meta_query = "SELECT meta_title, meta_key, meta_desc FROM meta WHERE page_url = '$current_page' LIMIT 1";
$meta_result = $conn->query($meta_query);
$meta_data = ($meta_result && $meta_result->num_rows > 0) ? $meta_result->fetch_assoc() : [];

$schema_query = "SELECT schema_markup FROM page_schemas WHERE page_url = '$current_page' LIMIT 1";
$schema_result = $conn->query($schema_query);
$schema_data = ($schema_result && $schema_result->num_rows > 0) ? $schema_result->fetch_assoc() : [];

$logo_query = "SELECT logo_path FROM logos WHERE location = 'header' AND is_active = 1 ORDER BY uploaded_at DESC LIMIT 1";
$logo_result = $conn->query($logo_query);
$logo_data = ($logo_result && $logo_result->num_rows > 0) ? $logo_result->fetch_assoc() : [];
$logo_path = !empty($logo_data['logo_path']) ? $logo_data['logo_path'] : 'default-logo.png';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title><?php echo $meta_data['meta_title'] ?? 'Bouncer Force | Premium Gym'; ?></title>
    <meta name="description" content="<?php echo $meta_data['meta_desc'] ?? ''; ?>">
    <meta name="keywords" content="<?php echo $meta_data['meta_key'] ?? ''; ?>">
    
    <?php if(!empty($schema_data['schema_markup'])): ?>
        <?php echo $schema_data['schema_markup']; ?>
    <?php endif; ?>

    <!-- Premium Google Fonts (Montserrat for Headings, Poppins for body) -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,700;0,800;1,800&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="assets/style/include.css">
    <link rel="stylesheet" href="assets/style/style.css">
</head>
<body>

<header class="premium-header">
    <div class="header-container">
        <!-- Brand / Logo -->
        <a href="index.php" class="brand-container">
            <!-- Added onerror to hide broken image icon gracefully if path fails -->
            <img src="<?php echo htmlspecialchars($logo_path); ?>" alt="Logo" class="brand-logo" onerror="this.style.display='none'">
            <div class="brand-name">Bouncer <span>Force</span></div>
        </a>

        <!-- Navigation Menu with Active Links -->
        <ul class="nav-menu" id="navMenu">
            <li class="nav-item">
                <a href="index.php" class="<?php echo ($current_page == 'index.php') ? 'active' : ''; ?>">Home</a>
            </li>
            <li class="nav-item">
                <a href="about.php" class="<?php echo ($current_page == 'about.php') ? 'active' : ''; ?>">About Us</a>
            </li>
            <li class="nav-item">
                <a href="services.php" class="<?php echo ($current_page == 'services.php') ? 'active' : ''; ?>">Services</a>
            </li>
            <li class="nav-item">
                <a href="classes.php" class="<?php echo ($current_page == 'classes.php') ? 'active' : ''; ?>">Classes</a>
            </li>
            <li class="nav-item">
                <a href="trainers.php" class="<?php echo ($current_page == 'trainers.php') ? 'active' : ''; ?>">Trainers</a>
            </li>
            <li class="nav-item">
                <a href="blog.php" class="<?php echo ($current_page == 'blog.php') ? 'active' : ''; ?>">Blog</a>
            </li>
            <li class="nav-item">
                <a href="contact.php" class="<?php echo ($current_page == 'contact.php') ? 'active' : ''; ?>">Contact</a>
            </li>
        </ul>

        <!-- Action Button -->
        <div class="header-actions">
            <a href="join.php" class="btn-premium">Join Now</a>
        </div>

        <!-- Mobile Menu Icon -->
        <div class="mobile-toggle" onclick="toggleMobileMenu()">
            <i class="fas fa-bars"></i>
        </div>
    </div>
</header>

<script>
    function toggleMobileMenu() {
        document.getElementById('navMenu').classList.toggle('active');
    }
</script>
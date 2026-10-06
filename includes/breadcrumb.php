<?php
// Default values agar variable define na ho (React props defaultProps jaisa)
$title = isset($pageTitle) ? $pageTitle : 'Our Page';
$breadcrumbText = isset($pageBreadcrumb) ? $pageBreadcrumb : $title;
?>

<style>
    /* ================= PREMIUM BREADCRUMB ================= */
    .premium-breadcrumb {
        position: relative;
        padding: 100px 5%;
        background-color: #111; /* VIP Dark Background */
        background-image: url('https://images.unsplash.com/photo-1549497552-32b00f5abcc0?q=80&w=1920&auto=format&fit=crop'); /* Security Theme BG */
        background-size: cover;
        background-position: center;
        background-attachment: fixed; /* Parallax Effect */
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        min-height: 350px;
        overflow: hidden;
    }

    .premium-breadcrumb::before {
        content: '';
        position: absolute;
        top: 0; left: 0; width: 100%; height: 100%;
        background: linear-gradient(to right, rgba(17,17,17,0.9), rgba(17,17,17,0.7)); /* Dark gradient overlay */
        z-index: 1;
    }

    .breadcrumb-content {
        position: relative;
        z-index: 2;
        animation: fadeInDown 1s cubic-bezier(0.165, 0.84, 0.44, 1);
    }

    .breadcrumb-title {
        font-family: 'Montserrat', sans-serif;
        font-size: 50px;
        font-weight: 800;
        color: #fff;
        text-transform: uppercase;
        letter-spacing: 2px;
        margin-bottom: 15px;
    }

    .breadcrumb-nav {
        font-family: 'Poppins', sans-serif;
        font-size: 16px;
        font-weight: 500;
        color: #ddd;
    }

    .breadcrumb-nav a {
        color: #d4af37; /* Premium Gold */
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .breadcrumb-nav a:hover {
        color: #fff;
    }

    .breadcrumb-nav span {
        margin: 0 10px;
        color: #777;
    }

    @keyframes fadeInDown {
        0% { opacity: 0; transform: translateY(-30px); }
        100% { opacity: 1; transform: translateY(0); }
    }

    @media (max-width: 768px) {
        .breadcrumb-title { font-size: 36px; }
        .premium-breadcrumb { min-height: 250px; padding: 60px 5%; }
    }
</style>

<section class="premium-breadcrumb">
    <div class="breadcrumb-content">
        <h1 class="breadcrumb-title"><?php echo htmlspecialchars($title); ?></h1>
        <div class="breadcrumb-nav">
            <a href="index.php">Home</a> 
            <span>/</span> 
            <?php echo htmlspecialchars($breadcrumbText); ?>
        </div>
    </div>
</section>
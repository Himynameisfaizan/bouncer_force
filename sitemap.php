<?php
// Set header so browser and Google treat this as an XML file
header("Content-Type: application/xml; charset=utf-8");

// Database connection include karein
include 'config/connect.php';

$base_url = "https://linen-pigeon-484360.hostingersite.com/";

echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

// ================= 1. STATIC PAGES =================
$static_pages = [
    'index.php' => '1.0',
    'about.php' => '0.8',
    'services.php' => '0.9',
    'blog.php' => '0.8',
    'contact.php' => '0.9'
];

foreach ($static_pages as $url => $priority) {
    echo "  <url>\n";
    echo "    <loc>" . $base_url . $url . "</loc>\n";
    echo "    <lastmod>" . date('Y-m-d') . "</lastmod>\n";
    echo "    <changefreq>weekly</changefreq>\n";
    echo "    <priority>" . $priority . "</priority>\n";
    echo "  </url>\n";
}

// ================= 2. DYNAMIC SERVICES (Safe fallback to ID) =================
// Checking if slug_url exists or safely using id to prevent crash
$services_query = "SELECT id FROM services";
$services_result = $conn->query($services_query);

if ($services_result && $services_result->num_rows > 0) {
    while($row = $services_result->fetch_assoc()) {
        $id = $row['id'];
        echo "  <url>\n";
        echo "    <loc>" . $base_url . "service-details.php?id=" . $id . "</loc>\n";
        echo "    <changefreq>monthly</changefreq>\n";
        echo "    <priority>0.8</priority>\n";
        echo "  </url>\n";
    }
}

// ================= 3. DYNAMIC BLOGS =================
$blogs_query = "SELECT slug, created_at FROM blogs WHERE status = 1";
$blogs_result = $conn->query($blogs_query);

if ($blogs_result && $blogs_result->num_rows > 0) {
    while($row = $blogs_result->fetch_assoc()) {
        $slug = !empty($row['slug']) ? $row['slug'] : '';
        $date = !empty($row['created_at']) ? date('Y-m-d', strtotime($row['created_at'])) : date('Y-m-d');
        
        if($slug) {
            echo "  <url>\n";
            echo "    <loc>" . $base_url . "blog-details.php?slug=" . htmlspecialchars($slug) . "</loc>\n";
            echo "    <lastmod>" . $date . "</lastmod>\n";
            echo "    <changefreq>weekly</changefreq>\n";
            echo "    <priority>0.7</priority>\n";
            echo "  </url>\n";
        }
    }
}

echo '</urlset>';
?>
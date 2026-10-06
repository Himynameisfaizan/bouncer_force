<?php
// Include DB and Header
include 'config/connect.php';
include 'includes/header.php';

// URL se slug fetch karna
$slug = isset($_GET['slug']) ? $conn->real_escape_string($_GET['slug']) : '';

// Fetch Current Blog Details
$blog_query = "SELECT * FROM blogs WHERE slug = '$slug' AND status = 1 LIMIT 1";
$blog_result = $conn->query($blog_query);

// Agar blog nahi milta to wapas blog list page par bhej dein
if (!$blog_result || $blog_result->num_rows == 0) {
    echo "<script>window.location.href='blog.php';</script>";
    exit;
}

$blog = $blog_result->fetch_assoc();

// Fetch Recent Blogs for Sidebar (Current blog ko chhodkar baki 4 recent blogs)
$recent_query = "SELECT title, slug, created_at, image FROM blogs WHERE slug != '$slug' AND status = 1 ORDER BY blog_id DESC LIMIT 4";
$recent_result = $conn->query($recent_query);

// Fetch Contact Data for Sidebar Quote[cite: 2]
$contact_query = "SELECT phone FROM contacts LIMIT 1";
$contact_result = $conn->query($contact_query);
$contact_data = ($contact_result && $contact_result->num_rows > 0) ? $contact_result->fetch_assoc() : null;

$phone_clean = !empty($contact_data['phone']) ? preg_replace('/[^0-9]/', '', $contact_data['phone']) : '';
$display_phone = !empty($contact_data['phone']) ? $contact_data['phone'] : '+91 98XXX XXXXX';

// Dynamic Schema Markup (Agar admin ne is blog ke liye specifically dala ho)[cite: 2]
if (!empty($blog['schema_markup'])) {
    echo $blog['schema_markup'];
}


// Setup Breadcrumb
$pageTitle = htmlspecialchars($blog['title']);
$pageBreadcrumb = "Blog Details";
include 'includes/breadcrumb.php';
?>

<section class="bd-page-wrapper">
    <div class="bd-container">
        
        <!-- ================= LEFT: MAIN BLOG CONTENT ================= -->
        <div class="bd-main-content reveal">
            <!-- Blog Hero Image -->
            <div class="bd-image-box">
                <!-- Check the image path to match your upload directory structure -->
                <img src="admin/assets/img/uploads/blogs/<?php echo htmlspecialchars($blog['image']); ?>" 
                     alt="<?php echo htmlspecialchars($blog['title']); ?>"
                     onerror="this.src='https://images.unsplash.com/photo-1555596884-2195dfb8f2b7?q=80&w=1200&auto=format&fit=crop';">
            </div>
            
            <!-- Meta Data -->
            <div class="bd-meta">
                <span><i class="fas fa-user-shield"></i> <?php echo !empty($blog['author']) ? htmlspecialchars($blog['author']) : 'Admin'; ?></span>
                <span><i class="fas fa-calendar-alt"></i> <?php echo date('F d, Y', strtotime($blog['created_at'])); ?></span>
            </div>
            
            <!-- Blog Title -->
            <h2 class="bd-title"><?php echo htmlspecialchars($blog['title']); ?></h2>
            
            <!-- Blog Content Area (Dynamic HTML from CKEditor)[cite: 2] -->
            <div class="bd-content-area">
                <?php 
                    echo $blog['description']; 
                ?>
            </div>
        </div>

        <!-- ================= RIGHT: SIDEBAR ================= -->
        <div class="bd-sidebar">
            
            <!-- Recent Articles Widget -->
            <div class="sidebar-widget reveal">
                <h4 class="sidebar-title">Recent Articles</h4>
                <div class="recent-post-list">
                    <?php 
                    if ($recent_result && $recent_result->num_rows > 0): 
                        while($recent = $recent_result->fetch_assoc()):
                            $rec_slug = !empty($recent['slug']) ? $recent['slug'] : '';
                    ?>
                        <a href="blog-details.php?slug=<?php echo htmlspecialchars($rec_slug); ?>" class="recent-post-item">
                            <img src="admin/assets/img/uploads/blogs/<?php echo htmlspecialchars($recent['image']); ?>" 
                                 alt="<?php echo htmlspecialchars($recent['title']); ?>" class="rpi-img"
                                 onerror="this.src='https://images.unsplash.com/photo-1517457373958-b7bdd4587205?q=80&w=150&auto=format&fit=crop';">
                            <div class="rpi-content">
                                <h5 class="rpi-title"><?php echo htmlspecialchars($recent['title']); ?></h5>
                                <span class="rpi-date"><?php echo date('M d, Y', strtotime($recent['created_at'])); ?></span>
                            </div>
                        </a>
                    <?php 
                        endwhile;
                    else: 
                    ?>
                        <p style="color: #666; font-size: 14px;">No other articles available at the moment.</p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Premium Request Quote Box -->
            <div class="sp-quote-banner reveal">
                <h3>Need Expert Security?</h3>
                <p>Read enough? Secure your premises or event with Bouncer Force today.</p>
                <a href="tel:<?php echo htmlspecialchars($phone_clean); ?>" class="sp-quote-phone">
                    <i class="fas fa-phone-alt"></i> <?php echo htmlspecialchars($display_phone); ?>
                </a>
            </div>

        </div>
    </div>
</section>

<?php include 'includes/inquiry-form.php'; ?>

<!-- Scroll Reveal Script -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const reveals = document.querySelectorAll(".reveal");
        const revealObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add("active");
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.1, rootMargin: "0px 0px -50px 0px" });

        reveals.forEach(reveal => { revealObserver.observe(reveal); });
    });
</script>

<?php include 'includes/footer.php'; ?>
<?php
include 'config/connect.php';
include 'includes/header.php';

$contact_query = "SELECT phone, wp_number FROM contacts LIMIT 1";
$contact_result = $conn->query($contact_query);
$contact_data = ($contact_result && $contact_result->num_rows > 0) ? $contact_result->fetch_assoc() : null;

$phone_clean = !empty($contact_data['phone']) ? preg_replace('/[^0-9]/', '', $contact_data['phone']) : '';
$wp_clean = !empty($contact_data['wp_number']) ? preg_replace('/[^0-9]/', '', $contact_data['wp_number']) : $phone_clean;
$display_phone = !empty($contact_data['phone']) ? $contact_data['phone'] : '+91 98XXX XXXXX';

$limit = 6; 
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;
$offset = ($page - 1) * $limit;

$search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';
$search_condition = !empty($search) ? "WHERE service_name LIKE '%$search%' OR short_desc LIKE '%$search%'" : "";

$total_query = "SELECT COUNT(*) as total FROM services $search_condition";
$total_result = $conn->query($total_query);
$total_rows = ($total_result && $total_result->num_rows > 0) ? $total_result->fetch_assoc()['total'] : 0;
$total_pages = ceil($total_rows / $limit);

$services_query = "SELECT * FROM services $search_condition ORDER BY id DESC LIMIT $offset, $limit";
$services_result = $conn->query($services_query);

$pageTitle = "Our Services";
$pageBreadcrumb = "What We Do";
include 'includes/breadcrumb.php';
?>

<section class="services-page-wrapper">
    <div class="sp-container">
        
        <!-- ================= LEFT SIDEBAR ================= -->
        <div class="sp-sidebar">
            <!-- Search Box -->
            <div class="sp-search-box reveal">
                <h4>Search Services</h4>
                <form action="services.php" method="GET" class="search-form">
                    <input type="text" name="search" class="search-input" placeholder="Type here..." value="<?php echo htmlspecialchars($search); ?>">
                    <button type="submit" class="search-btn"><i class="fas fa-search"></i></button>
                </form>
            </div>

            <!-- Premium Request Quote Box -->
            <div class="sp-quote-banner reveal">
                <h3>Need Custom Security?</h3>
                <p>Talk to our experts. We provide tailored deployment based on your threat assessment.</p>
                <a href="tel:<?php echo htmlspecialchars($phone_clean); ?>" class="sp-quote-phone">
                    <i class="fas fa-phone-alt"></i> <?php echo htmlspecialchars($display_phone); ?>
                </a>
            </div>
        </div>

        <!-- ================= RIGHT MAIN CONTENT ================= -->
        <div class="sp-main-content">
            <?php 
            if ($services_result && $services_result->num_rows > 0): 
                while($service = $services_result->fetch_assoc()):
                    // Slug ka use karke dynamic URL banaya
                    $slug = !empty($service['slug_url']) ? $service['slug_url'] : $service['id'];
                    $details_url = "service-details.php?slug=" . htmlspecialchars($slug);
            ?>
                <!-- Service Card -->
                <div class="vip-service-card reveal">
                    <div class="vsc-img-box">
                        <img src="admin/assets/img/uploads/<?php echo htmlspecialchars($service['img_path']); ?>" 
                             alt="<?php echo htmlspecialchars($service['service_name']); ?>"
                             onerror="this.src='https://images.unsplash.com/photo-1549497552-32b00f5abcc0?q=80&w=600&auto=format&fit=crop';">
                    </div>
                    
                    <div class="vsc-content-box">
                        <!-- Title -->
                        <a href="<?php echo $details_url; ?>" class="vsc-title">
                            <?php echo htmlspecialchars($service['service_name']); ?>
                        </a>
                        
                        <!-- Contact Icons under title -->
                        <div class="vsc-quick-contact">
                            <a href="tel:<?php echo htmlspecialchars($phone_clean); ?>" class="call">
                                <i class="fas fa-phone-alt"></i> Call Now
                            </a>
                            <a href="https://wa.me/<?php echo htmlspecialchars($wp_clean); ?>?text=I'm%20interested%20in%20your%20<?php echo urlencode($service['service_name']); ?>%20Service" target="_blank" class="whatsapp">
                                <i class="fab fa-whatsapp"></i> WhatsApp
                            </a>
                        </div>
                        
                        <!-- 3-Line Truncated Description -->
                        <div class="vsc-desc">
                            <?php 
                                // Long desc ko clean karke dikhana, agar short na ho[cite: 2]
                                $desc = !empty($service['long_desc']) ? strip_tags($service['long_desc']) : $service['short_desc'];
                                echo htmlspecialchars($desc);
                            ?>
                        </div>
                        
                        <!-- Footer actions -->
                        <div class="vsc-footer">
                            <a href="<?php echo $details_url; ?>" class="btn-view-details">
                                View Details <i class="fas fa-arrow-right"></i>
                            </a>
                            <a href="contact.php?service=<?php echo htmlspecialchars($slug); ?>" class="btn-quote-link">
                                Request a Quote
                            </a>
                        </div>
                    </div>
                </div>
            <?php 
                endwhile;
            else: 
            ?>
                <!-- No Results / Fallback -->
                <div class="sp-search-box" style="text-align: center; padding: 50px;">
                    <i class="fas fa-exclamation-circle" style="font-size: 40px; color: #d4af37; margin-bottom: 15px;"></i>
                    <h4>No Services Found</h4>
                    <p style="color: #666;">Try searching with a different keyword.</p>
                </div>
            <?php endif; ?>

            <!-- ================= PAGINATION ================= -->
            <?php if($total_pages > 1): ?>
                <div class="vip-pagination reveal">
                    <!-- Prev Button -->
                    <?php if($page > 1): ?>
                        <a href="services.php?page=<?php echo ($page-1); ?>&search=<?php echo urlencode($search); ?>"><i class="fas fa-angle-left"></i></a>
                    <?php endif; ?>
                    
                    <!-- Page Numbers -->
                    <?php for($i = 1; $i <= $total_pages; $i++): ?>
                        <a href="services.php?page=<?php echo $i; ?>&search=<?php echo urlencode($search); ?>" class="<?php echo ($page == $i) ? 'active' : ''; ?>">
                            <?php echo $i; ?>
                        </a>
                    <?php endfor; ?>
                    
                    <!-- Next Button -->
                    <?php if($page < $total_pages): ?>
                        <a href="services.php?page=<?php echo ($page+1); ?>&search=<?php echo urlencode($search); ?>"><i class="fas fa-angle-right"></i></a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

        </div>
    </div>
</section>

<!-- Include Smooth Scroll Script (from home/about) -->
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
<?php
// Include DB and Header
include 'config/connect.php';
include 'includes/header.php';

// Fetch Slug from URL
$slug = isset($_GET['slug']) ? $conn->real_escape_string($_GET['slug']) : '';

// Fetch Current Service Details
$service_query = "SELECT * FROM services WHERE slug_url = '$slug' LIMIT 1";
$service_result = $conn->query($service_query);

// Agar service nahi milti to services page par redirect kar dein
if (!$service_result || $service_result->num_rows == 0) {
    echo "<script>window.location.href='services.php';</script>";
    exit;
}

$service = $service_result->fetch_assoc();

// Fetch Related Services (Current service ko chhodkar baki 5)
$related_query = "SELECT service_name, slug_url FROM services WHERE slug_url != '$slug' LIMIT 5";
$related_result = $conn->query($related_query);

// Fetch Contact Data for Sidebar Quote & Inquiry Map
$contact_query = "SELECT * FROM contacts LIMIT 1";
$contact_result = $conn->query($contact_query);
$contact_data = ($contact_result && $contact_result->num_rows > 0) ? $contact_result->fetch_assoc() : null;

// Clean phone numbers for tel: and wa.me links
$phone_clean = !empty($contact_data['phone']) ? preg_replace('/[^0-9]/', '', $contact_data['phone']) : '';
$display_phone = !empty($contact_data['phone']) ? $contact_data['phone'] : '+91 98XXX XXXXX';
$map_url = (!empty($contact_data['map'])) ? $contact_data['map'] : 'https://www.google.com/maps/embed?...'; // Default map fallback

// Setup Dynamic Breadcrumb
$pageTitle = htmlspecialchars($service['service_name']);
$pageBreadcrumb = "Service Details";
include 'includes/breadcrumb.php';
?>

<!-- ================= MAIN SERVICE DETAILS SECTION ================= -->
<section class="sd-page-wrapper">
    <div class="sd-container">
        
        <!-- LEFT: Main Service Content -->
        <div class="sd-main-content reveal">
            <div class="sd-image-box">
                <!-- Ensure uploads/services/ path matches your admin folder structure -->
                <img src="admin/assets/img/uploads/<?php echo htmlspecialchars($service['img_path']); ?>" 
                     alt="<?php echo htmlspecialchars($service['service_name']); ?>"
                     onerror="this.src='https://images.unsplash.com/photo-1549497552-32b00f5abcc0?q=80&w=1200&auto=format&fit=crop';">
            </div>
            
            <h1 class="sd-title"><?php echo htmlspecialchars($service['service_name']); ?></h1>
            <div class="sd-short-desc">
                <?php echo htmlspecialchars($service['short_desc']); ?>
            </div>
            
            <div class="sd-long-desc">
                <!-- Dynamic Content from CKEditor[cite: 2] -->
                <?php 
                    if (!empty($service['long_desc'])) {
                        echo $service['long_desc']; 
                    } else {
                        echo "<p>Detailed description for this premium security service is currently being updated. Please contact us directly for specific deployment protocols, team structures, and pricing.</p>";
                    }
                ?>
            </div>
        </div>

        <!-- RIGHT: Sidebar -->
        <div class="sd-sidebar">
            
            <!-- Related Services Widget -->
            <div class="sidebar-widget reveal">
                <h4 class="sidebar-title">Other Security Services</h4>
                <ul class="related-links">
                    <?php 
                    if ($related_result && $related_result->num_rows > 0): 
                        while($rel = $related_result->fetch_assoc()):
                            $rel_slug = !empty($rel['slug_url']) ? $rel['slug_url'] : '';
                    ?>
                        <li>
                            <a href="service-details.php?slug=<?php echo htmlspecialchars($rel_slug); ?>">
                                <?php echo htmlspecialchars($rel['service_name']); ?>
                                <i class="fas fa-angle-right"></i>
                            </a>
                        </li>
                    <?php 
                        endwhile;
                    else: 
                    ?>
                        <!-- Fallback Links -->
                        <li><a href="#">VIP Guest Management <i class="fas fa-angle-right"></i></a></li>
                        <li><a href="#">Celebrity Protection <i class="fas fa-angle-right"></i></a></li>
                        <li><a href="#">Event Crowd Control <i class="fas fa-angle-right"></i></a></li>
                    <?php endif; ?>
                </ul>
            </div>

            <!-- Premium Request Quote Box -->
            <div class="sp-quote-banner reveal">
                <h3>Need Immediate Deployment?</h3>
                <p>Speak directly to our security coordinator for a custom threat assessment and quote.</p>
                <a href="tel:<?php echo htmlspecialchars($phone_clean); ?>" class="sp-quote-phone">
                    <i class="fas fa-phone-alt"></i> <?php echo htmlspecialchars($display_phone); ?>
                </a>
            </div>

        </div>
    </div>
</section>

<!-- ================= INQUIRY FORM SECTION (BOTTOM) ================= -->
<section class="inquiry-section">
    <div class="contact-container reveal">
        
        <!-- LEFT: Map Container[cite: 2] -->
        <div class="contact-map">
            <iframe src="<?php echo $map_url; ?>" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>

        <!-- RIGHT: Form Container -->
        <div class="contact-form-wrap">
            <h3>Inquire About This Service</h3>
            <p>Fill the details below for <strong><?php echo htmlspecialchars($service['service_name']); ?></strong>. We will respond within 15 minutes.</p>
            
            <form action="submit_inquiry.php" method="POST">
                <!-- Hidden input to track which service they are inquiring about -->
                <input type="hidden" name="service_inquiry" value="<?php echo htmlspecialchars($service['service_name']); ?>">
                
                <div class="form-group">
                    <input type="text" name="name" class="form-control" placeholder="Your Full Name *" required>
                </div>
                <div class="form-group">
                    <input type="email" name="email" class="form-control" placeholder="Email Address *" required>
                </div>
                <div class="form-group">
                    <input type="tel" name="phone" class="form-control" placeholder="Phone Number *" required>
                </div>
                <div class="form-group">
                    <!-- Service dynamically selected block[cite: 2] -->
                    <input type="text" class="form-control" value="Service: <?php echo htmlspecialchars($service['service_name']); ?>" readonly style="background: rgba(255,255,255,0.1); color: #d4af37;">
                </div>
                <div class="form-group">
                    <textarea name="message" class="form-control" rows="4" placeholder="Tell us about your event size, date, and special requirements..."></textarea>
                </div>
                <button type="submit" class="btn-submit">Send Secure Inquiry</button>
            </form>
        </div>
        
    </div>
</section>

<!-- Reveal Animation Script -->
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
<?php
// Include DB and Header
include 'config/connect.php';
include 'includes/header.php';

// Fetch About Us data from database
$about_query = "SELECT * FROM about_us LIMIT 1";
$about_result = $conn->query($about_query);
$about_data = ($about_result && $about_result->num_rows > 0) ? $about_result->fetch_assoc() : null;

// React "Props" like concept for dynamic breadcrumb
$pageTitle = "About Us";
$pageBreadcrumb = "Who We Are";
include 'includes/breadcrumb.php';
?>

<!-- About Us Core Section -->
<section class="section-padding bg-white">
    <div class="about-main-container reveal">
        
        <!-- Left Image -->
        <div class="about-image-wrapper">
            <?php 
                $about_img = !empty($about_data['image_url']) ? "admin/assets/img/uploads/".$about_data['image_url'] : 'https://images.unsplash.com/photo-1582139329536-e7284fece509?q=80&w=800&auto=format&fit=crop';
            ?>
            <img src="<?php echo htmlspecialchars($about_img); ?>" alt="Bouncer Force Team">
        </div>

        <!-- Right Content -->
        <div class="about-text-content">
            <span class="sub-heading">The Force Behind Safe Events</span>
            
            <h2 class="main-heading">
                <?php echo !empty($about_data['title']) ? htmlspecialchars($about_data['title']) : 'Uncompromising Security. White-Glove Service.'; ?>
            </h2>
            
            <div class="desc-text">
                <?php 
                    if(!empty($about_data['content'])) {
                        echo $about_data['content'];
                    } else {
                        echo "<p>Bouncer Force isn't a typical guard agency. We are a specialist team of event bouncers and VIP protocol professionals who blend a commanding presence with genuine hospitality — your guests feel looked after, never policed.</p>";
                        echo "<p>With a foundation built on discipline, our handpicked team consists of ex-defence personnel, trained athletes, and certified crowd management experts. We don't just react to trouble; our presence prevents it.</p>";
                    }
                ?>
            </div>

            <div class="highlight-quote">
                "A great event feels effortless — because someone invisible is working hard to keep it that way."
                <br><span style="font-size: 14px; color: #d4af37; margin-top: 10px; display: block;">— The Bouncer Force Creed</span>
            </div>
        </div>

    </div>
</section>

<section class="stats-section">
    <div class="stats-grid reveal">
        <div class="stat-box">
            <h3>500+</h3>
            <p>Events Secured</p>
        </div>
        <div class="stat-box">
            <h3>120+</h3>
            <p>Trained Professionals</p>
        </div>
        <div class="stat-box">
            <h3>15 min</h3>
            <p>Avg. Response Time</p>
        </div>
        <div class="stat-box">
            <h3>24/7</h3>
            <p>Deployment Readiness</p>
        </div>
    </div>
</section>

<!-- Include Smooth Scroll Script -->
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
        }, {
            threshold: 0.1,
            rootMargin: "0px 0px -50px 0px"
        });

        reveals.forEach(reveal => {
            revealObserver.observe(reveal);
        });
    });
</script>

<?php
include 'includes/footer.php';
?>
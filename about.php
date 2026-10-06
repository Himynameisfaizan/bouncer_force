<?php
include 'config/connect.php';
include 'includes/header.php';

$about_query = "SELECT * FROM about_us LIMIT 1";
$about_result = $conn->query($about_query);
$about_data = ($about_result && $about_result->num_rows > 0) ? $about_result->fetch_assoc() : null;

$cert_query = "SELECT * FROM certificates WHERE status = 1 LIMIT 4";
$cert_result = $conn->query($cert_query);

$pageTitle = "About Us";
$pageBreadcrumb = "About Us";
include 'includes/breadcrumb.php';
?>

<!-- ================= 1. CORE ABOUT US ================= -->
<section class="section-padding bg-white">
    <div class="about-main-container reveal">
        <div class="about-image-wrapper">
            <?php 
                $about_img = !empty($about_data['image_url']) ? "uploads/".$about_data['image_url'] : 'https://images.unsplash.com/photo-1582139329536-e7284fece509?q=80&w=800&auto=format&fit=crop';
            ?>
            <img src="<?php echo htmlspecialchars($about_img); ?>" alt="Bouncer Force Team">
        </div>
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

<!-- ================= 2. MISSION & VISION ================= -->
<section class="section-padding bg-light-grey">
    <div class="mv-grid">
        <div class="mv-card dark reveal">
            <i class="fas fa-bullseye mv-icon"></i>
            <h3>Our Mission</h3>
            <p>To redefine the security industry by providing elite, highly-trained professionals who ensure safety without compromising on hospitality. We aim to protect assets, lives, and reputations through proactive risk management and seamless event execution.</p>
        </div>
        <div class="mv-card light reveal" style="transition-delay: 0.2s;">
            <i class="fas fa-eye mv-icon"></i>
            <h3>Our Vision</h3>
            <p>To be the most trusted and respected VIP security and crowd management agency in the nation, known for our uncompromising discipline, transparent operations, and ability to handle high-profile environments with absolute discretion and professionalism.</p>
        </div>
    </div>
</section>

<!-- ================= 3. WHY CHOOSE US ================= -->
<section class="section-padding bg-white">
    <span class="section-subtitle reveal">Why Bouncer Force</span>
    <h2 class="section-title reveal">Built on Discipline. Trusted for It.</h2>
    
    <div class="wcu-grid">
        <div class="wcu-item reveal">
            <div class="wcu-icon"><i class="fas fa-id-badge"></i></div>
            <div class="wcu-content">
                <h4>Verified & Trained Staff</h4>
                <p>Police-verified IDs, deep background checks, and rigorous physical/psychological training before anyone wears our uniform.</p>
            </div>
        </div>
        <div class="wcu-item reveal" style="transition-delay: 0.1s;">
            <div class="wcu-icon"><i class="fas fa-user-ninja"></i></div>
            <div class="wcu-content">
                <h4>Ex-Defence & Athletes</h4>
                <p>Our core team is built from ex-servicemen, martial artists, and combat sports athletes. A presence that commands respect.</p>
            </div>
        </div>
        <div class="wcu-item reveal" style="transition-delay: 0.2s;">
            <div class="wcu-icon"><i class="fas fa-fighter-jet"></i></div>
            <div class="wcu-content">
                <h4>Rapid Deployment</h4>
                <p>Emergency requirement? Our standby rosters allow us to deploy a briefed, fully-equipped team at your location in as little as 2 hours.</p>
            </div>
        </div>
        <div class="wcu-item reveal">
            <div class="wcu-icon"><i class="fas fa-headset"></i></div>
            <div class="wcu-content">
                <h4>Live Supervision</h4>
                <p>A dedicated field supervisor with radio coordination oversees every major deployment, reporting directly to your management.</p>
            </div>
        </div>
        <div class="wcu-item reveal" style="transition-delay: 0.1s;">
            <div class="wcu-icon"><i class="fas fa-user-shield"></i></div>
            <div class="wcu-content">
                <h4>Discreet VIP Handling</h4>
                <p>We understand privacy. Our close-protection officers provide a secure bubble without drawing unnecessary attention to the client.</p>
            </div>
        </div>
        <div class="wcu-item reveal" style="transition-delay: 0.2s;">
            <div class="wcu-icon"><i class="fas fa-file-signature"></i></div>
            <div class="wcu-content">
                <h4>Transparent Contracts</h4>
                <p>Clear per-guard, per-shift quotes. No hidden fees, no last-minute demands. Just honest, straightforward business.</p>
            </div>
        </div>
    </div>
</section>

<!-- ================= 4. TRUST & CERTIFICATIONS (Dynamic) ================= -->
<section class="section-padding bg-dark">
    <span class="section-subtitle reveal">Trust & Authority</span>
    <h2 class="section-title text-white reveal">Licensed & Certified Agency</h2>
    
    <div class="trust-grid">
        <?php 
        if ($cert_result && $cert_result->num_rows > 0): 
            while($cert = $cert_result->fetch_assoc()):
        ?>
            <div class="cert-card reveal">
                <!-- Ensure correct admin/uploads path for certificates -->
                <img src="uploads/<?php echo htmlspecialchars($cert['image']); ?>" alt="<?php echo htmlspecialchars($cert['title']); ?>" onerror="this.src='https://cdn-icons-png.flaticon.com/512/1055/1055644.png';">
                <h5><?php echo htmlspecialchars($cert['title']); ?></h5>
            </div>
        <?php 
            endwhile;
        else: 
            // Fallbacks for Trust Section
        ?>
            <div class="cert-card reveal">
                <img src="https://cdn-icons-png.flaticon.com/512/1055/1055644.png" alt="PSARA License">
                <h5>PSARA Licensed</h5>
            </div>
            <div class="cert-card reveal" style="transition-delay: 0.1s;">
                <img src="https://cdn-icons-png.flaticon.com/512/1055/1055644.png" alt="ISO Certified">
                <h5>ISO 9001:2015</h5>
            </div>
            <div class="cert-card reveal" style="transition-delay: 0.2s;">
                <img src="https://cdn-icons-png.flaticon.com/512/1055/1055644.png" alt="Police Verified">
                <h5>100% Police Verified</h5>
            </div>
            <div class="cert-card reveal" style="transition-delay: 0.3s;">
                <img src="https://cdn-icons-png.flaticon.com/512/1055/1055644.png" alt="Crowd Management">
                <h5>Crowd Mgmt Certified</h5>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- ================= 5. FAQ SECTION ================= -->
<section class="section-padding bg-light-grey">
    <span class="section-subtitle reveal">Clear Doubts</span>
    <h2 class="section-title reveal">Frequently Asked Questions</h2>
    
    <div class="faq-container">
        <!-- FAQ 1 -->
        <div class="faq-item reveal">
            <button class="faq-question">How far in advance should I book? <i class="fas fa-chevron-down"></i></button>
            <div class="faq-answer">
                <p>For large events (weddings, concerts, corporate galas) we recommend 3-7 days' notice. However, we keep standby rosters, allowing us to regularly deploy teams within 2-4 hours for emergency situations on the same day.</p>
            </div>
        </div>
        <!-- FAQ 2 -->
        <div class="faq-item reveal">
            <button class="faq-question">Do you provide female bouncers? <i class="fas fa-chevron-down"></i></button>
            <div class="faq-answer">
                <p>Yes, absolutely. We have highly trained professional female security officers available for frisking ladies, managing family zones, and providing personal security for VIP women guests to ensure complete comfort and safety.</p>
            </div>
        </div>
        <!-- FAQ 3 -->
        <div class="faq-item reveal">
            <button class="faq-question">Are your bouncers verified and trained? <i class="fas fa-chevron-down"></i></button>
            <div class="faq-answer">
                <p>Every single officer undergoes a strict background check, including police verification. Additionally, they receive specialized training in crowd psychology, conflict de-escalation, and emergency response before they are deployed.</p>
            </div>
        </div>
        <!-- FAQ 4 -->
        <div class="faq-item reveal">
            <button class="faq-question">What is the minimum team size I can hire? <i class="fas fa-chevron-down"></i></button>
            <div class="faq-answer">
                <p>You can hire as few as a single Personal Security Officer (PSO) or a team of 100+ bouncers depending on your event scale. We customize our deployment exactly according to your risk assessment and requirements.</p>
            </div>
        </div>
    </div>
</section>

<!-- JavaScript for FAQ Accordion & Reveal -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // --- FAQ Accordion Logic ---
        const faqQuestions = document.querySelectorAll('.faq-question');
        faqQuestions.forEach(question => {
            question.addEventListener('click', () => {
                const answer = question.nextElementSibling;
                const isActive = question.classList.contains('active');
                
                // Close all other FAQs
                document.querySelectorAll('.faq-question').forEach(q => {
                    q.classList.remove('active');
                    q.nextElementSibling.style.maxHeight = null;
                });

                // Open clicked FAQ if it wasn't already active
                if (!isActive) {
                    question.classList.add('active');
                    answer.style.maxHeight = answer.scrollHeight + "px";
                }
            });
        });

        // --- Reveal Animation Logic ---
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
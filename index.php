<?php
    include 'config/connect.php'; 
    include 'includes/header.php'; 

    $banner_query = "SELECT * FROM banners ORDER BY display_order ASC";
    $banner_result = $conn->query($banner_query);

    $current_page = basename($_SERVER['PHP_SELF']);
    if(empty($current_page)) $current_page = 'index.php';

    $schema_query = "SELECT schema_markup FROM page_schemas WHERE page_url = '$current_page' LIMIT 1";
    $schema_result = $conn->query($schema_query);
    $schema_data = ($schema_result && $schema_result->num_rows > 0) ? $schema_result->fetch_assoc() : [];
?>

<?php if(!empty($schema_data['schema_markup'])): ?>
    <?php echo $schema_data['schema_markup']; ?>
<?php else: ?>
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "HealthAndBeautyBusiness",
      "name": "Bouncer Force Gym",
      "image": "logo.png",
      "telephone": "+91-9876543210",
      "address": {
        "@type": "PostalAddress",
        "streetAddress": "Gym Street",
        "addressLocality": "Delhi",
        "addressCountry": "IN"
      }
    }
    </script>
<?php endif; ?>


<link rel="stylesheet" href="assets/style/swiper-bundle.min.css">

<link rel="stylesheet" href="https://unpkg.com/swiper@10/swiper-bundle.min.css" />

<section class="hero-slider-section">
    <div class="swiper myHeroSwiper">
        <div class="swiper-wrapper">
            
            <?php 
            if ($banner_result && $banner_result->num_rows > 0): 
                while($row = $banner_result->fetch_assoc()):
            ?>
            
            <div class="swiper-slide">
             
                <div class="slide-bg-image" style="background-image: url('admin/<?php echo htmlspecialchars($row['banner_path']); ?>');"></div>
                
                <div class="slide-overlay"></div>
                
                <div class="slide-content">
                    <h1 class="slide-title"><?php echo htmlspecialchars($row['title']); ?></h1>
                    <p class="slide-desc"><?php echo htmlspecialchars($row['description']); ?></p>
                    
                    <?php if(!empty($row['link_url'])): ?>
                        <a href="<?php echo htmlspecialchars($row['link_url']); ?>" class="btn-slider">Explore Now</a>
                    <?php else: ?>
                        <a href="join.php" class="btn-slider">Start Your Journey</a>
                    <?php endif; ?>
                </div>
            </div>

            <?php 
                endwhile;
            else: 
            ?>
            
            <!-- Default Fallback Slide -->
            <div class="swiper-slide">
                <div class="slide-bg-image" style="background-image: url('https://images.unsplash.com/photo-1534438327276-14e5300c3a48?q=80&w=1470&auto=format&fit=crop');"></div>
                <div class="slide-overlay"></div>
                <div class="slide-content">
                    <h1 class="slide-title">Unleash Your <br><span>True Potential</span></h1>
                    <p class="slide-desc">Experience the premium fitness environment at Bouncer Force. State-of-the-art equipment, elite trainers, and a community that pushes you forward.</p>
                    <a href="join.php" class="btn-slider">Join Bouncer Force</a>
                </div>
            </div>
            
            <?php endif; ?>
            
        </div>
        
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
        <div class="swiper-pagination"></div>
    </div>
</section>

<?php
    $about_query = "SELECT * FROM about_sections ORDER BY section_order ASC LIMIT 1";
    $about_result = $conn->query($about_query);
    $about_data = ($about_result && $about_result->num_rows > 0) ? $about_result->fetch_assoc() : null;

    $services_query = "SELECT * FROM services LIMIT 6";
    $services_result = $conn->query($services_query);

    $test_query = "SELECT * FROM testimonials WHERE status = 1 LIMIT 3";
    $test_result = $conn->query($test_query);
?>
<!-- ================= ABOUT US (Dynamic) ================= -->
<section class="section-padding bg-white" id="about">
    <div class="about-container reveal">
        <div class="about-image">
            <?php 
                $img = !empty($about_data['image_url']) ? $about_data['image_url'] : 'https://images.unsplash.com/photo-1582139329536-e7284fece509?q=80&w=800&auto=format&fit=crop'; 
            ?>
            <img src="admin/<?php echo htmlspecialchars($img); ?>" alt="Bouncer Force Security">
        </div>
        <div class="about-content">
            <span class="section-subtitle">Who We Are</span>
            <h2 class="section-title" style="margin-bottom: 20px;">
                <?php echo !empty($about_data['title']) ? htmlspecialchars($about_data['title']) : 'The Force Behind Safe, Seamless Events'; ?>
            </h2>
            <div class="about-text">
                <?php 
                    // Database me abhi shayad agri/other content ho, jab admin security ka dale tab dynamic display hoga
                    if(!empty($about_data['content'])) {
                        echo $about_data['content'];
                    } else {
                        echo "<p>Bouncer Force isn't a typical guard agency. We are a specialist team of event bouncers and VIP protocol professionals who blend a commanding presence with genuine hospitality — your guests feel looked after, never policed.</p>";
                        echo "<p>From high-energy events to white-glove VIP guest management, we deploy trained professionals who keep your people safe and your event flawless.</p>";
                    }
                ?>
            </div>
            <a href="about.php" class="btn-gold" style="margin-top: 15px; display: inline-block;">Learn More</a>
        </div>
    </div>
</section>

<?php
    $services_query = "SELECT * FROM services LIMIT 6";
    $services_result = $conn->query($services_query);
?>

<style>
    /* --- PREMIUM SERVICES CARD SECTION --- */
    .services-grid-premium {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
        gap: 40px;
        max-width: 1300px;
        margin: 0 auto;
    }
    
    .service-card-premium {
        background: #fff;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0,0,0,0.06);
        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        display: flex;
        flex-direction: column;
        border: 1px solid rgba(0,0,0,0.03);
        position: relative;
    }
    
    .service-card-premium:hover {
        transform: translateY(-12px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.12);
    }
    
    /* Image Container (Clickable) */
    .scp-img-wrap {
        width: 100%;
        height: 240px;
        overflow: hidden;
        display: block;
        position: relative;
    }
    
    .scp-img-wrap::after {
        content: '';
        position: absolute;
        top: 0; left: 0; width: 100%; height: 100%;
        background: linear-gradient(to bottom, rgba(0,0,0,0) 50%, rgba(0,0,0,0.4) 100%);
        z-index: 1;
        opacity: 0;
        transition: opacity 0.4s ease;
    }
    
    .service-card-premium:hover .scp-img-wrap::after {
        opacity: 1;
    }
    
    .scp-img-wrap img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s cubic-bezier(0.165, 0.84, 0.44, 1);
    }
    
    .service-card-premium:hover .scp-img-wrap img {
        transform: scale(1.1);
    }
    
    /* Card Content */
    .scp-content {
        padding: 35px 30px;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
        background-color: #fff;
    }
    
    /* Title (Clickable) */
    .scp-title {
        font-family: 'Montserrat', sans-serif;
        font-size: 22px;
        font-weight: 800;
        color: #111;
        margin-bottom: 15px;
        text-decoration: none;
        transition: color 0.3s ease;
    }
    
    .scp-title:hover {
        color: #d4af37; /* VIP Gold */
    }
    
    /* Description */
    .scp-desc {
        font-family: 'Poppins', sans-serif;
        color: #555;
        font-size: 15px;
        line-height: 1.7;
        margin-bottom: 25px;
        flex-grow: 1;
    }
    
    /* View Details Link */
    .scp-link {
        font-family: 'Montserrat', sans-serif;
        font-weight: 700;
        color: #d4af37;
        text-transform: uppercase;
        text-decoration: none;
        font-size: 14px;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        letter-spacing: 1px;
        transition: all 0.3s ease;
    }
    
    .scp-link i {
        font-size: 13px;
        transition: transform 0.3s ease;
    }
    
    .scp-link:hover {
        color: #111;
        gap: 12px;
    }
    
    .scp-link:hover i {
        transform: translateX(4px);
    }
</style>

<!-- ================= OUR SERVICES (Dynamic Image Cards) ================= -->
<section class="section-padding bg-light-grey" id="services">
    <div class="section-header reveal">
        <span class="section-subtitle">Our Expertise</span>
        <h2 class="section-title">One Force. Every Security Need.</h2>
    </div>

    <div class="services-grid-premium">
        <?php 
        if ($services_result && $services_result->num_rows > 0): 
            while($service = $services_result->fetch_assoc()):
                // URL for the details page passing the ID
                $details_url = "service-details.php?id=" . $service['id'];
        ?>
            <div class="service-card-premium reveal">
                <!-- Image Section (Clickable) -->
                <a href="<?php echo $details_url; ?>" class="scp-img-wrap">
                    <!-- admin path set karein apne project structure ke hisab se -->
                    <img src="admin/assets/img/uploads/<?php echo htmlspecialchars($service['img_path']); ?>" 
                         alt="<?php echo htmlspecialchars($service['service_name']); ?>" 
                         onerror="this.src='https://images.unsplash.com/photo-1549497552-32b00f5abcc0?q=80&w=800&auto=format&fit=crop';">
                </a>
                
                <!-- Content Section -->
                <div class="scp-content">
                    <!-- Title (Clickable) -->
                    <a href="<?php echo $details_url; ?>" class="scp-title">
                        <?php echo htmlspecialchars($service['service_name']); ?>
                    </a>
                    
                    <!-- Short Description -->
                    <p class="scp-desc">
                        <?php echo htmlspecialchars($service['short_desc']); ?>
                    </p>
                    
                    <!-- View Details Link -->
                    <div>
                        <a href="<?php echo $details_url; ?>" class="scp-link">
                            View Details <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        <?php 
            endwhile;
        else: 
            // ================= PREMIUM FALLBACK DATA ================= 
            // Jab database mein service upload na ho tab tak VIP dummy data dikhega
        ?>
            <!-- Fallback Card 1 -->
            <div class="service-card-premium reveal">
                <a href="service-details.php?id=1" class="scp-img-wrap">
                    <img src="https://images.unsplash.com/photo-1555596884-2195dfb8f2b7?q=80&w=800&auto=format&fit=crop" alt="VIP Guest Management">
                </a>
                <div class="scp-content">
                    <a href="service-details.php?id=1" class="scp-title">VIP Guest Management</a>
                    <p class="scp-desc">White-glove handling for your most important guests — discreet escorts, reserved zones and flawless VIP protocol.</p>
                    <div>
                        <a href="service-details.php?id=1" class="scp-link">View Details <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>

            <!-- Fallback Card 2 -->
            <div class="service-card-premium reveal">
                <a href="service-details.php?id=2" class="scp-img-wrap">
                    <img src="https://images.unsplash.com/photo-1517457373958-b7bdd4587205?q=80&w=800&auto=format&fit=crop" alt="Celebrity Protection">
                </a>
                <div class="scp-content">
                    <a href="service-details.php?id=2" class="scp-title">Celebrity Protection</a>
                    <p class="scp-desc">Close-protection officers for artists, athletes, executives and public figures. We handle their journey so you can handle your event.</p>
                    <div>
                        <a href="service-details.php?id=2" class="scp-link">View Details <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>

            <!-- Fallback Card 3 -->
            <div class="service-card-premium reveal">
                <a href="service-details.php?id=3" class="scp-img-wrap">
                    <img src="https://images.unsplash.com/photo-1549497552-32b00f5abcc0?q=80&w=800&auto=format&fit=crop" alt="Crowd Control">
                </a>
                <div class="scp-content">
                    <a href="service-details.php?id=3" class="scp-title">Event Crowd Control</a>
                    <p class="scp-desc">Queue discipline, ticket checks and entry management that keeps thousands moving calmly without compromising security.</p>
                    <div>
                        <a href="service-details.php?id=3" class="scp-link">View Details <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- ================= WHY CHOOSE US (Static - As Requested) ================= -->
<section class="section-padding bg-white">
    <div class="section-header reveal">
        <span class="section-subtitle">Why Bouncer Force</span>
        <h2 class="section-title">Built on Discipline. Trusted for It.</h2>
    </div>

    <div class="features-grid">
        <div class="feature-box reveal">
            <div class="feature-icon"><i class="fas fa-id-badge"></i></div>
            <div class="feature-text">
                <h4>Verified & Trained Staff</h4>
                <p>Police-verified IDs, reference checks, and crowd management certification before anyone wears our uniform.</p>
            </div>
        </div>
        <div class="feature-box reveal">
            <div class="feature-icon"><i class="fas fa-medal"></i></div>
            <div class="feature-text">
                <h4>Ex-Defence & Athletes</h4>
                <p>Our bench is built from ex-servicemen, boxers, and martial artists — a presence that prevents trouble.</p>
            </div>
        </div>
        <div class="feature-box reveal">
            <div class="feature-icon"><i class="fas fa-bolt"></i></div>
            <div class="feature-text">
                <h4>Rapid Deployment</h4>
                <p>Need bouncers tonight? Our standby rosters put a briefed team at your gate in as little as 2 hours.</p>
            </div>
        </div>
        <div class="feature-box reveal">
            <div class="feature-icon"><i class="fas fa-female"></i></div>
            <div class="feature-text">
                <h4>Female Guards Available</h4>
                <p>Professional women officers for frisking ladies' entries and family-zone comfort.</p>
            </div>
        </div>
        <div class="feature-box reveal">
            <div class="feature-icon"><i class="fas fa-file-invoice-dollar"></i></div>
            <div class="feature-text">
                <h4>Transparent Pricing</h4>
                <p>Per-guard, per-shift quotes before you commit. No surprise charges, ever.</p>
            </div>
        </div>
        <div class="feature-box reveal">
            <div class="feature-icon"><i class="fas fa-broadcast-tower"></i></div>
            <div class="feature-text">
                <h4>Live Supervision</h4>
                <p>A field supervisor with radio coordination oversees every deployment and reports directly to you.</p>
            </div>
        </div>
    </div>
</section>

<!-- ================= TESTIMONIALS (Dynamic) ================= -->
<section class="section-padding bg-light-grey">
    <div class="section-header reveal">
        <span class="section-subtitle">Client Words</span>
        <h2 class="section-title">Trusted by Clubs, Planners & Celebrities</h2>
    </div>

    <div class="services-grid"> <!-- Reusing grid layout for consistent cards -->
        <?php 
        if ($test_result && $test_result->num_rows > 0): 
            while($test = $test_result->fetch_assoc()):
        ?>
            <div class="testimonial-card reveal">
                <i class="fas fa-quote-right quote-icon"></i>
                <div class="stars">
                    <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                </div>
                <p class="test-text">"<?php echo strip_tags($test['message']); ?>"</p>
                <div class="client-info">
                    <h5><?php echo htmlspecialchars($test['name']); ?></h5>
                    <span><?php echo htmlspecialchars($test['designation']); ?></span>
                </div>
            </div>
        <?php 
            endwhile;
        else: 
        ?>
            <!-- Fallbacks -->
            <div class="testimonial-card reveal">
                <i class="fas fa-quote-right quote-icon"></i>
                <div class="stars"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></div>
                <p class="test-text">"Their door team completely changed our weekend crowd. Trouble gets handled before it becomes a scene — my licence has never felt safer."</p>
                <div class="client-info">
                    <h5>Rohit Malhotra</h5>
                    <span>Owner, Neon District Club</span>
                </div>
            </div>
            <div class="testimonial-card reveal">
                <i class="fas fa-quote-right quote-icon"></i>
                <div class="stars"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></div>
                <p class="test-text">"800 guests, including two ministerial families and a film star. The VIP protocol team managed arrivals, darshan-line escorts and exits flawlessly."</p>
                <div class="client-info">
                    <h5>Priya Sharma</h5>
                    <span>Wedding Planner</span>
                </div>
            </div>
            <div class="testimonial-card reveal">
                <i class="fas fa-quote-right quote-icon"></i>
                <div class="stars"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></div>
                <p class="test-text">"I book Bouncer Force for every product launch. Sharp uniforms, sharp manners — our executives and clients always comment on how professional they are."</p>
                <div class="client-info">
                    <h5>Daniel D'Souza</h5>
                    <span>Event Head, Vertex Media</span>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php
    $blog_query = "SELECT * FROM blogs WHERE status = 1 ORDER BY blog_id DESC LIMIT 3";
    $blog_result = $conn->query($blog_query);

    $gallery_query = "SELECT * FROM gallery ORDER BY ID DESC LIMIT 6";
    $gallery_result = $conn->query($gallery_query);

    $contact_query = "SELECT * FROM contacts LIMIT 1";
    $contact_result = $conn->query($contact_query);
    $contact_data = ($contact_result && $contact_result->num_rows > 0) ? $contact_result->fetch_assoc() : null;
?>

<!-- ================= BLOG / NEWS SECTION (Dynamic) ================= -->
<section class="section-padding bg-white" id="blog">
    <div class="section-header reveal">
        <span class="section-subtitle">Security Insights</span>
        <h2 class="section-title">Latest News & Updates</h2>
    </div>

    <div class="blog-grid">
        <?php 
        if ($blog_result && $blog_result->num_rows > 0): 
            while($blog = $blog_result->fetch_assoc()):
        ?>
            <div class="blog-card reveal">
                <!-- Check image path. Pre-pend your upload directory if needed -->
                <img src="admin/assets/img/uploads/blogs/<?php echo htmlspecialchars($blog['image']); ?>" alt="Blog Image" class="blog-img" onerror="this.src='https://images.unsplash.com/photo-1555596884-2195dfb8f2b7?q=80&w=600&auto=format&fit=crop';">
                <div class="blog-content">
                    <span class="blog-date"><?php echo date('M d, Y', strtotime($blog['created_at'])); ?></span>
                    <h3 class="blog-title"><?php echo htmlspecialchars($blog['title']); ?></h3>
                    <a href="blog-detail.php?slug=<?php echo $blog['slug']; ?>" class="blog-link">Read Article</a>
                </div>
            </div>
        <?php 
            endwhile;
        else: 
            // Fallback content for VIP Security
        ?>
            <div class="blog-card reveal">
                <img src="https://images.unsplash.com/photo-1555596884-2195dfb8f2b7?q=80&w=600&auto=format&fit=crop" alt="Security Event" class="blog-img">
                <div class="blog-content">
                    <span class="blog-date">Oct 12, 2026</span>
                    <h3 class="blog-title">How to Secure High-Profile Corporate Events</h3>
                    <a href="#" class="blog-link">Read Article</a>
                </div>
            </div>
            <div class="blog-card reveal">
                <img src="https://images.unsplash.com/photo-1517457373958-b7bdd4587205?q=80&w=600&auto=format&fit=crop" alt="VIP Escort" class="blog-img">
                <div class="blog-content">
                    <span class="blog-date">Sep 28, 2026</span>
                    <h3 class="blog-title">The Importance of Discreet Close Protection</h3>
                    <a href="#" class="blog-link">Read Article</a>
                </div>
            </div>
            <div class="blog-card reveal">
                <img src="https://images.unsplash.com/photo-1549497552-32b00f5abcc0?q=80&w=600&auto=format&fit=crop" alt="Crowd Control" class="blog-img">
                <div class="blog-content">
                    <span class="blog-date">Sep 15, 2026</span>
                    <h3 class="blog-title">Advanced Crowd Control Tactics for Festivals</h3>
                    <a href="#" class="blog-link">Read Article</a>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- ================= GALLERY SECTION (Dynamic) ================= -->
<section class="section-padding bg-light-grey" id="gallery">
    <div class="section-header reveal">
        <span class="section-subtitle">Our Operations</span>
        <h2 class="section-title">Bouncer Force in Action</h2>
    </div>

    <div class="gallery-grid">
        <?php 
        if ($gallery_result && $gallery_result->num_rows > 0): 
            while($img = $gallery_result->fetch_assoc()):
        ?>
            <div class="gallery-item reveal">
                <img src="<?php echo htmlspecialchars($img['image_path']); ?>" alt="<?php echo htmlspecialchars($img['image_name']); ?>" class="gallery-img" onerror="this.src='https://images.unsplash.com/photo-1582139329536-e7284fece509?q=80&w=600&auto=format&fit=crop';">
                <div class="gallery-overlay">
                    <i class="fas fa-search-plus"></i>
                </div>
            </div>
        <?php 
            endwhile;
        else: 
            // Fallback images
            for($i=1; $i<=3; $i++):
        ?>
            <div class="gallery-item reveal">
                <img src="https://images.unsplash.com/photo-1582139329536-e7284fece509?q=80&w=600&auto=format&fit=crop" alt="Event Security" class="gallery-img">
                <div class="gallery-overlay"><i class="fas fa-search-plus"></i></div>
            </div>
        <?php 
            endfor;
        endif; 
        ?>
    </div>
</section>

<!-- ================= CONTACT / INQUIRY SECTION (Dynamic Map) ================= -->
<section class="section-padding bg-white" id="contact">
    <div class="section-header reveal">
        <span class="section-subtitle">Hire Us</span>
        <h2 class="section-title">Secure Your Next Event</h2>
    </div>

    <div class="contact-container reveal">
        <!-- LEFT: Map Container -->
        <div class="contact-map">
            <?php 
                // Database se map fetch karna[cite: 2]
                $map_url = (!empty($contact_data['map'])) ? $contact_data['map'] : 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d111989.29383599345!2d77.39502834999999!3d28.69965315!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x390cf1bb41c50fdf%3A0xe6f06fd26a7798ba!2sGhaziabad%2C%20Uttar%20Pradesh!5e0!3m2!1sen!2sin!4v1788933014704!5m2!1sen!2sin';
            ?>
            <iframe src="<?php echo $map_url; ?>" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>

        <!-- RIGHT: Form Container -->
        <div class="contact-form-wrap">
            <h3>Let's Lock In Your Security</h3>
            <p>Tell us about your event and our coordinator will reply within minutes.</p>
            
            <!-- Adjust action attribute to your backend form handler -->
            <form action="submit_inquiry.php" method="POST">
                <div class="form-group">
                    <input type="text" name="name" class="form-control" placeholder="Your Name *" required>
                </div>
                <div class="form-group">
                    <input type="email" name="email" class="form-control" placeholder="Email Address *" required>
                </div>
                <div class="form-group">
                    <input type="tel" name="phone" class="form-control" placeholder="Phone Number *" required>
                </div>
                <div class="form-group">
                    <!-- Dropdown for VIP Service type -->
                    <select name="subject" class="form-control" required>
                        <option value="" disabled selected>Event Type / Service Needed *</option>
                        <option value="Wedding / Baraat">Wedding / Baraat</option>
                        <option value="VIP Guest Management">VIP Guest Management</option>
                        <option value="Nightclub Security">Nightclub Security</option>
                        <option value="Corporate Event">Corporate Event</option>
                        <option value="Celebrity Protection">Celebrity Protection</option>
                    </select>
                </div>
                <div class="form-group">
                    <textarea name="message" class="form-control" rows="4" placeholder="Tell us more (Guest count, timings, special requirements)"></textarea>
                </div>
                <button type="submit" class="btn-submit">Send Enquiry Securely</button>
            </form>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'?>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const reveals = document.querySelectorAll(".reveal");

        const revealObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add("active");
                    observer.unobserve(entry.target); // Reveal only once
                }
            });
        }, {
            threshold: 0.1, // Trigger when 10% visible
            rootMargin: "0px 0px -50px 0px"
        });

        reveals.forEach(reveal => {
            revealObserver.observe(reveal);
        });
    });
</script>

<script src="https://unpkg.com/swiper@10/swiper-bundle.min.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        if(typeof Swiper !== 'undefined') {
            var swiper = new Swiper(".myHeroSwiper", {
                spaceBetween: 0,
                effect: "fade", 
                speed: 1000,    
                loop: true,
                autoplay: {
                    delay: 5000, 
                    disableOnInteraction: false,
                },
                navigation: {
                    nextEl: ".swiper-button-next",
                    prevEl: ".swiper-button-prev",
                },
                pagination: {
                    el: ".swiper-pagination",
                    clickable: true,
                    dynamicBullets: true,
                },
            });
        } else {
            console.error("Swiper JS load nahi hua. Check your internet or CDN link.");
        }
    });
</script>
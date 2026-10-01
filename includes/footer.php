<?php

include 'config/connect.php';

$footer_logo_query = "SELECT logo_path FROM logos WHERE location = 'header' AND is_active = 1 ORDER BY uploaded_at DESC LIMIT 1";
$footer_logo_result = $conn->query($footer_logo_query);
$footer_logo = ($footer_logo_result && $footer_logo_result->num_rows > 0) ? $footer_logo_result->fetch_assoc()['logo_path'] : '';

$contact_query = "SELECT * FROM contacts LIMIT 1";
$contact_result = $conn->query($contact_query);
$contact = ($contact_result && $contact_result->num_rows > 0) ? $contact_result->fetch_assoc() : [];

$footer_services_query = "SELECT id, service_name FROM services LIMIT 5";
$footer_services_result = $conn->query($footer_services_query);
?>

<footer class="premium-footer">
    <div class="footer-container">
        
        <div class="footer-brand">
            <?php if(!empty($footer_logo)): ?>
                <img src="admin/<?php echo htmlspecialchars($footer_logo); ?>" alt="Bouncer Force Footer Logo" class="footer-logo" onerror="this.style.display='none'">
            <?php endif; ?>
            
            <!-- Fallback text agar logo set na ho -->
            <div class="brand-name-text">Bouncer <span>Force</span></div>
            
            <p class="footer-desc">Elite bouncers and white-glove VIP guest management for events, venues, and the people who matter most at them.</p>
            
            <div class="social-links">
                <?php if(!empty($contact['facebook'])): ?>
                    <a href="<?php echo htmlspecialchars($contact['facebook']); ?>" target="_blank"><i class="fab fa-facebook-f"></i></a>
                <?php endif; ?>
                
                <?php if(!empty($contact['instagram'])): ?>
                    <a href="<?php echo htmlspecialchars($contact['instagram']); ?>" target="_blank"><i class="fab fa-instagram"></i></a>
                <?php endif; ?>
                
                <?php if(!empty($contact['twitter'])): ?>
                    <a href="<?php echo htmlspecialchars($contact['twitter']); ?>" target="_blank"><i class="fab fa-twitter"></i></a>
                <?php endif; ?>
                
                <?php if(!empty($contact['linkdin'])): ?>
                    <a href="<?php echo htmlspecialchars($contact['linkdin']); ?>" target="_blank"><i class="fab fa-linkedin-in"></i></a>
                <?php endif; ?>
            </div>
        </div>

        <!-- Column 2: Quick Links -->
        <div>
            <h4 class="footer-heading">Quick Links</h4>
            <ul class="footer-links">
                <li><a href="index.php">Home</a></li>
                <li><a href="about.php">About Us</a></li>
                <li><a href="services.php">Our Services</a></li>
                <li><a href="blog.php">Latest News</a></li>
                <li><a href="contact.php">Contact Us</a></li>
            </ul>
        </div>

        <!-- Column 3: Dynamic Services -->
        <div>
            <h4 class="footer-heading">Our Services</h4>
            <ul class="footer-links">
                <?php 
                if ($footer_services_result && $footer_services_result->num_rows > 0): 
                    while($f_service = $footer_services_result->fetch_assoc()):
                ?>
                    <li><a href="service-details.php?id=<?php echo $f_service['id']; ?>"><?php echo htmlspecialchars($f_service['service_name']); ?></a></li>
                <?php 
                    endwhile;
                else: 
                ?>
                    <li><a href="#">VIP Guest Management</a></li>
                    <li><a href="#">Celebrity Protection</a></li>
                    <li><a href="#">Event Bouncers</a></li>
                    <li><a href="#">Crowd Control</a></li>
                <?php endif; ?>
            </ul>
        </div>

        <!-- Column 4: Contact Information -->
        <div>
            <h4 class="footer-heading">Get In Touch</h4>
            <ul class="footer-contact-info">
                <li>
                    <i class="fas fa-map-marker-alt"></i>
                    <span>
                        <?php echo !empty($contact['address']) ? htmlspecialchars($contact['address']) : 'Bouncer Force Headquarters, New Delhi, India'; ?>
                    </span>
                </li>
                <li>
                    <i class="fas fa-phone-alt"></i>
                    <span>
                        <?php if(!empty($contact['phone'])): ?>
                            <a href="tel:<?php echo htmlspecialchars($contact['phone']); ?>" style="color: inherit; text-decoration: none;">
                                <?php echo htmlspecialchars($contact['phone']); ?>
                            </a>
                        <?php else: ?>
                            +91 98XXX XXXXX
                        <?php endif; ?>
                    </span>
                </li>
                <li>
                    <i class="fas fa-envelope"></i>
                    <span>
                        <?php if(!empty($contact['email'])): ?>
                            <a href="mailto:<?php echo htmlspecialchars($contact['email']); ?>" style="color: inherit; text-decoration: none;">
                                <?php echo htmlspecialchars($contact['email']); ?>
                            </a>
                        <?php else: ?>
                            info@bouncerforce.com
                        <?php endif; ?>
                    </span>
                </li>
                <li>
                    <i class="fas fa-clock"></i>
                    <span>
                        <?php echo !empty($contact['working_hours']) ? htmlspecialchars($contact['working_hours']) : 'Available 24x7 - 365 Days'; ?>
                    </span>
                </li>
            </ul>
        </div>

    </div>

    <div class="footer-bottom">
        <div class="footer-bottom-flex">
            <div class="copyright-text">
                &copy; <?php echo date("Y"); ?> <strong>Bouncer Force</strong>. All rights reserved.
            </div>
            <div class="developer-credit">
                Design & Developed by <a href="https://www.digitalwebtrackers.com" target="_blank">Digital Web Trackers</a>
            </div>
        </div>
    </div>
</footer>

</body>
</html>
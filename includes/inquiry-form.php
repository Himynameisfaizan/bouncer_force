<?php
$contact_query = "SELECT * FROM contacts LIMIT 1";
$contact_result = $conn->query($contact_query);
$contact_data = ($contact_result && $contact_result->num_rows > 0) ? $contact_result->fetch_assoc() : null;

$phone_clean = !empty($contact_data['phone']) ? preg_replace('/[^0-9]/', '', $contact_data['phone']) : '';

$pre_filled_service = isset($_GET['service']) ? htmlspecialchars($_GET['service']) : '';
?>

 <!-- ================= MAP & INQUIRY FORM ================= -->
    <div class="contact-container reveal">
        
        <!-- LEFT: MAP -->
        <div class="contact-map">
            <?php 
                $map_url = (!empty($contact_data['map'])) ? $contact_data['map'] : 'https://www.google.com/maps/embed?...'; // Default map here
            ?>
            <iframe src="<?php echo $map_url; ?>" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>

        <!-- RIGHT: PREMIUM FORM -->
        <div class="contact-form-wrap">
            <h3>Lock In Your <span>Security</span></h3>
            <p>Fill out the form below and our operations manager will contact you immediately for a confidential threat assessment.</p>
            
            <form action="submit_inquiry.php" method="POST">
                <div class="form-row">
                    <div class="form-group">
                        <input type="text" name="name" class="form-control" placeholder="Your Full Name *" required>
                    </div>
                    <div class="form-group">
                        <input type="tel" name="phone" class="form-control" placeholder="Phone Number *" required>
                    </div>
                </div>

                <div class="form-group" style="margin-top: -20px;">
                    <input type="email" name="email" class="form-control" placeholder="Email Address *" required>
                </div>
                
                <div class="form-group">
                    <select name="subject" class="form-control" required>
                        <option value="" disabled <?php echo empty($pre_filled_service) ? 'selected' : ''; ?>>Select Service Required *</option>
                        <option value="Event Bouncers" <?php echo ($pre_filled_service == 'event-bouncers') ? 'selected' : ''; ?>>Event Bouncers</option>
                        <option value="VIP Protection" <?php echo ($pre_filled_service == 'vip-protection') ? 'selected' : ''; ?>>VIP Protection & Escort</option>
                        <option value="Nightclub Security" <?php echo ($pre_filled_service == 'nightclub-security') ? 'selected' : ''; ?>>Nightclub / Bar Security</option>
                        <option value="Female Bouncers" <?php echo ($pre_filled_service == 'female-bouncers') ? 'selected' : ''; ?>>Female Bouncers</option>
                        <option value="Crowd Control" <?php echo ($pre_filled_service == 'crowd-control') ? 'selected' : ''; ?>>Crowd Control & Gate Mgmt</option>
                        <option value="Other / Custom Security" <?php echo ($pre_filled_service == 'other') ? 'selected' : ''; ?>>Other / Custom Security</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <textarea name="message" class="form-control" rows="5" placeholder="Tell us about your event, location, timings, and estimated crowd size..." required></textarea>
                </div>
                
                <button type="submit" class="btn-submit">Request Secure Quote <i class="fas fa-paper-plane" style="margin-left: 8px;"></i></button>
            </form>

            <!-- Dynamic Social Links Base on DB[cite: 2] -->
            <div class="contact-social">
                <span>Follow Us: </span>
                <div class="cs-links">
                    <?php if(!empty($contact_data['facebook'])): ?>
                        <a href="<?php echo htmlspecialchars($contact_data['facebook']); ?>" target="_blank"><i class="fab fa-facebook-f"></i></a>
                    <?php endif; ?>
                    <?php if(!empty($contact_data['instagram'])): ?>
                        <a href="<?php echo htmlspecialchars($contact_data['instagram']); ?>" target="_blank"><i class="fab fa-instagram"></i></a>
                    <?php endif; ?>
                    <?php if(!empty($contact_data['twitter'])): ?>
                        <a href="<?php echo htmlspecialchars($contact_data['twitter']); ?>" target="_blank"><i class="fab fa-twitter"></i></a>
                    <?php endif; ?>
                    <?php if(!empty($contact_data['linkdin'])): ?>
                        <a href="<?php echo htmlspecialchars($contact_data['linkdin']); ?>" target="_blank"><i class="fab fa-linkedin-in"></i></a>
                    <?php endif; ?>
                </div>
            </div>

        </div>
    </div>
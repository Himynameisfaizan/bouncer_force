<?php
include 'config/connect.php';
include 'includes/header.php';

$contact_query = "SELECT phone, wp_number FROM contacts LIMIT 1";
$contact_result = $conn->query($contact_query);
$contact_data = ($contact_result && $contact_result->num_rows > 0) ? $contact_result->fetch_assoc() : null;

$phone_clean = !empty($contact_data['phone']) ? preg_replace('/[^0-9]/', '', $contact_data['phone']) : '';
$display_phone = !empty($contact_data['phone']) ? $contact_data['phone'] : '+91 98XXX XXXXX';

$limit = 6; 
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;
$offset = ($page - 1) * $limit;

$search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';
$search_condition = "WHERE status = 1"; // Only active blogs
if (!empty($search)) {
    $search_condition .= " AND (title LIKE '%$search%' OR description LIKE '%$search%')";
}

$total_query = "SELECT COUNT(*) as total FROM blogs $search_condition";
$total_result = $conn->query($total_query);
$total_rows = ($total_result && $total_result->num_rows > 0) ? $total_result->fetch_assoc()['total'] : 0;
$total_pages = ceil($total_rows / $limit);

$blog_query = "SELECT * FROM blogs $search_condition ORDER BY blog_id DESC LIMIT $offset, $limit";
$blog_result = $conn->query($blog_query);

// Setup Breadcrumb
$pageTitle = "Security Insights";
$pageBreadcrumb = "Our Blog";
include 'includes/breadcrumb.php';
?>

<section class="blog-page-wrapper">
    <div class="bp-container">
        
        <!-- ================= LEFT: MAIN BLOG GRID ================= -->
        <div class="bp-main-content">
            <div class="bp-grid">
                <?php 
                if ($blog_result && $blog_result->num_rows > 0): 
                    while($blog = $blog_result->fetch_assoc()):
                        $slug = !empty($blog['slug']) ? $blog['slug'] : $blog['blog_id'];
                        $details_url = "blog-details.php?slug=" . htmlspecialchars($slug);
                ?>
                    <div class="premium-blog-card reveal">
                        <a href="<?php echo $details_url; ?>" class="pbc-img-wrap">
                            <img src="admin/assets/img/uploads/blogs/<?php echo htmlspecialchars($blog['image']); ?>" 
                                 alt="<?php echo htmlspecialchars($blog['title']); ?>"
                                 onerror="this.src='https://images.unsplash.com/photo-1555596884-2195dfb8f2b7?q=80&w=600&auto=format&fit=crop';">
                            
                            <!-- Floating Date -->
                            <div class="pbc-date-badge">
                                <?php echo date('M d, Y', strtotime($blog['created_at'])); ?>
                            </div>
                        </a>
                        
                        <div class="pbc-content">
                            <!-- Author Meta -->
                            <div class="pbc-meta">
                                <i class="fas fa-user-shield"></i> By <?php echo htmlspecialchars($blog['author']); ?>
                            </div>
                            
                            <!-- Title -->
                            <a href="<?php echo $details_url; ?>" class="pbc-title">
                                <?php echo htmlspecialchars($blog['title']); ?>
                            </a>
                            
                           <style>
    /* CSS Truncation (Fallback) */
    .blog-desc {
        color: #555;
        font-size: 15px;
        line-height: 1.6;
        margin-bottom: 15px;
        flex-grow: 1; /* Taki button hamesha bottom me align rahe */
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
    }
</style>

<!-- Blog description part inside your while loop -->
<div class="blog-desc">
    <?php 
        // 1. Sabse pehle &nbsp; aur dusre HTML entities ko normal space me convert karenge
        $decoded_text = html_entity_decode($blog['description'], ENT_QUOTES, 'UTF-8');
        
        // 2. Phir saare HTML tags (jaise <p>, <strong>) hata denge
        $clean_text = strip_tags($decoded_text);
        
        // 3. Phir PHP se strictly 120 characters par cut karke "..." laga denge (Exact 2-3 lines)
        if (mb_strlen($clean_text) > 120) {
            echo mb_substr($clean_text, 0, 120) . '...';
        } else {
            echo $clean_text;
        }
    ?>
</div>
                            
                            <div class="pbc-footer">
                                <a href="<?php echo $details_url; ?>" class="btn-read-more">
                                    Read Article <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php 
                    endwhile;
                else: 
                ?>
                    <!-- Fallback if no blogs found -->
                    <div class="bp-search-box" style="text-align: center; padding: 50px; grid-column: 1 / -1;">
                        <i class="fas fa-newspaper" style="font-size: 40px; color: #d4af37; margin-bottom: 15px;"></i>
                        <h4>No Articles Found</h4>
                        <p style="color: #666;">Try searching with a different keyword or check back later.</p>
                    </div>
                <?php endif; ?>
            </div>

            <!-- ================= PAGINATION ================= -->
            <?php if($total_pages > 1): ?>
                <div class="vip-pagination reveal">
                    <?php if($page > 1): ?>
                        <a href="blog.php?page=<?php echo ($page-1); ?>&search=<?php echo urlencode($search); ?>"><i class="fas fa-angle-left"></i></a>
                    <?php endif; ?>
                    
                    <?php for($i = 1; $i <= $total_pages; $i++): ?>
                        <a href="blog.php?page=<?php echo $i; ?>&search=<?php echo urlencode($search); ?>" class="<?php echo ($page == $i) ? 'active' : ''; ?>">
                            <?php echo $i; ?>
                        </a>
                    <?php endfor; ?>
                    
                    <?php if($page < $total_pages): ?>
                        <a href="blog.php?page=<?php echo ($page+1); ?>&search=<?php echo urlencode($search); ?>"><i class="fas fa-angle-right"></i></a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- ================= RIGHT: SIDEBAR ================= -->
        <div class="bp-sidebar">
            
            <!-- Search Widget -->
            <div class="bp-search-box reveal">
                <h4>Search Articles</h4>
                <form action="blog.php" method="GET" class="search-form">
                    <input type="text" name="search" class="search-input" placeholder="Type here..." value="<?php echo htmlspecialchars($search); ?>">
                    <button type="submit" class="search-btn"><i class="fas fa-search"></i></button>
                </form>
            </div>

            <!-- Request Quote Widget -->
            <div class="sp-quote-banner reveal">
                <h3>Require VIP Security?</h3>
                <p>Don't leave safety to chance. Speak to our deployment experts today for a custom threat assessment.</p>
                <a href="tel:<?php echo htmlspecialchars($phone_clean); ?>" class="sp-quote-phone">
                    <i class="fas fa-phone-alt"></i> <?php echo htmlspecialchars($display_phone); ?>
                </a>
            </div>

        </div>

    </div>
</section>

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
<?php
/**
 * Template Name: Bolly Landing Page
 *
 * A high-fidelity, interactive 3D landing page template for Bolly Shampoo,
 * matching the reference design layout, colors, and typography.
 */

// Disable standard WP header/footer, but call wp_head and wp_footer for plugin enqueues.
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Discover Bolly Clarify Shampoo - A premium botanical formula that cleanses deeply without stripping. Experience our interactive 3D bottle.">
    <title>Bolly | Clarify Shampoo - Premium Haircare</title>
    <?php wp_head(); ?>
    <style>
        /* Core Reset & Variables */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        :root {
            --bg-color: #f2f0f7; /* Soft light grey-lavender */
            --text-primary: #12131c; /* Almost black */
            --text-secondary: #5e6080;
            --accent-color: #8c88f9; /* Rich periwinkle purple-blue matching reference */
            --accent-hover: #736ef4;
            --badge-purple: #8c88f9;
            --lime-green: #cbf325; /* Lime green accent */
            --indigo-dark: #12131c;
            --card-bg: #ffffff;
            --border-color: rgba(18, 19, 28, 0.06);
            --transition-smooth: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
            --font-display: 'Outfit', sans-serif;
            --font-body: 'Inter', sans-serif;
            --font-serif: 'Playfair Display', Georgia, serif;
        }

        body {
            background-color: var(--bg-color);
            color: var(--text-primary);
            font-family: var(--font-body);
            overflow-x: hidden;
            line-height: 1.6;
            min-height: 100vh;
            -webkit-font-smoothing: antialiased;
        }

        /* Subtle Noise Grain Background Effect */
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            opacity: 0.045;
            z-index: 9999;
            pointer-events: none;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noiseFilter'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.65' numOctaves='3' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noiseFilter)'/%3E%3C/svg%3E");
        }

        /* Giant Background Circle Spotlight behind bottle */
        .bg-spotlight-circle {
            position: absolute;
            top: -25%;
            left: 12%;
            width: 76%;
            height: 94%;
            background: radial-gradient(circle, rgba(140, 136, 249, 0.22) 0%, rgba(242, 240, 247, 0) 70%);
            border-radius: 50%;
            z-index: 0;
            pointer-events: none;
        }

        a {
            color: inherit;
            text-decoration: none;
            transition: var(--transition-smooth);
        }

        /* Container */
        .container {
            max-width: 1440px;
            margin: 0 auto;
            padding: 0 4rem;
            position: relative;
            z-index: 1;
        }

        @media (max-width: 768px) {
            .container {
                padding: 0 1.5rem;
            }
        }

        /* Header Navigation */
        header {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1000;
            padding: 2.8rem 0 1.5rem;
        }

        .header-wrap {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .logo {
            font-family: var(--font-display);
            font-weight: 900;
            font-size: 2.5rem;
            letter-spacing: -0.06em; /* Slightly tighter letter spacing */
            color: var(--text-primary);
        }

        /* Centered Navigation Pill */
        .nav-pill-container {
            display: flex;
            align-items: center;
            background-color: var(--accent-color);
            padding: 0.35rem;
            border-radius: 40px;
            box-shadow: 0 10px 30px rgba(140, 136, 249, 0.25);
        }

        .nav-pill-item {
            font-family: var(--font-body);
            font-size: 0.85rem;
            font-weight: 700;
            color: rgba(255, 255, 255, 0.95);
            padding: 0.55rem 1.35rem;
            border-radius: 30px;
            transition: var(--transition-smooth);
        }

        .nav-pill-item:hover {
            color: #ffffff;
        }

        .nav-pill-item.active {
            background-color: rgba(255, 255, 255, 0.22);
            color: #ffffff;
        }

        @media (max-width: 900px) {
            .nav-pill-container {
                display: none;
            }
        }

        /* Cart Indicator */
        .cart-container {
            display: flex;
            align-items: center;
            gap: 0.8rem;
            cursor: pointer;
        }

        .cart-text {
            font-family: var(--font-body);
            font-weight: 800;
            font-size: 0.95rem;
            color: var(--text-primary);
            letter-spacing: 0.02em;
        }

        .cart-icon-circle {
            width: 44px;
            height: 44px;
            background-color: var(--lime-green);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 15px rgba(203, 243, 37, 0.25);
            transition: var(--transition-smooth);
        }

        .cart-container:hover .cart-icon-circle {
            transform: scale(1.05);
            box-shadow: 0 6px 20px rgba(203, 243, 37, 0.4);
        }

        /* Hero Section */
        .hero {
            padding: 11rem 0 3rem;
            min-height: 100vh;
            display: flex;
            align-items: center;
            position: relative;
        }

        .hero-grid {
            display: grid;
            grid-template-columns: 1.15fr 1.25fr 1.15fr;
            gap: 1rem;
            align-items: center;
            width: 100%;
        }

        @media (max-width: 991px) {
            .hero-grid {
                grid-template-columns: 1fr;
                gap: 3.5rem;
                text-align: center;
                padding-top: 2rem;
            }
        }

        /* Left Column: Heading */
        .hero-left {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            z-index: 5;
        }

        @media (max-width: 991px) {
            .hero-left {
                align-items: center;
            }
        }

        .root-badge {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-family: var(--font-display);
            font-size: 0.8rem;
            font-weight: 900;
            letter-spacing: 0.05em;
            margin-bottom: 2rem;
        }

        .root-text {
            color: var(--text-primary);
        }

        .shine-pill {
            background-color: var(--badge-purple);
            color: #ffffff;
            padding: 0.35rem 0.9rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 800;
            box-shadow: 0 4px 12px rgba(140, 136, 249, 0.25);
        }

        .hero-title {
            font-family: var(--font-display);
            font-size: clamp(4.2rem, 7.5vw, 7.4rem);
            line-height: 0.82;
            font-weight: 900;
            letter-spacing: -0.05em;
            color: var(--text-primary);
            text-transform: uppercase;
            text-align: left;
        }

        @media (max-width: 991px) {
            .hero-title {
                text-align: center;
            }
        }

        /* Center Column: 3D Canvas Showcase */
        .hero-center {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
            position: relative;
            z-index: 2;
        }

        .showcase-wrapper {
            position: relative;
            width: 100%;
            height: 640px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        @media (max-width: 991px) {
            .showcase-wrapper {
                height: 480px;
            }
        }

        .showcase-bg {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 95%;
            height: 95%;
            background: radial-gradient(circle, rgba(140, 136, 249, 0.22) 0%, rgba(243, 241, 247, 0) 70%);
            border-radius: 50%;
            z-index: 1;
            pointer-events: none;
        }

        .showcase-canvas-container {
            position: relative;
            width: 100%;
            height: 100%;
            z-index: 2;
        }

        /* Right Column: Copy & Separate Pill Buttons */
        .hero-right {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            text-align: right;
            z-index: 5;
            gap: 2.2rem;
        }

        @media (max-width: 991px) {
            .hero-right {
                align-items: center;
                text-align: center;
            }
        }

        .journey-text {
            font-family: var(--font-display); /* Using Outfit instead of Inter */
            font-size: 1.85rem; /* Larger, matching reference */
            font-weight: 900;
            color: var(--text-primary);
            max-width: 320px;
            line-height: 1.1; /* Tight line-height */
            letter-spacing: -0.02em;
        }

        .wonderful-text {
            font-family: var(--font-serif);
            font-style: italic;
            font-size: 1.95rem; /* Balanced italic serif */
            font-weight: 400;
        }

        /* EXPLORE MORE Separate Pill Button Structure */
        .explore-group {
            display: flex;
            align-items: center;
            gap: 0.65rem;
        }

        .explore-btn-pill {
            background-color: var(--indigo-dark);
            color: #ffffff;
            padding: 0.88rem 2rem;
            border-radius: 40px;
            font-family: var(--font-display);
            font-weight: 800;
            font-size: 0.8rem;
            letter-spacing: 0.08em;
            box-shadow: 0 10px 30px rgba(18, 19, 28, 0.15);
            transition: var(--transition-smooth);
        }

        .explore-btn-pill:hover {
            background-color: #242535;
            transform: translateY(-2px);
            box-shadow: 0 15px 35px rgba(18, 19, 28, 0.25);
        }

        .explore-arrow-circle {
            width: 52px;
            height: 52px;
            background-color: var(--badge-purple); /* Periwinkle blue-purple */
            color: #ffffff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.35rem;
            font-weight: bold;
            box-shadow: 0 10px 30px rgba(140, 136, 249, 0.18);
            transition: var(--transition-smooth);
        }

        .explore-arrow-circle:hover {
            background-color: var(--accent-hover);
            transform: rotate(45deg) scale(1.05);
            box-shadow: 0 15px 35px rgba(140, 136, 249, 0.28);
        }

        /* Ingredients / Benefits Section */
        .ingredients-sec {
            padding: 8rem 0;
            background: #ffffff;
            border-top: 1px solid var(--border-color);
            border-bottom: 1px solid var(--border-color);
        }

        .section-header {
            text-align: center;
            max-width: 600px;
            margin: 0 auto 5rem;
        }

        .section-badge {
            display: inline-block;
            background-color: rgba(140, 136, 249, 0.08);
            color: var(--accent-color);
            font-family: var(--font-display);
            font-size: 0.75rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            padding: 0.35rem 0.9rem;
            border-radius: 20px;
            margin-bottom: 1rem;
        }

        .section-title {
            font-family: var(--font-display);
            font-size: 2.6rem;
            font-weight: 800;
            color: var(--text-primary);
            letter-spacing: -0.02em;
        }

        .section-sub {
            color: var(--text-secondary);
            font-size: 1rem;
            margin-top: 0.8rem;
        }

        .grid-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 3rem;
        }

        .card {
            background: linear-gradient(135deg, #ffffff 0%, #f9f8fc 100%);
            padding: 3.5rem 2.5rem 3rem;
            border-radius: 24px;
            border: 1px solid rgba(140, 136, 249, 0.12);
            transition: all 0.5s cubic-bezier(0.16, 1, 0.3, 1);
            display: flex;
            flex-direction: column;
            gap: 1.2rem;
            position: relative;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(18, 19, 28, 0.015);
        }

        .card::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, #8c88f9, #311a8c);
            opacity: 0;
            transition: opacity 0.4s ease;
        }

        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 30px 60px rgba(140, 136, 249, 0.1);
            border-color: rgba(140, 136, 249, 0.3);
        }

        .card:hover::before {
            opacity: 1;
        }

        .card-number {
            position: absolute;
            top: 2.2rem;
            right: 2.5rem;
            font-family: var(--font-display);
            font-size: 2.6rem;
            font-weight: 900;
            color: rgba(140, 136, 249, 0.12);
            line-height: 1;
            user-select: none;
        }

        .card-icon-wrap {
            width: 64px;
            height: 64px;
            background: rgba(140, 136, 249, 0.08);
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .card:hover .card-icon-wrap {
            background: var(--accent-color);
            transform: scale(1.08) rotate(5deg);
            box-shadow: 0 10px 22px rgba(140, 136, 249, 0.22);
        }

        .card-title {
            font-family: var(--font-display);
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--text-primary);
            letter-spacing: -0.015em;
            margin-top: 0.5rem;
        }

        .card-desc {
            color: var(--text-secondary);
            font-size: 0.98rem;
            line-height: 1.8;
        }

        /* Testimonial Section */
        .testimonial-sec {
            padding: 9rem 0;
            text-align: center;
            background-color: var(--bg-color);
        }

        .testimonial-wrap {
            max-width: 850px;
            margin: 0 auto;
            position: relative;
        }

        .quote-icon {
            font-family: var(--font-display);
            font-size: 7rem;
            color: rgba(140, 136, 249, 0.1);
            line-height: 1;
            margin-bottom: -1.5rem;
        }

        .testimonial-text {
            font-family: var(--font-serif);
            font-style: italic;
            font-size: 2rem;
            font-weight: 400;
            line-height: 1.5;
            color: var(--text-primary);
            margin-bottom: 2.5rem;
        }

        .testimonial-author {
            font-family: var(--font-body);
            font-weight: 700;
            color: var(--accent-color);
            letter-spacing: 0.05em;
            text-transform: uppercase;
            font-size: 0.9rem;
        }

        /* Footer */
        footer {
            background-color: var(--indigo-dark);
            color: rgba(255, 255, 255, 0.6);
            padding: 5rem 0 2.5rem;
            font-size: 0.9rem;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: 1.5fr repeat(3, 1fr);
            gap: 3rem;
            margin-bottom: 4rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            padding-bottom: 4rem;
        }

        @media (max-width: 768px) {
            .footer-grid {
                grid-template-columns: 1fr;
                gap: 2.5rem;
            }
        }

        .footer-logo {
            font-family: var(--font-display);
            font-weight: 900;
            font-style: italic;
            font-size: 2.2rem;
            color: #ffffff;
            margin-bottom: 1rem;
        }

        .footer-col h4 {
            color: #ffffff;
            font-family: var(--font-display);
            font-weight: 700;
            margin-bottom: 1.4rem;
            font-size: 1.05rem;
        }

        .footer-col ul {
            list-style: none;
        }

        .footer-col ul li {
            margin-bottom: 0.9rem;
        }

        .footer-col ul li a:hover {
            color: #ffffff;
        }

        .footer-bottom {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1.2rem;
        }

        /* Responsive Flow overrides */
        @media (max-width: 991px) {
            .hero-left {
                order: 2;
            }
            .hero-center {
                order: 1;
            }
            .hero-right {
                order: 3;
                margin-top: 1rem;
            }
        }
    </style>
</head>
<body <?php body_class(); ?>>

    <!-- Giant Background Circle Spotlight behind bottle -->
    <div class="bg-spotlight-circle"></div>

    <!-- Header Navigation -->
    <header>
        <div class="container header-wrap">
            <a href="#" class="logo">bolly</a>
            
            <div class="nav-pill-container">
                <a href="#shop" class="nav-pill-item active">Shop +</a>
                <a href="#benefits" class="nav-pill-item">About</a>
                <a href="#ingredients" class="nav-pill-item">Blog</a>
                <a href="#reviews" class="nav-pill-item">Contact</a>
            </div>

            <div class="cart-container" onclick="alert('Viewing cart...');">
                <span class="cart-text">Cart</span>
                <div class="cart-icon-circle">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#1E1F38" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg>
                </div>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero">
        <div class="container hero-grid">
            
            <!-- Left Column: Badge and Headline -->
            <div class="hero-left">
                <div class="root-badge">
                    <span class="root-text">FROM ROOT</span>
                    <span class="shine-pill">TO SHINE</span>
                </div>
                <h1 class="hero-title">
                    KNOCK<br>
                    OUT<br>
                    FLAKES
                </h1>
            </div>

            <!-- Center Column: 3D Showcase -->
            <div class="hero-center">
                <div class="showcase-wrapper">
                    <div class="showcase-bg"></div>
                    <div class="showcase-canvas-container">
                        <?php echo do_shortcode( '[bolly_3d_product]' ); ?>
                    </div>
                </div>
            </div>

            <!-- Right Column: Paragraph and Button -->
            <div class="hero-right">
                <p class="journey-text">
                    Journey in to the <span class="wonderful-text">wonderful</span> world of shampoo
                </p>
                <div class="explore-group">
                    <a href="#explore" class="explore-btn-pill" onclick="alert('Exploring products below!'); return false;">EXPLORE MORE</a>
                    <a href="#explore" class="explore-arrow-circle" onclick="alert('Exploring products below!'); return false;">&nearr;</a>
                </div>
            </div>

        </div>
    </section>

    <!-- Benefits / Ingredients Section -->
    <section class="ingredients-sec" id="benefits">
        <div class="container">
            <div class="section-header">
                <span class="section-badge">Formulated with Care</span>
                <h2 class="section-title">The Clarify Formula</h2>
                <p class="section-sub">We believe in complete ingredient transparency. Each bottle of bolly is packed with active organic botanicals.</p>
            </div>
            
            <div class="grid-cards" id="ingredients">
                <!-- Card 1 -->
                <div class="card">
                    <div class="card-number">01</div>
                    <div class="card-icon-wrap">
                        <span class="card-icon">🌿</span>
                    </div>
                    <h3 class="card-title">French Sea Kelp</h3>
                    <p class="card-desc">Rich in essential vitamins and minerals that gently draw out impurities, build-up, and excess sebum while restoring mineral balance to the scalp.</p>
                </div>
                <!-- Card 2 -->
                <div class="card">
                    <div class="card-number">02</div>
                    <div class="card-icon-wrap">
                        <span class="card-icon">🥑</span>
                    </div>
                    <h3 class="card-title">Organic Avocado Oil</h3>
                    <p class="card-desc">Rich in oleic acid and monounsaturated fats. Easily penetrates the hair shaft to provide deep hydration, leaving strands glossy and soft.</p>
                </div>
                <!-- Card 3 -->
                <div class="card">
                    <div class="card-number">03</div>
                    <div class="card-icon-wrap">
                        <span class="card-icon">🍊</span>
                    </div>
                    <h3 class="card-title">Citrus Bergamia</h3>
                    <p class="card-desc">A natural clarify agent that cuts through styling product build-up and environmental pollutants, leaving a crisp, refreshing natural scent.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonial Section -->
    <section class="testimonial-sec" id="reviews">
        <div class="container">
            <div class="testimonial-wrap">
                <div class="quote-icon">“</div>
                <blockquote class="testimonial-text">
                    This is the first clarifying shampoo that doesn't leave my hair feeling like dry straw. It feels soft, weightless, and has an incredible organic shine. A pure game changer.
                </blockquote>
                <cite class="testimonial-author">— Sarah Jenkins, Professional Stylist</cite>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="footer-grid">
                <div class="footer-col">
                    <div class="footer-logo">bolly</div>
                    <p style="margin-top: 1rem; line-height: 1.7; max-width: 250px;">Elevating organic hair wellness through clean, luxury formulations.</p>
                </div>
                <div class="footer-col">
                    <h4>Shop</h4>
                    <ul>
                        <li><a href="#">Clarifying Shampoo</a></li>
                        <li><a href="#">Hydrating Conditioner</a></li>
                        <li><a href="#">Scalp Serum</a></li>
                        <li><a href="#">Travel Sets</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h4>Company</h4>
                    <ul>
                        <li><a href="#">Our Story</a></li>
                        <li><a href="#">Sustainability</a></li>
                        <li><a href="#">Press</a></li>
                        <li><a href="#">Careers</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h4>Support</h4>
                    <ul>
                        <li><a href="#">Contact Us</a></li>
                        <li><a href="#">FAQs</a></li>
                        <li><a href="#">Shipping & Returns</a></li>
                        <li><a href="#">Store Locator</a></li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; <?php echo date('Y'); ?> bolly. All rights reserved.</p>
                <div style="display: flex; gap: 1.5rem;">
                    <a href="#">Privacy Policy</a>
                    <a href="#">Terms of Service</a>
                </div>
            </div>
        </div>
    </footer>

    <?php wp_footer(); ?>
</body>
</html>

<?php require_once('header.php'); ?>

<style>
    /* ==========================================================================
       GENERAL & UTILITIES (REVISED)
       ========================================================================== */
    .section-padding { padding: 76px 0; }
    .bg-light-gray { background-color: #f8f9fa; }
    .pb-0 { padding-bottom: 0 !important; }
    
    
.section-title {
        font-size: clamp(28px, 3.2vw, 36px);
        font-weight: 800;
        line-height: 1.2;
        margin-bottom: 16px;
        color: #1a1a1a;
        letter-spacing: -0.3px;
    }
    .section-subtitle {
        font-size: 15px;
        color: #666;
        line-height: 1.7;
    }

    /* Memastikan container tidak menabrak batas layar (selaras dengan pola index.php) */
    .container-custom {
        width: 100% !important;
        max-width: 1180px !important;
        margin-left: auto !important;
        margin-right: auto !important;
        padding-left: 28px !important;
        padding-right: 28px !important;
    }

    /* Force Flexbox Row untuk mengatasi float issues di Bootstrap lawas */
    .flex-row-custom {
        display: flex;
        flex-wrap: wrap;
        margin-left: -15px;
        margin-right: -15px;
    }
    .flex-col-custom {
        padding-left: 15px;
        padding-right: 15px;
        display: flex;
        flex-direction: column;
    }

    /* ==========================================================================
       HERO SECTION
       ========================================================================== */
    .about-hero {
        position: relative;
        min-height: 560px;
        padding: 160px 0 100px;
        background-color: #111;
        color: #fff;
        display: flex;
        align-items: center;
    }
    .about-hero-bg {
        position: absolute;
        top: 0; left: 0;
        width: 100%; height: 100%;
        object-fit: cover;
        opacity: 0.35;
    }
    .about-hero .container-custom { position: relative; z-index: 2; }
.about-hero h1 {
        font-size: clamp(34px, 4vw, 48px);
        font-weight: 900;
        line-height: 1.15;
        margin: 0 0 24px;
        color: #fff;
        letter-spacing: -0.5px;
    }
    .about-hero p {
        font-size: clamp(16px, 1.8vw, 20px);
        max-width: 650px;
        margin: 0 0 40px;
        line-height: 1.7;
        color: #f1f1f1;
    }
    .hero-actions {
        display: flex; flex-wrap: wrap; gap: 15px;
    }
    
    .btn-brand-orange, .btn-glass {
        padding: 14px 36px;
        font-size: 16px; 
        font-weight: 700;
        border-radius: 6px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        text-decoration: none !important; 
        transition: all 0.3s ease;
    }
    .btn-brand-orange {
        background: linear-gradient(135deg, #ff9f1c 0%, #ff7a00 52%, #e65c00 100%);
        color: #fff !important;
        border: none;
        box-shadow: 0 4px 15px rgba(255, 122, 0, 0.3);
    }
    .btn-brand-orange:hover {
        background: linear-gradient(135deg, #e65c00 0%, #cc4a00 100%);
        transform: translateY(-2px);
    }
    .btn-glass {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(5px);
        color: #fff !important;
        border: 2px solid rgba(255, 255, 255, 0.8);
    }
    .btn-glass:hover {
        background: #fff; color: #111 !important;
    }

    /* ==========================================================================
       HERITAGE SECTION (PERBAIKAN TAMPILAN GAMBAR)
       ========================================================================== */
    .heritage-section .eyebrow {
        color: #ff7a00; text-transform: uppercase;
        letter-spacing: 3px; font-size: 13px;
        font-weight: 800; margin-bottom: 16px;
        display: block;
    }
    .heritage-text-col { 
        padding-right: 50px; 
        justify-content: center;
    }
    .heritage-section p.desc { 
        margin-bottom: 24px; 
        font-size: 16px;
        color: #555;
    }
    
    .stats-row {
        display: flex;
        gap: 20px;
        margin-top: 30px;
    }
    .stats-box {
        flex: 1;
        border: 1px solid #eaeaea;
        padding: 24px 20px;
        border-radius: 12px;
        background: #fff;
        box-shadow: 0 4px 20px rgba(0,0,0,0.03);
    }
    .stats-box h3 {
        color: #ff7a00; font-weight: 800;
        margin: 0 0 8px 0;
        font-size: 32px;
        line-height: 1;
    }
    .stats-box p {
        font-size: 12px; text-transform: uppercase;
        color: #888; margin: 0; font-weight: 700;
        letter-spacing: 0.5px;
    }

    .image-split-container {
        position: relative; 
        height: 450px;
        width: 100%;
        border-radius: 12px; 
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }
    .image-split-container img {
        width: 100%; height: 100%; object-fit: cover;
    }
    .year-label {
        position: absolute; bottom: 20px; color: #fff;
        font-weight: 700; font-size: 22px;
        text-shadow: 1px 1px 5px rgba(0,0,0,0.8);
    }
    .year-left { left: 20px; }
    .year-right { right: 20px; }
    
    .quote-box {
        position: absolute; bottom: -24px; right: -24px;
        background: #fff; padding: 26px 28px;
        border-left: 4px solid #ff7a00;
        box-shadow: 0 10px 20px rgba(0,0,0,0.15);
        border-radius: 8px; max-width: 300px;
        font-style: italic; z-index: 3;
        color: #555; font-size: 15px; line-height: 1.7;
    }

    /* ==========================================================================
       CORE VALUES SECTION (BENTO GRID)
       ========================================================================== */
    .bento-row {
        margin-bottom: 24px;
    }
    .bento-card {
        border-radius: 16px;
        padding: 40px;
        height: 100%; 
        display: flex;
        flex-direction: column;
        justify-content: center;
        position: relative;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0,0,0,0.04);
        transition: transform 0.3s ease;
    }
    .bento-card:hover {
        transform: translateY(-5px);
    }
    .bento-card i {
        font-size: 32px;
        margin-bottom: 24px;
    }
    .bento-card h3 {
        font-size: 24px;
        font-weight: 800;
        margin-top: 0;
        margin-bottom: 16px;
    }
    .bento-card p {
        font-size: 16px; line-height: 1.7; margin: 0;
    }
    
    /* Variants */
    .card-orange {
        background: linear-gradient(135deg, #ff8c00 0%, #e65c00 100%);
        color: #fff;
    }
    .card-orange i { color: #fff; }
    .card-orange h3 { color: #fff !important; }
    .card-orange p { color: rgba(255,255,255,0.9); }
    
    .card-white {
        background: #fff; border: 1px solid #f0f0f0; color: #222;
    }
    .card-white i { color: #ff7a00; }
    .card-white p { color: #666; }

    .card-dark {
        background: #3a3937; color: #fff;
        padding-right: 45%; 
    }
    .card-dark i { color: #fff; }
    .card-dark h3 { color: #fff !important; }
    .card-dark p { color: #dcdcdc; }
    .card-dark .bento-img {
        position: absolute;
        top: 24px; bottom: 24px; right: 24px;
        width: 38%;
        height: calc(100% - 48px);
        border-radius: 12px;
        object-fit: cover;
        box-shadow: -5px 0 20px rgba(0,0,0,0.2);
    }

/* ==========================================================================
       JOURNEY OF GROWTH SECTION
       ========================================================================== */
    .journey-header {
        display: flex; justify-content: space-between; align-items: flex-end;
        margin-bottom: 50px;
    }
    .journey-nav button {
        background: #fff; border: 1px solid #e0e0e0;
        width: 44px; height: 44px; border-radius: 50%;
        font-size: 16px; color: #333; margin-left: 10px;
        transition: 0.3s;
        box-shadow: 0 4px 10px rgba(0,0,0,0.05);
    }
    .journey-nav button:hover {
        border-color: #ff7a00; color: #fff; background: #ff7a00;
    }
    
    .milestone-card {
        background: #fff;
        padding: 0;
        border-radius: 16px;
        border: 1px solid #f0f0f0;
        height: 100%;
        overflow: hidden;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .milestone-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 12px 35px rgba(0,0,0,0.1);
    }
    .milestone-card .milestone-img-wrap {
        position: relative;
        height: 200px;
        overflow: hidden;
    }
    .milestone-card .milestone-img-wrap img {
        display: block;
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    .milestone-card:hover .milestone-img-wrap img {
        transform: scale(1.08);
    }
    .milestone-card .milestone-year-badge {
        position: absolute;
        top: 16px;
        left: 16px;
        background: #ff7a00;
        color: #fff;
        font-size: 18px;
        font-weight: 800;
        padding: 6px 16px;
        border-radius: 6px;
        line-height: 1.2;
        box-shadow: 0 4px 12px rgba(255,122,0,0.4);
    }
    .milestone-card .milestone-body {
        padding: 24px 20px 28px;
    }
    .milestone-card h4 {
        font-size: 18px;
        font-weight: 800;
        margin: 0 0 10px;
        color: #222;
    }
    .milestone-card p {
        font-size: 14px;
        color: #666;
        line-height: 1.7;
        margin: 0;
    }

    /* ==========================================================================
       EXECUTIVE LEADERSHIP
       ========================================================================== */
    .leader-card { 
        margin-bottom: 40px; text-align: center; 
    }
    .leader-img-wrapper {
        border-radius: 16px;
        overflow: hidden;
        margin-bottom: 20px;
        position: relative;
    }
    .leader-card img {
        width: 100%; aspect-ratio: 4/5; object-fit: cover;
        filter: grayscale(100%); transition: filter 0.4s ease, transform 0.4s ease;
        display: block;
    }
    .leader-card:hover img { 
        filter: grayscale(0%);
        transform: scale(1.05);
    }
    .leader-card h4 {
        font-size: 20px; font-weight: 800; margin-bottom: 6px; color: #222;
    }
    .leader-card p { font-size: 15px; color: #ff7a00; margin: 0; font-weight: 600;}

    /* ==========================================================================
       CTA SECTION
       ========================================================================== */
    .cta-banner {
        background-color: #d96a00;
        background-image:
            radial-gradient(circle, rgba(255,255,255,0.10) 1.5px, transparent 1.5px),
            linear-gradient(135deg, #c05c00 0%, #ff7a00 100%);
        background-size: 30px 30px, auto;
        border-radius: 24px;
        padding: 70px 40px;
        text-align: center;
        color: #fff;
        margin-bottom: 80px;
        position: relative;
        overflow: hidden;
        box-shadow: 0 20px 40px rgba(255, 122, 0, 0.2);
    }
    .cta-banner::before {
        content: ''; position: absolute;
        top: -50%; left: -50%; width: 200%; height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.15) 0%, transparent 60%);
        z-index: 1; pointer-events: none;
    }
    .cta-banner-content { position: relative; z-index: 2; }
    .cta-banner h2 { font-size: 36px; font-weight: 800; margin-bottom: 16px; color: #fff;}
    .cta-banner p { font-size: 18px; margin-bottom: 32px; color: rgba(255,255,255,0.9); max-width: 600px; margin-left: auto; margin-right: auto;}
    .cta-actions { display: flex; justify-content: center; gap: 16px; flex-wrap: wrap; }
    
    .cta-actions .btn {
        padding: 14px 32px; font-weight: 700; border-radius: 6px; font-size: 16px;
        transition: 0.3s; border: none; text-decoration: none;
    }
    .btn-white { background: #fff; color: #d95f00 !important; }
    .btn-white:hover { background: #f8f8f8; transform: translateY(-2px); }
    .btn-orange-outline { 
        background: transparent; color: #fff !important; 
        border: 2px solid #fff !important; 
    }
    .btn-orange-outline:hover { background: #fff; color: #d95f00 !important; transform: translateY(-2px); }

    /* CTA Section: dekatkan jarak dengan section di atasnya */
    .cta-section.section-padding { padding-top: 60px; }

    /* ==========================================================================
       RESPONSIVE ADJUSTMENTS
       ========================================================================== */
    @media only screen and (max-width: 991px) {
        .section-padding { padding: 58px 0; }
        .heritage-text-col { padding-right: 15px; margin-bottom: 50px; }
        .image-split-container { height: 400px; }
        .quote-box { right: 20px; bottom: -20px; width: 250px; }
        
        .card-dark { padding-right: 40px; }
        .card-dark .bento-img { display: none; }
        
        .bento-card { margin-bottom: 24px; }
        
        .journey-header { flex-direction: column; align-items: flex-start; }
        .journey-nav { margin-top: 20px; }
        .milestone-col { margin-bottom: 30px; }
    }

    @media only screen and (max-width: 767px) {
        .section-padding { padding: 70px 0; }
        .about-hero { padding: 120px 0 80px; min-height: auto; }
        .hero-actions { flex-direction: column; width: 100%; }
        .btn-brand-orange, .btn-glass { width: 100%; }
        
        .stats-row { flex-direction: column; gap: 15px; }
        .image-split-container { height: 350px; margin-top: 20px; }
        .quote-box { position: static; width: 100%; margin-top: 20px; box-shadow: none; border: 1px solid #eee; border-left: 5px solid #ff7a00; }
        
        .flex-col-custom { width: 100%; }
        
        .cta-banner { padding: 50px 20px; }
        .cta-actions .btn { width: 100%; }
    }
</style>

<!-- Hero Section -->
<section class="about-hero">
    <img src="https://images.unsplash.com/photo-1542838132-92c53300491e?q=80&w=1974&auto=format&fit=crop" class="about-hero-bg" alt="Hero Background">
    <div class="container container-custom">
        <h1 class="wow fadeInUp">Rumah Belanja Terpercaya</h1>
        <p class="wow fadeInUp" data-wow-delay="0.15s">Building Indonesia's retail legacy through trust, quality, and a commitment to serving every family since our very first store.</p>
        <div class="hero-actions wow fadeInUp" data-wow-delay="0.3s">
            <a href="#legacy" class="btn-brand-orange">Our Legacy</a>
            <a href="#vision" class="btn-glass">Vision & Mission</a>
        </div>
    </div>
</section>

<!-- Heritage Section -->
<section id="legacy" class="section-padding bg-white">
    <div class="container container-custom">
        <!-- Ditambahkan align-items: center agar kolom mengikuti tinggi gambar, tidak memanjang ke bawah -->
        <div class="flex-row-custom" style="align-items: center;">
            
            <!-- Left Text -->
            <div class="col-md-6 col-sm-12 flex-col-custom heritage-text-col wow fadeInLeft">
                <span class="eyebrow">OUR HERITAGE</span>
                <h2 class="section-title">Built on Foundation of Trust and Excellence</h2>
                <p class="section-subtitle desc">Founded with a vision to revolutionize the shopping experience in Indonesia, Manna Kampus began as a small family venture dedicated to providing quality goods at fair prices. Over the decades, we have evolved into a national benchmark for retail excellence.</p>
                <p class="section-subtitle desc">Our journey is marked by a deep understanding of Indonesian households. We don't just sell products; we create spaces where families feel at home. From our selection of fresh local produce to international luxury goods, every item on our shelves is a testament to our commitment to quality.</p>
                
                <div class="stats-row">
                    <div class="stats-box">
                        <h3>35+</h3>
                        <p>Years of Service</p>
                    </div>
                    <div class="stats-box">
                        <h3>120k+</h3>
                        <p>Daily Customers</p>
                    </div>
                </div>
            </div>
            
            <!-- Right Image Split -->
            <div class="col-md-6 col-sm-12 flex-col-custom wow fadeInRight">
                <div style="position: relative;">
                    <div class="image-split-container">
                        <img src="https://images.unsplash.com/photo-1604719312566-8912e9227c6a?q=80&w=1974&auto=format&fit=crop" alt="Manna Kampus History">
                        <div class="year-label year-left">1988</div>
                        <div class="year-label year-right">2026</div>
                    </div>
                    <div class="quote-box">
                        "Rooted in tradition, reaching for the future of retail."
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- Core Values Section (Bento Grid) -->
<section id="vision" class="section-padding bg-light-gray">
    <div class="container container-custom">
        
        <div class="text-center" style="margin-bottom: 60px;">
            <h2 class="section-title wow fadeInUp">Our Core Values</h2>
            <p class="section-subtitle wow fadeInUp" data-wow-delay="0.15s" style="max-width: 650px; margin: 0 auto;">The guiding principles that drive our growth and define our identity as <br> Rumah Belanja Terpercaya.</p>
        </div>

        <!-- Row 1 -->
        <div class="flex-row-custom bento-row">
            <div class="col-md-8 col-sm-12 flex-col-custom">
                <div class="bento-card card-orange wow fadeInUp">
                    <i class="fa fa-eye"></i>
                    <h3>Our Vision</h3>
                    <p>To be the most trusted and preferred retail destination in Indonesia, enriching lives by delivering unparalleled value, convenience, and a sense of community to every household we serve.</p>
                </div>
            </div>
            <div class="col-md-4 col-sm-12 flex-col-custom">
                <div class="bento-card card-white wow fadeInUp" data-wow-delay="0.2s">
                    <i class="fa fa-shield"></i>
                    <h3>Integrity</h3>
                    <p>Honesty in every transaction and transparency in every process is how we've built decades of trust with our customers.</p>
                </div>
            </div>
        </div>

        <!-- Row 2 -->
        <div class="flex-row-custom bento-row">
            <div class="col-md-4 col-sm-12 flex-col-custom">
                <div class="bento-card card-white wow fadeInUp" data-wow-delay="0.15s">
                    <i class="fa fa-rocket"></i>
                    <h3>Innovation</h3>
                    <p>Continuously evolving our retail technology and logistics to make shopping more seamless for the modern Indonesian family.</p>
                </div>
            </div>
            <div class="col-md-8 col-sm-12 flex-col-custom">
                <div class="bento-card card-dark wow fadeInUp" data-wow-delay="0.3s">
                    <i class="fa fa-users"></i>
                    <h3>Community First</h3>
                    <p>We are more than a store; we are a community partner. Supporting local farmers, artisans, and MSMEs is at the heart of our sourcing strategy.</p>
<img src="https://images.unsplash.com/photo-1488459716781-31db52582fe9?q=80&w=600&auto=format&fit=crop" class="bento-img" alt="Community">
                </div>
            </div>
        </div>

    </div>
</section>

<!-- A Journey of Growth Section -->
<section class="section-padding bg-light-gray">
    <div class="container container-custom">
        
        <div class="journey-header">
            <div>
                <h2 class="section-title wow fadeInUp">A Journey of Growth</h2>
                <p class="section-subtitle mb-0 wow fadeInUp" data-wow-delay="0.15s">Milestones that shaped our path from 1989 to today.</p>
            </div>
            <div class="journey-nav hidden-xs">
                <button><i class="fa fa-angle-left"></i></button>
                <button><i class="fa fa-angle-right"></i></button>
            </div>
        </div>

        <div class="flex-row-custom">
            <!-- Item 1 -->
            <div class="col-md-3 col-sm-6 flex-col-custom milestone-col wow fadeInUp">
                <div class="milestone-card">
                    <div class="milestone-img-wrap">
                        <img src="https://images.unsplash.com/photo-1534723452862-4c874018d66d?q=80&w=600&auto=format&fit=crop" alt="1989">
                        <span class="milestone-year-badge">1989</span>
                    </div>
                    <div class="milestone-body">
                        <h4>The First Foundation</h4>
                        <p>The doors to our flagship store opened, introducing a new standard of retail in the heart of the city.</p>
                    </div>
                </div>
            </div>
            <!-- Item 2 -->
            <div class="col-md-3 col-sm-6 flex-col-custom milestone-col wow fadeInUp" data-wow-delay="0.15s">
                <div class="milestone-card">
                    <div class="milestone-img-wrap">
                        <img src="https://images.unsplash.com/photo-1553413077-190dd305871c?q=80&w=600&auto=format&fit=crop" alt="1998">
                        <span class="milestone-year-badge">1998</span>
                    </div>
                    <div class="milestone-body">
                        <h4>Expanding Horizons</h4>
                        <p>Expanded our footprint across multiple provinces, doubling our logistics capacity to serve more communities.</p>
                    </div>
                </div>
            </div>
            <!-- Item 3 -->
            <div class="col-md-3 col-sm-6 flex-col-custom milestone-col wow fadeInUp" data-wow-delay="0.3s">
                <div class="milestone-card">
                    <div class="milestone-img-wrap">
                        <img src="https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?q=80&w=600&auto=format&fit=crop" alt="2012">
                        <span class="milestone-year-badge">2012</span>
                    </div>
                    <div class="milestone-body">
                        <h4>Digital Evolution</h4>
                        <p>Launched our first smart retail initiatives, integrating loyalty programs and modern payment systems.</p>
                    </div>
                </div>
            </div>
            <!-- Item 4 -->
            <div class="col-md-3 col-sm-6 flex-col-custom milestone-col wow fadeInUp" data-wow-delay="0.45s">
                <div class="milestone-card">
                    <div class="milestone-img-wrap">
                        <img src="https://images.unsplash.com/photo-1601599561096-f87c95fff1e9?q=80&w=600&auto=format&fit=crop" alt="Present">
                        <span class="milestone-year-badge">Present</span>
                    </div>
                    <div class="milestone-body">
                        <h4>Indonesia's Trusted Choice</h4>
                        <p>Leading the market with 50+ stores, redefining what it means to be a "Rumah Belanja Terpercaya".</p>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

<!-- Executive Leadership Section -->
<section class="section-padding bg-white pb-0">
    <div class="container container-custom text-center">
        
        <h2 class="section-title wow fadeInUp">Our Executive Leadership</h2>
        <p class="section-subtitle mb-5 wow fadeInUp" data-wow-delay="0.15s" style="max-width: 650px; margin: 0 auto 60px;">Guided by industry veterans with a passion for excellence and a deep understanding of the Indonesian consumer landscape.</p>

        <div class="flex-row-custom">
            <!-- Leader 1 -->
            <div class="col-md-3 col-sm-6 flex-col-custom wow fadeInUp">
                <div class="leader-card">
                    <div class="leader-img-wrapper">
                        <img src="https://images.unsplash.com/photo-1560250097-0b93528c311a?q=80&w=400&auto=format&fit=crop" alt="Bambang Setiawan">
                    </div>
                    <h4>Bambang Setiawan</h4>
                    <p>President Director</p>
                </div>
            </div>
            <!-- Leader 2 -->
            <div class="col-md-3 col-sm-6 flex-col-custom wow fadeInUp" data-wow-delay="0.15s">
                <div class="leader-card">
                    <div class="leader-img-wrapper">
                        <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?q=80&w=400&auto=format&fit=crop" alt="Lina Kusuma">
                    </div>
                    <h4>Lina Kusuma</h4>
                    <p>Chief Operations Officer</p>
                </div>
            </div>
            <!-- Leader 3 -->
            <div class="col-md-3 col-sm-6 flex-col-custom wow fadeInUp" data-wow-delay="0.3s">
                <div class="leader-card">
                    <div class="leader-img-wrapper">
                        <img src="https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?q=80&w=400&auto=format&fit=crop" alt="Andi Wijaya">
                    </div>
                    <h4>Andi Wijaya</h4>
                    <p>Chief Technology Officer</p>
                </div>
            </div>
            <!-- Leader 4 -->
            <div class="col-md-3 col-sm-6 flex-col-custom wow fadeInUp" data-wow-delay="0.45s">
                <div class="leader-card">
                    <div class="leader-img-wrapper">
                        <img src="https://images.unsplash.com/photo-1580489944761-15a19d654956?q=80&w=400&auto=format&fit=crop" alt="Sari Rahayu">
                    </div>
                    <h4>Sari Rahayu</h4>
                    <p>Marketing Director</p>
                </div>
            </div>
        </div>

    </div>
</section>

<!-- CTA Section -->
<section class="section-padding bg-light-gray cta-section">
    <div class="container container-custom">
        <div class="cta-banner wow fadeInUp">
            <div class="cta-banner-content">
                <h2 class="wow fadeInUp" data-wow-delay="0.1s">Want to be part of our story?</h2>
                <p class="wow fadeInUp" data-wow-delay="0.2s">Explore career opportunities and corporate partnerships with Indonesia's most trusted retailer.</p>
                <div class="cta-actions wow fadeInUp" data-wow-delay="0.3s">
                    <a href="#" class="btn btn-white">Join Our Team</a>
                    <a href="#" class="btn btn-orange-outline">Corporate Inquiry</a>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
/* Fallback gambar: jika gambar Unsplash gagal dimuat, ganti dengan placeholder andal */
(function () {
    var FALLBACKS = {
        'milestone-card': 'https://images.unsplash.com/photo-1556740738-b6a63e27c4df?q=80&w=600&auto=format&fit=crop',
        'leader-img-wrapper': 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?q=80&w=400&auto=format&fit=crop',
        'image-split-container': 'https://images.unsplash.com/photo-1556740738-b6a63e27c4df?q=80&w=1200&auto=format&fit=crop'
    };
    document.addEventListener('error', function (e) {
        var target = e.target;
        if (target.tagName !== 'IMG') return;
        var card = target.closest('.milestone-card, .leader-img-wrapper, .image-split-container');
        var fallback = card ? FALLBACKS[card.className.split(' ')[0]] : null;
        if (!fallback) fallback = 'https://images.unsplash.com/photo-1556740738-b6a63e27c4df?q=80&w=600&auto=format&fit=crop';
        if (target.src !== fallback) {
            target.src = fallback;
        }
    }, true);
})();
</script>

<!-- Memanggil Footer -->
<?php require_once('footer.php'); ?>

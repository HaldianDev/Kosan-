<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kos Venus Syariah – Hunian Modern, Nyaman & Berkah</title>
    <link rel="icon" href="/favicon.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,600;1,400&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    
    <style>
        :root {
            --primary: #047857; /* Emerald Deep */
            --primary-light: #e6f4ea;
            --primary-hover: #065f46;
            --accent: #b45309; /* Amber/Bronze Premium */
            --accent-light: #fef3c7;
            --dark: #0f172a; /* Slate Black */
            --gray: #475569;
            --gray-light: #94a3b8;
            --bg-light: #f8fafc;
            
            --radius-xl: 32px;
            --radius-lg: 24px;
            --radius-md: 16px;
            --radius-sm: 12px;
            
            --shadow-sm: 0 4px 6px -1px rgba(15, 23, 42, 0.03);
            --shadow-md: 0 12px 30px -10px rgba(15, 23, 42, 0.08);
            --shadow-lg: 0 30px 60px -15px rgba(4, 120, 87, 0.12);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #ffffff;
            color: var(--dark);
            line-height: 1.7;
            overflow-x: hidden;
        }

        .container {
            max-width: 1140px;
            margin: auto;
            padding: 0 1.5rem;
        }

        /* --- NAVBAR KEKINIAN & LUXE --- */
        nav {
            position: sticky;
            top: 0;
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(25px);
            -webkit-backdrop-filter: blur(25px);
            border-bottom: 1px solid rgba(241, 245, 249, 0.8);
            z-index: 1000;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        nav.scroll-shadow {
            box-shadow: 0 10px 30px -10px rgba(15, 23, 42, 0.05);
            background: rgba(255, 255, 255, 0.9);
        }

        nav .nav-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.2rem 1.5rem; /* Memberikan ruang aman di kanan-kiri */
        }

        nav .logo {
            font-size: 1.4rem;
            font-weight: 800;
            color: var(--dark);
            text-decoration: none;
            letter-spacing: -0.5px;
            display: flex;
            align-items: center;
            gap: 0.6rem;
        }

        nav .logo i {
            color: var(--primary);
            filter: drop-shadow(0 2px 8px rgba(4, 120, 87, 0.2));
        }

        nav .logo span {
            color: var(--primary);
        }

        nav ul {
            list-style: none;
            display: flex;
            gap: 2.2rem;
            align-items: center;
        }

        nav ul li a:not(.btn-nav) {
            color: var(--gray);
            text-decoration: none;
            font-weight: 600;
            font-size: 0.95rem;
            position: relative;
            padding: 0.5rem 0;
            transition: color 0.2s ease;
        }

        /* Efek garis bawah mengalir saat hover menu */
        nav ul li a:not(.btn-nav)::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--primary);
            transition: width 0.3s ease;
        }

        nav ul li a:not(.btn-nav):hover {
            color: var(--primary);
        }

        nav ul li a:not(.btn-nav):hover::after {
            width: 100%;
        }

        .btn-nav {
            background: var(--primary);
            color: #fff !important;
            padding: 0.75rem 1.6rem;
            border-radius: 100px;
            font-weight: 700;
            box-shadow: 0 4px 14px rgba(4, 120, 87, 0.25);
            transition: all 0.3s ease;
            text-decoration: none;
        }
        
        .btn-nav:hover {
            background: var(--primary-hover);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(4, 120, 87, 0.35);
        }

        /* Hamburger Menu */
        .menu-toggle {
            display: none;
            flex-direction: column;
            gap: 6px;
            cursor: pointer;
            z-index: 1001;
            padding: 4px;
        }
        
        .menu-toggle span {
            width: 24px;
            height: 2px;
            background-color: var(--dark);
            border-radius: 2px;
            transition: all 0.3s ease;
        }

        /* --- HERO HEADER REDESIGN --- */
        header {
            position: relative;
            min-height: 90vh;
            display: flex;
            align-items: center;
            padding: 5rem 0;
            background: radial-gradient(circle at 85% 15%, var(--primary-light) 0%, transparent 45%),
                        radial-gradient(circle at 15% 85%, #fef3c7 0%, transparent 35%);
            overflow: hidden;
        }

        .hero-decor {
            position: absolute;
            width: 400px;
            height: 400px;
            background: linear-gradient(45deg, rgba(4, 120, 87, 0.05), transparent);
            border-radius: 50%;
            top: 10%;
            right: -5%;
            z-index: 1;
            pointer-events: none;
        }

        .hero-grid {
            display: grid;
            grid-template-columns: 1.1fr 0.9fr;
            gap: 5rem;
            align-items: center;
            position: relative;
            z-index: 2;
        }

        .badge {
            display: inline-flex;
            align-items: center;
            gap: 0.6rem;
            background: #ffffff;
            color: var(--primary);
            padding: 0.6rem 1.4rem;
            border-radius: 100px;
            font-size: 0.85rem;
            font-weight: 700;
            margin-bottom: 2rem;
            box-shadow: 0 4px 15px rgba(15, 23, 42, 0.04);
            border: 1px solid rgba(4, 120, 87, 0.1);
        }

        header h1 {
            font-size: 4rem;
            font-weight: 800;
            line-height: 1.15;
            letter-spacing: -2.5px;
            color: var(--dark);
            margin-bottom: 1.8rem;
        }

        header h1 em {
            font-family: 'Playfair Display', serif;
            font-weight: 400;
            font-style: italic;
            color: var(--primary);
            position: relative;
            display: inline-block;
        }

        header p {
            font-size: 1.2rem;
            color: var(--gray);
            margin-bottom: 3rem;
            max-width: 550px;
            line-height: 1.8;
        }

        .btn-group {
            display: flex;
            gap: 1.2rem;
            flex-wrap: wrap;
        }

        .btn {
            padding: 1.1rem 2.4rem;
            border-radius: 100px;
            cursor: pointer;
            text-decoration: none;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.7rem;
            transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
            font-size: 1rem;
        }

        .btn-primary {
            background: var(--dark);
            color: #fff;
            box-shadow: 0 10px 25px rgba(15, 23, 42, 0.2);
        }
        
        .btn-primary:hover {
            background: var(--primary);
            transform: translateY(-4px);
            box-shadow: 0 15px 30px rgba(4, 120, 87, 0.3);
        }

        .btn-outline {
            border: 2px solid #e2e8f0;
            color: var(--dark);
            background: #ffffff;
            box-shadow: 0 4px 12px rgba(15, 23, 42, 0.02);
        }
        
        .btn-outline:hover {
            border-color: var(--dark);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(15, 23, 42, 0.06);
        }

        .btn-wa {
            background: #059669;
            color: #fff;
            box-shadow: 0 10px 25px rgba(5, 150, 105, 0.2);
        }
        
        .btn-wa:hover {
            background: #047857;
            transform: translateY(-4px);
            box-shadow: 0 15px 30px rgba(5, 150, 105, 0.3);
        }

        .hero-gallery {
            position: relative;
            display: grid;
            grid-template-columns: repeat(12, 1fr);
            align-items: center;
        }

        .hero-img-main {
            grid-column: 1 / 11;
            height: 520px;
            object-fit: cover;
            border-radius: var(--radius-xl);
            box-shadow: var(--shadow-lg);
            z-index: 2;
            transition: transform 0.4s ease;
        }

        .hero-img-sub {
            grid-column: 6 / -1;
            height: 310px;
            object-fit: cover;
            border-radius: var(--radius-lg);
            box-shadow: 0 20px 40px rgba(15, 23, 42, 0.15);
            z-index: 3;
            margin-top: -160px;
            border: 10px solid #ffffff;
            transition: transform 0.4s ease;
        }

        .hero-gallery:hover .hero-img-main {
            transform: scale(0.98) rotate(-0.5deg);
        }

        .hero-gallery:hover .hero-img-sub {
            transform: scale(1.04) translateY(-10px);
        }

        /* --- SECTIONS GENERAL --- */
        .section {
            padding: 7rem 0;
        }
        
        .section-alt {
            background: var(--bg-light);
            border-radius: var(--radius-xl);
        }

        .section-header {
            text-align: center;
            max-width: 600px;
            margin: 0 auto 5rem auto;
        }
        
        .section-header h2 {
            font-size: 2.5rem;
            font-weight: 800;
            letter-spacing: -1px;
            color: var(--dark);
            margin-bottom: 1rem;
        }
        
        .section-header p {
            color: var(--gray);
            font-size: 1.1rem;
        }

        /* --- FASILITAS --- */
        .grid-4 {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 2rem;
        }

        .card-feature {
            background: #fff;
            padding: 2.5rem 2rem;
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-sm);
            border: 1px solid #f1f5f9;
            transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        }
        
        .card-feature:hover {
            transform: translateY(-8px);
            border-color: transparent;
            box-shadow: var(--shadow-md);
        }

        .icon-box {
            font-size: 1.5rem;
            margin-bottom: 1.5rem;
            background: var(--primary-light);
            width: 56px;
            height: 56px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: var(--radius-sm);
            color: var(--primary);
        }

        .card-feature h3 {
            font-size: 1.2rem;
            font-weight: 700;
            margin-bottom: 0.75rem;
            color: var(--dark);
        }
        
        .card-feature p {
            color: var(--gray);
            font-size: 0.95rem;
        }

        /* --- PILIHAN KAMAR PREMIUM --- */
        .grid-2 {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(450px, 1fr));
            gap: 3rem;
        }

        .room-card {
            background: #ffffff;
            border-radius: var(--radius-lg);
            overflow: hidden;
            box-shadow: var(--shadow-sm);
            border: 1px solid #f1f5f9;
            transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        }
        
        .room-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-lg);
        }

        .room-img-wrapper {
            position: relative;
            height: 320px;
            overflow: hidden;
        }

        .room-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.6s cubic-bezier(0.16, 1, 0.3, 1);
        }
        
        .room-card:hover .room-img {
            transform: scale(1.05);
        }
        
        .room-tag {
            position: absolute;
            top: 1.5rem;
            left: 1.5rem;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(8px);
            color: var(--dark);
            padding: 0.5rem 1.2rem;
            font-weight: 700;
            font-size: 0.8rem;
            border-radius: 100px;
            box-shadow: var(--shadow-sm);
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
        }

        .room-info {
            padding: 2.5rem;
        }
        
        .room-info h3 {
            font-size: 1.6rem;
            font-weight: 800;
            margin-bottom: 0.5rem;
            letter-spacing: -0.5px;
        }
        
        .room-price {
            font-size: 1.5rem;
            color: var(--primary);
            font-weight: 800;
            margin-bottom: 1.25rem;
        }
        
        .room-price span {
            font-size: 0.95rem;
            color: var(--gray);
            font-weight: 400;
        }

        .room-info p {
            color: var(--gray);
            font-size: 1rem;
            margin-bottom: 1.5rem;
        }

        .room-specs {
            display: flex;
            flex-wrap: wrap;
            gap: 0.75rem;
            border-top: 1px solid #f1f5f9;
            padding-top: 1.5rem;
        }
        
        .room-specs span {
            background: var(--bg-light);
            padding: 0.4rem 0.8rem;
            border-radius: var(--radius-sm);
            font-size: 0.85rem;
            color: var(--gray);
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
        }

        /* --- CTA BANNER --- */
        .contact-wrapper {
            background: var(--dark);
            color: #fff;
            padding: 5rem 4rem;
            border-radius: var(--radius-xl);
            box-shadow: var(--shadow-lg);
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        
        .contact-wrapper::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(4,120,87,0.15) 0%, transparent 60%);
            pointer-events: none;
        }
        
        .contact-wrapper h3 {
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 1rem;
            letter-spacing: -1px;
        }
        
        .contact-wrapper p {
            color: var(--gray-light);
            margin-bottom: 2.5rem;
            font-size: 1.15rem;
            max-width: 580px;
            margin-left: auto;
            margin-right: auto;
        }

        /* --- LOKASI --- */
        .address-box {
            display: inline-flex;
            align-items: center;
            gap: 0.6rem;
            background: var(--primary-light);
            color: var(--primary);
            padding: 0.6rem 1.4rem;
            border-radius: 100px;
            font-weight: 700;
            font-size: 0.9rem;
            margin-bottom: 2.5rem;
        }
        
        .map iframe {
            border: 0;
            width: 100%;
            height: 450px;
            border-radius: var(--radius-xl);
            box-shadow: var(--shadow-md);
        }

        /* --- FOOTER REDESIGN --- */
        footer {
            background: var(--dark);
            color: #94a3b8;
            padding: 5rem 0 2rem 0;
            font-size: 0.95rem;
        }

        footer .footer-top {
            display: grid;
            grid-template-columns: 1.2fr 0.8fr 1fr;
            gap: 4rem;
            padding-bottom: 4rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }

        footer .footer-brand p {
            margin-top: 1.2rem;
            line-height: 1.8;
            color: #cbd5e1;
        }

        footer .logo {
            color: #ffffff;
            font-weight: 800;
            font-size: 1.5rem;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        footer .logo span {
            color: #34d399;
        }

        footer h4 {
            color: #ffffff;
            font-size: 1.1rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
        }

        footer ul.footer-links {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        footer ul.footer-links a {
            color: #94a3b8;
            text-decoration: none;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        footer ul.footer-links a:hover {
            color: #34d399;
            transform: translateX(4px);
        }

        footer .footer-contact-item {
            display: flex;
            gap: 0.8rem;
            margin-bottom: 1.2rem;
            align-items: flex-start;
        }

        footer .footer-contact-item i {
            color: #34d399;
            margin-top: 0.2rem;
        }

        .social-icons {
            display: flex;
            gap: 1rem;
            margin-top: 1.5rem;
        }
        
        .social-icons a {
            color: #ffffff;
            background: rgba(255, 255, 255, 0.05);
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        
        .social-icons a:hover {
            background: var(--primary);
            color: #ffffff;
            transform: translateY(-3px);
        }
        
        footer .footer-bottom {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 2rem;
            font-size: 0.85rem;
            color: #64748b;
            flex-wrap: wrap;
            gap: 1rem;
        }

        /* --- RESPONSIVE LAYOUTS --- */
        @media (max-width: 992px) {
            header h1 { font-size: 3rem; }
            .hero-grid { grid-template-columns: 1fr; gap: 4rem; }
            .hero-gallery { max-width: 540px; margin: auto; }
            .grid-2 { grid-template-columns: 1fr; }
            footer .footer-top { grid-template-columns: 1fr 1fr; gap: 3rem; }
            footer .footer-brand { grid-column: span 2; }
        }

        @media (max-width: 768px) {
            nav .nav-container {
                padding: 1rem 1.2rem; /* Menjaga logo & hamburger agar tidak menempel ke tepi layar */
            }

            .menu-toggle { 
                display: flex; 
            }
            
            nav ul {
                position: fixed;
                top: 68px; /* Disesuaikan tinggi navbar baru */
                left: -100%;
                width: 100%;
                height: calc(100vh - 68px);
                background: #fff;
                flex-direction: column;
                justify-content: flex-start;
                padding: 3rem 2rem;
                gap: 2rem;
                box-shadow: var(--shadow-md);
                transition: left 0.4s cubic-bezier(0.16, 1, 0.3, 1);
            }

            nav ul.active { 
                left: 0; 
            }

            /* Animasi Efek Transisi Hamburger ke tanda (X) */
            .menu-toggle.active span:nth-child(1) { transform: rotate(45deg) translate(5px, 5px); }
            .menu-toggle.active span:nth-child(2) { opacity: 0; }
            .menu-toggle.active span:nth-child(3) { transform: rotate(-45deg) translate(6px, -7px); }

            header { text-align: center; padding: 4rem 0; }
            header p { margin: 1.5rem auto 2.5rem auto; }
            .btn-group { justify-content: center; }
            
            .hero-img-main { height: 380px; }
            .hero-img-sub { height: 220px; margin-top: -140px; }
            
            .section { padding: 4.5rem 0; }
            .section-header h2 { font-size: 2rem; }
            
            .contact-wrapper { padding: 3.5rem 2rem; }
            .contact-wrapper h3 { font-size: 1.8rem; }
            
            footer .footer-top { grid-template-columns: 1fr; }
            footer .footer-brand { grid-column: span 1; }
            footer .footer-bottom { flex-direction: column; text-align: center; }
            .map iframe { height: 350px; }
        }

        /* --- PERBAIKAN PADA MOBILE (max-width: 768px) --- */
@media (max-width: 768px) {
    header { 
        text-align: center; 
        padding: 5rem 0 3rem 0; /* Menambah padding atas agar tidak mepet navbar */
    }
    
    header p { 
        margin: 1.5rem auto 2.5rem auto; 
    }
    
    .btn-group { 
        justify-content: center; 
        margin-bottom: 3rem; /* Memberi ruang sebelum masuk ke area gambar */
    }

    /* Reset Grid Gallery di Mobile agar memiliki ruang bernapas */
    .hero-gallery { 
        display: block; /* Mengubah grid menjadi block biasa untuk kontrol penuh */
        position: relative;
        max-width: 100%;
        margin: 2rem auto 0 auto;
        padding: 0 1rem; /* Mencegah gambar menyentuh ujung layar ponsel */
    }

    .hero-img-main {
        width: 85%; /* Menyisakan ruang di kanan untuk overlay gambar sub */
        height: 320px; /* Tinggi yang proporsional di mobile */
        object-fit: cover;
        display: block;
        border-radius: var(--radius-lg);
    }

    .hero-img-sub {
        position: absolute;
        bottom: -20px; /* Memposisikan di kanan bawah gambar utama */
        right: 1rem;
        width: 50%; /* Ukuran overlay yang pas di layar kecil */
        height: 180px;
        margin-top: 0 !important; /* Menghapus negative margin bawaan desktop */
        border: 6px solid #ffffff; /* Memperkecil border putih agar serasi */
        border-radius: var(--radius-md);
        z-index: 3;
    }
}
    </style>
</head>
<body>

    <nav id="navbar">
        <div class="nav-container">
            <a href="#home" class="logo"><i class="fa-solid fa-moon"></i> Venus<span>Syariah.</span></a>
            
            <div class="menu-toggle" id="mobile-menu">
                <span></span>
                <span></span>
                <span></span>
            </div>

            <ul id="nav-list">
                <li><a href="#home">Beranda</a></li>
                <li><a href="#facilities">Fasilitas</a></li>
                <li><a href="#rooms">Pilihan Kamar</a></li>
                <li><a href="#location">Lokasi</a></li>
                <li><a href="#contact" class="btn-nav"><i class="fa-regular fa-comment-dots"></i> Tanya Admin</a></li>
            </ul>
        </div>
    </nav>

<!-- --- HERO HEADER SECTION --- -->
    <header id="home">
        <div class="hero-decor"></div>
        <div class="container">
            <div class="hero-grid">
                <div class="hero-content">
                    <span class="badge"><i class="fa-solid fa-leaf"></i> Eco Living & Syariah Comfort</span>
                    <h1>Hunian modern, tenang & penuh <em>berkah</em></h1>
                    <p>Kost eksklusif bergaya minimalis modern dengan atmosfer Islami yang bersih, aman, dan nyaman di Menggala. Pilihan ideal untuk istirahat optimal dan produktivitas Anda.</p>
                    <div class="btn-group">
                        <a class="btn btn-primary" href="#rooms">Lihat Pilihan Kamar <i class="fa-solid fa-arrow-right"></i></a>
                        <a class="btn btn-outline" href="https://maps.google.com" target="_blank" rel="noopener"><i class="fa-solid fa-map-location-dot"></i> Petunjuk Rute</a>
                    </div>
                </div>
                <div class="hero-gallery">
                    <img src="https://images.unsplash.com/photo-1522771739844-6a9f6d5f14af?auto=format&fit=crop&w=600&q=80" alt="Interior Kamar Utama" class="hero-img-main">
                    <img src="https://images.unsplash.com/photo-1616594039964-ae9021a400a0?auto=format&fit=crop&w=400&q=80" alt="Fasilitas Kost" class="hero-img-sub">
                </div>
            </div>
        </div>
    </header>
    <!-- --- FASILITAS SECTION --- -->
    <section class="section" id="facilities">
        <div class="container">
            <div class="section-header">
                <h2>Fasilitas Eksklusif</h2>
                <p>Setiap sudut dirancang untuk memastikan kenyamanan privasi harian Anda terpenuhi dengan standar terbaik.</p>
            </div>
            
            <div class="grid-4">
                <div class="card-feature">
                    <div class="icon-box"><i class="fa-solid fa-couch"></i></div>
                    <h3>Fully Furnished</h3>
                    <p>Kamar siap huni lengkap dengan ranjang berkualitas, lemari minimalis, dan meja kerja ergonomis.</p>
                </div>
                <div class="card-feature">
                    <div class="icon-box"><i class="fa-solid fa-mosque"></i></div>
                    <h3>Lingkungan Nyaman</h3>
                    <p>Atmosfer hunian syariah yang tertib, sopan, aman, serta menjaga privasi setiap penghuni.</p>
                </div>
                <div class="card-feature">
                    <div class="icon-box"><i class="fa-solid fa-square-parking"></i></div>
                    <h3>Area Bersama</h3>
                    <p>Dapur bersama yang bersih, area jemur yang rapi, dan area parkir kendaraan aman terpantau.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- --- PILIHAN KAMAR SECTION --- -->
    <section class="section section-alt" id="rooms">
        <div class="container">
            <div class="section-header">
                <h2>Pilihan Kamar Terbaru</h2>
                <p>Harga super terjangkau dengan kebebasan fasilitas pemakaian air dan energi listrik gratis setiap hari.</p>
            </div>
            
            <div class="grid-2">
                <!-- Kamar Tipe Deluxe Closet Duduk -->
                <div class="room-card">
                    <div class="room-img-wrapper">
                        <img src="https://images.unsplash.com/photo-1616594039964-ae9021a400a0?auto=format&fit=crop&w=600&q=80" alt="Tipe Closet Duduk" class="room-img">
                        <span class="room-tag" style="color: var(--primary); font-weight:800;"><i class="fa-solid fa-star"></i> Paling Nyaman</span>
                    </div>
                    <div class="room-info">
                        <h3>Tipe Single - WC Duduk</h3>
                        <div class="room-price">Rp 300.000 <span>/ bulan</span></div>
                        <p>Kamar tidur privat dengan tambahan fasilitas toilet berupa WC duduk modern di dalam kamar mandi untuk kenyamanan ekstra.</p>
                        <div class="room-specs">
                            <span><i class="fa-solid fa-toilet"></i> WC Duduk Premium</span>
                            <span><i class="fa-solid fa-shower"></i> Kamar Mandi Dalam</span>
                            <span><i class="fa-solid fa-bolt"></i> Free Listrik & Air</span>
                            <span><i class="fa-solid fa-bed"></i> Kamar Furnished</span>
                        </div>
                    </div>
                </div>

                <!-- Kamar Tipe Standard -->
                <div class="room-card">
                    <div class="room-img-wrapper">
                        <img src="https://images.unsplash.com/photo-1598928506311-c55ded91a20c?auto=format&fit=crop&w=600&q=80" alt="Tipe Standard" class="room-img">
                        <span class="room-tag"><i class="fa-solid fa-tags"></i> Paling Hemat</span>
                    </div>
                    <div class="room-info">
                        <h3>Tipe Single - Standard</h3>
                        <div class="room-price">Rp 250.000 <span>/ bulan</span></div>
                        <p>Kamar minimalis modern super ekonomis yang sudah dilengkapi fasilitas esensial tempat tidur lengkap.</p>
                        <div class="room-specs">
                            <span><i class="fa-solid fa-shower"></i> Kamar Mandi Dalam</span>
                            <span><i class="fa-solid fa-bolt"></i> Free Listrik & Air</span>
                            <span><i class="fa-solid fa-bed"></i> Kamar Furnished</span>
                            <span><i class="fa-solid fa-maximize"></i> Tata Ruang Efisien</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- --- CTA CONTACT SECTION --- -->
    <section class="section" id="contact">
        <div class="container">
            <div class="contact-wrapper">
                <h3>Mulai Amankan Kamarmu</h3>
                <p>Ketersediaan kamar sangat terbatas dan diperbarui setiap bulan. Jadwalkan kunjungan survei lokasi dengan tim admin kami hari ini.</p>
                <a class="btn btn-wa" href="https://wa.me/6281337557215" target="_blank" rel="noopener">
                    <i class="fa-brands fa-whatsapp fa-lg"></i> Hubungi WhatsApp Admin
                </a>
            </div>
        </div>
    </section>

    <!-- --- MAPS LOCATION SECTION --- -->
    <section class="section section-alt" id="location">
        <div class="container" style="text-align: center;">
            <div class="section-header">
                <h2>Lokasi Strategis</h2>
                <p>Sangat mudah diakses, dekat dengan pusat perkantoran pemerintah, kuliner, dan fasilitas umum di Menggala.</p>
            </div>
            
            <div class="address-box">
                <i class="fa-solid fa-location-dot"></i> Tiuh Tohou, Kec. Menggala, Kabupaten Tulang Bawang, Lampung 34694
            </div>

            <div class="map">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15903.743477810787!2d105.2505299!3d-4.5153289!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e3f169f44f6fdf9%3A0x6fb0d28fa6b84000!2sTiuh%20Tohou%2C%20Menggala%2C%20Tulang%20Bawang%20Regency%2C%20Lampung!5e0!3m2!1sid!2sid!4v1700000000000!5m2!1sid!2sid" allowfullscreen loading="lazy"></iframe>
            </div>
        </div>
    </section>

    <!-- --- PREMIUM FOOTER SECTION --- -->
    <footer>
        <div class="container">
            <div class="footer-top">
                <div class="footer-brand">
                    <a href="#home" class="logo"><i class="fa-solid fa-moon"></i> Venus<span>Syariah.</span></a>
                    <p>Kos modern eksklusif dengan lingkungan Islami yang asri dan strategis di Tulang Bawang. Mengutamakan kenyamanan, keamanan harian, serta keberkahan hunian Anda.</p>
                    <div class="social-icons">
                        <a href="#" aria-label="Facebook"><i class="fa-brands fa-facebook-f"></i></a>
                        <a href="https://instagram.com" target="_blank" rel="noopener" aria-label="Instagram"><i class="fa-brands fa-instagram"></i></a>
                        <a href="https://wa.me/6281337557215" target="_blank" rel="noopener" aria-label="WhatsApp"><i class="fa-brands fa-whatsapp"></i></a>
                    </div>
                </div>
                <div>
                    <h4>Navigasi</h4>
                    <ul class="footer-links">
                        <li><a href="#home"><i class="fa-solid fa-chevron-right fa-xs"></i> Beranda</a></li>
                        <li><a href="#facilities"><i class="fa-solid fa-chevron-right fa-xs"></i> Fasilitas</a></li>
                        <li><a href="#rooms"><i class="fa-solid fa-chevron-right fa-xs"></i> Pilihan Kamar</a></li>
                        <li><a href="#location"><i class="fa-solid fa-chevron-right fa-xs"></i> Lokasi</a></li>
                    </ul>
                </div>
                <div>
                    <h4>Kontak & Informasi</h4>
                    <div class="footer-contact-item">
                        <i class="fa-solid fa-map-pin"></i>
                        <span>Tiuh Tohou, Kec. Menggala, Kabupaten Tulang Bawang, Lampung 34694</span>
                    </div>
                    <div class="footer-contact-item">
                        <i class="fa-solid fa-phone"></i>
                        <span>+62 813-3755-7215</span>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <div>&copy; 2026 Kos Venus Syariah. Hak Cipta Dilindungi.</div>
                <div>Syariah Living • Eco Friendly • Modern Design</div>
            </div>
        </div>
    </footer>

    <!-- --- JAVASCRIPT --- -->
    <script>
        const mobileMenu = document.getElementById('mobile-menu');
        const navList = document.getElementById('nav-list');
        const navLinks = document.querySelectorAll('#nav-list a');
        const navbar = document.getElementById('navbar');

        // Toggle Menu Mobile
        mobileMenu.addEventListener('click', () => {
            mobileMenu.classList.toggle('active');
            navList.classList.toggle('active');
        });

        // Close Menu Mobile saat Link diklik
        navLinks.forEach(link => {
            link.addEventListener('click', () => {
                mobileMenu.classList.remove('active');
                navList.classList.remove('active');
            });
        });

        // Efek shadow dinamis pada Navbar saat di-scroll
        window.addEventListener('scroll', () => {
            if (window.scrollY > 50) {
                navbar.classList.add('scroll-shadow');
            } else {
                navbar.classList.remove('scroll-shadow');
            }
        });
    </script>
</body>
</html>
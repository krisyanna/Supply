@extends('layouts.guest')

@section('title', 'Supply Chain ERP')

@section('content')
<div class="home-page">

    <div class="corner-mark corner-mark-top">
        <span class="circle circle-navy"></span>
        <span class="circle circle-green"></span>
        <span class="brand-letter">S</span>
    </div>

    <div class="corner-mark corner-mark-bottom">
        <span class="circle circle-green"></span>
        <span class="circle circle-navy"></span>
    </div>

    <header class="navbar container">
        <div class="navbar-spacer"></div>
        <nav>
            <a href="{{ route('forecasting.demand') }}">Forecasting</a>
            <a href="{{ route('procurement.reorder') }}">Procurement</a>
            <a href="{{ route('logistics.dashboard') }}">Logistics</a>
            <a href="{{ route('inventory.index') }}">Inventory & Warehouse</a>
          
        </nav>
    </header>

    <main class="hero container">
        <section class="hero-text">
            <h1>SUPPLY &amp;<br>LOGISTICS<br>MANAGEMENT</h1>
            <p>
                Improve efficiency, reduce costs, and keep your business running smoothly
                with effective supply chain management. From procurement to delivery, monitor
                your entire supply chain in one powerful platform.
            </p>
            <a href="{{ route('home') }}" class="btn-primary">
                GET STARTED
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M9 18l6-6-6-6"></path>
                </svg>
            </a>
        </section>

        <section class="hero-image">
            <img src="{{ asset('images/logistics-hero.webp') }}" alt="Supply and logistics illustration">
        </section>
    </main>
</div>
@endsection

@push('styles')
<style>
    .container {
        max-width: 1280px;
        margin: 0 auto;
        padding: 0 48px;
    }

    /* ===== Page shell ===== */
    .home-page {
        position: relative;
        overflow: hidden;
        min-height: 100vh;
        display: flex;
        flex-direction: column;
    }

    /* ===== Corner brand marks (overlapping circles, bleeding off the edge) ===== */
    .corner-mark {
        position: absolute;
        width: 340px;
        height: 340px;
        z-index: 0;
        pointer-events: none;
    }

    .corner-mark-top {
        top: -110px;
        left: -110px;
    }

    .corner-mark-bottom {
        bottom: -140px;
        right: -120px;
    }

    .circle {
        position: absolute;
        border-radius: 50%;
    }

    .corner-mark-top .circle-navy {
        width: 230px;
        height: 230px;
        top: 0;
        left: 0;
        background: #232b63;
    }

    .corner-mark-top .circle-green {
        width: 250px;
        height: 250px;
        top: 30px;
        left: 130px;
        background: #0e5b45;
    }

    .corner-mark-bottom .circle-green {
        width: 230px;
        height: 230px;
        bottom: 0;
        right: 0;
        background: #0e5b45;
    }

    .corner-mark-bottom .circle-navy {
        width: 250px;
        height: 250px;
        bottom: 30px;
        right: 130px;
        background: #232b63;
    }

    .brand-letter {
        position: absolute;
        top: 78px;
        left: 145px;
        font-size: 40px;
        font-weight: 800;
        color: #ffffff;
        line-height: 1;
        z-index: 1;
    }

    /* ===== Navbar ===== */
    .navbar {
        position: relative;
        z-index: 10;
        display: flex;
        align-items: center;
        justify-content: flex-end;
        padding-top: 44px;
        padding-bottom: 44px;
    }

    .navbar-spacer {
        flex: 1;
    }

    .navbar nav {
        display: flex;
        align-items: center;
        gap: 40px;
        flex-wrap: wrap;
    }

    .navbar nav a {
        font-size: 17px;
        font-weight: 700;
        color: #0e5b45;
        text-decoration: none;
        transition: opacity 0.15s ease;
    }

    .navbar nav a:hover {
        opacity: 0.7;
    }

    /* ===== Hero ===== */
    .hero {
        position: relative;
        z-index: 10;
        display: flex;
        align-items: center;
        gap: 32px;
        flex-wrap: wrap;
        flex: 1;
        padding-top: 40px;
        padding-bottom: 80px;
    }

    .hero-text {
        flex: 1 1 440px;
        min-width: 0;
    }

    .hero-text h1 {
        font-style: italic;
        font-weight: 800;
        font-size: 58px;
        line-height: 1.12;
        letter-spacing: -0.01em;
        color: #0e5b45;
        margin: 0 0 28px 0;
    }

    .hero-text p {
        font-size: 16px;
        line-height: 1.75;
        color: #64748b;
        max-width: 460px;
        margin: 0 0 32px 0;
    }

    .btn-primary {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        background: #232b63;
        color: #ffffff;
        font-weight: 800;
        font-size: 14px;
        letter-spacing: 0.03em;
        text-decoration: none;
        padding: 16px 30px;
        border-radius: 9999px;
        box-shadow: 0 10px 24px rgba(35, 43, 99, 0.28);
        transition: background 0.15s ease, transform 0.15s ease;
    }

    .btn-primary svg {
        width: 18px;
        height: 18px;
        flex-shrink: 0;
    }

    .btn-primary:hover {
        background: #1a2050;
        transform: translateY(-1px);
    }

    .hero-image {
        flex: 1 1 420px;
        min-width: 0;
        display: flex;
        justify-content: center;
    }

    .hero-image img {
        width: 100%;
        max-width: 640px;
        height: auto;
        display: block;
    }

    @media (max-width: 900px) {
        .hero-text h1 {
            font-size: 40px;
        }

        .navbar {
            justify-content: center;
        }

        .navbar-spacer {
            display: none;
        }

        .navbar nav {
            gap: 20px;
            justify-content: center;
        }
    }
</style>
@endpush
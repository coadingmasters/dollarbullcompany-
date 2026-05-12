<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $slides = [
        [
            'image'      => 'https://images.unsplash.com/photo-1639762681485-074b7f938ba0?w=1800&q=80',
            'badge'      => 'Welcome to CryptoOnly',
            'headline'   => 'The Future of Digital',
            'highlight'  => 'Finance Is Here',
            'sub'        => 'Trade, invest and grow your crypto portfolio with institutional-grade tools built for the modern investor.',
            'btn1_label' => 'Start Trading',
            'btn1_url'   => '/register',
            'btn2_label' => 'Explore Markets',
            'btn2_url'   => '/markets',
        ],
        [
            'image'      => 'https://images.unsplash.com/photo-1621416894569-0f39ed31d247?w=1800&q=80',
            'badge'      => 'Bitcoin & Beyond',
            'headline'   => 'Secure Your Wealth in',
            'highlight'  => 'Digital Gold',
            'sub'        => 'Bitcoin remains the most trusted store of value in crypto history. Invest with confidence on our fully regulated platform.',
            'btn1_label' => 'Buy Bitcoin',
            'btn1_url'   => '/bitcoin',
            'btn2_label' => 'Learn More',
            'btn2_url'   => '/about',
        ],
        [
            'image'      => 'https://images.unsplash.com/photo-1518186285589-2f7649de83e0?w=1800&q=80',
            'badge'      => 'DeFi & Web3',
            'headline'   => 'Decentralised Finance',
            'highlight'  => 'Without Limits',
            'sub'        => 'Access DeFi protocols, yield farming, and Web3 innovations — all managed from one unified, secure dashboard.',
            'btn1_label' => 'Explore DeFi',
            'btn1_url'   => '/defi',
            'btn2_label' => 'View Portfolio',
            'btn2_url'   => '/portfolio',
        ],
        [
            'image'      => 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=1800&q=80',
            'badge'      => 'Real-Time Analytics',
            'headline'   => 'Trade Smarter with',
            'highlight'  => 'Live Market Data',
            'sub'        => 'Real-time charts, AI-powered signals and deep market data give you the decisive edge in every trade you make.',
            'btn1_label' => 'Live Markets',
            'btn1_url'   => '/markets',
            'btn2_label' => 'Get Started',
            'btn2_url'   => '/register',
        ],
    ];

    return view('welcome', compact('slides'));
});

use App\Http\Controllers\Admin\AuthController;

Route::get('/admin/login', [AuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AuthController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [AuthController::class, 'logout'])->name('admin.logout');

Route::middleware('auth:admin')->prefix('admin')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.Dashboard');
    })->name('admin.dashboard');
});

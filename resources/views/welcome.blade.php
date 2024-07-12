<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Forms</title>
    <link rel="shortcut icon" sizes="16x16" href="https://ssl.gstatic.com/docs/spreadsheets/forms/favicon_qp2.png">
    <link rel="stylesheet" href="{{ asset('css/styles_home.css') }}">
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
    <header>
        <nav class="navbar">
            <div class="container">
                <a href="#" class="logo">MY FORMS</a>
                <ul class="nav-links">
                    <li><a href="#features">Features</a></li>
                    <li><a href="#pricing">Pricing</a></li>
                    <li><a href="#contact">Contact</a></li>
                </ul>
                {{-- <a href="#signup" class="btn">Sign Up</a> --}}
                @if (Route::has('login'))
                <div class="sm:fixed sm:top-0 sm:right-0 p-6 text-right z-10">
                    @auth
                        <a href="{{ url('/home') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Home</a>
                    @else
                        <a href="{{ route('login') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Log in</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="ml-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Register</a>
                        @endif
                    @endauth
                </div>
            @endif
            </div>
        </nav>
    </header>
    <section class="hero">
        <div class="container">
            <h1>Create Beautiful Forms Easily</h1>
            <p>Design, build, and manage forms effortlessly with our powerful form builder.</p>
            <a href="#signup" class="btn">Get Started</a>
        </div>
    </section>
    <section id="features" class="features">
        <div class="container">
            <h2>Features</h2>
            <div class="feature-grid">
                <div class="feature-item">
                    <h3>Easy to Use</h3>
                    <p>Our intuitive drag-and-drop interface makes form creation a breeze.</p>
                </div>
                <div class="feature-item">
                    <h3>Customizable</h3>
                    <p>Customize your forms with various themes and templates.</p>
                </div>
                <div class="feature-item">
                    <h3>Responsive Design</h3>
                    <p>All forms are fully responsive and mobile-friendly.</p>
                </div>
                <div class="feature-item">
                    <h3>Advanced Analytics</h3>
                    <p>Track form submissions and user interactions with detailed analytics.</p>
                </div>
            </div>
        </div>
    </section>
    <section id="pricing" class="pricing">
        <div class="container">
            <h2>Pricing</h2>
            <div class="pricing-table">
                <div class="pricing-card">
                    <h3>Basic</h3>
                    <p>Free</p>
                    <ul>
                        <li>10 Forms</li>
                        <li>100 Submissions per Month</li>
                        <li>Basic Support</li>
                    </ul>
                    <a href="#signup" class="btn">Sign Up</a>
                </div>
                <div class="pricing-card">
                    <h3>Pro</h3>
                    <p>$9.99/month</p>
                    <ul>
                        <li>Unlimited Forms</li>
                        <li>1,000 Submissions per Month</li>
                        <li>Priority Support</li>
                    </ul>
                    <a href="#signup" class="btn">Sign Up</a>
                </div>
                <div class="pricing-card">
                    <h3>Enterprise</h3>
                    <p>Contact Us</p>
                    <ul>
                        <li>Custom Forms</li>
                        <li>Unlimited Submissions</li>
                        <li>Dedicated Support</li>
                    </ul>
                    <a href="#contact" class="btn">Contact Us</a>
                </div>
            </div>
        </div>
    </section>
    <footer id="contact">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3>About Us</h3>
                    <p>FormsWebsite is dedicated to providing the best form creation experience.</p>
                </div>
                <div class="footer-section">
                    <h3>Contact Us</h3>
                    <p>Email: support@formswebsite.com</p>
                    <p>Phone: +123 456 7890</p>
                </div>
                <div class="footer-section">
                    <h3>Follow Us</h3>
                    <p>
                        <a href="#">Facebook</a> |
                        <a href="#">Twitter</a> |
                        <a href="#">LinkedIn</a>
                    </p>
                </div>
            </div>
            <p class="footer-bottom">&copy; 2024 FormsWebsite. All Rights Reserved.</p>
        </div>
    </footer>
</body>
</html>



@if (Route::has('login'))
                <div class="sm:fixed sm:top-0 sm:right-0 p-6 text-right z-10">
                    @auth
                        <a href="{{ url('/home') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Home</a>
                    @else
                        <a href="{{ route('login') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Log in</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="ml-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Register</a>
                        @endif
                    @endauth
                </div>
            @endif

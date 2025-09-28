<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <style>
        :root {
            --primary-color: #6B5BFF;
            --secondary-color: #FF6B6B;
            --accent-color: #FFD166;
        }
        
        body {
            background: linear-gradient(-45deg, #ee7752, #e73c7e, #23a6d5, #23d5ab);
            background-size: 400% 400%;
            animation: gradient 15s ease infinite;
            height: 100vh;
            margin: 0;
            overflow-x: hidden;
        }
        
        @keyframes gradient {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        
        .auth-card {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(10px);
            border: none;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            transition: all 0.5s ease;
            transform: translateY(0);
            max-width: 500px;
            margin: 2rem auto;
            position: relative;
            z-index: 10;
        }
        
        .auth-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.3);
        }
        
        .auth-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
            padding: 2rem;
            position: relative;
            overflow: hidden;
            text-align: center;
        }
        
        .auth-header h4 {
            font-size: 2rem;
            font-weight: 700;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
            margin: 0;
        }
        
        .auth-header::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.3) 0%, rgba(255,255,255,0) 80%);
            opacity: 0;
            transform: scale(0.5);
            transition: all 0.8s ease;
        }
        
        .auth-card:hover .auth-header::before {
            opacity: 1;
            transform: scale(1);
        }
        
        .auth-body {
            padding: 2.5rem;
        }
        
        .auth-input {
            border-radius: 12px;
            border: 2px solid #e0e0e0;
            padding: 1rem 1.5rem;
            transition: all 0.4s ease;
            font-size: 1.1rem;
            background: rgba(255, 255, 255, 0.8);
            width: 100%;
        }
        
        .auth-input:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(107, 91, 255, 0.25);
            background: white;
        }
        
        .auth-btn {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            border: none;
            border-radius: 12px;
            padding: 1rem 2rem;
            color: white;
            font-weight: 700;
            font-size: 1.1rem;
            transition: all 0.4s ease;
            box-shadow: 0 8px 15px rgba(107, 91, 255, 0.3);
            letter-spacing: 0.5px;
        }
        
        .auth-btn:hover {
            background: linear-gradient(135deg, var(--secondary-color) 0%, var(--primary-color) 100%);
            transform: translateY(-5px) scale(1.05);
            box-shadow: 0 12px 20px rgba(255, 107, 107, 0.4);
        }
        
        .auth-link {
            color: var(--primary-color);
            transition: all 0.3s ease;
            text-decoration: none;
            font-weight: 600;
        }
        
        .auth-link:hover {
            color: var(--secondary-color);
            text-decoration: none;
        }
        
        .form-check-input:checked {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }
        
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }
        
        .animated-element {
            animation: fadeInUp 0.7s ease forwards;
        }
        
        .pulse {
            animation: pulse 2s infinite;
        }
        
        .float {
            animation: float 4s ease-in-out infinite;
        }
        
        .delay-1 { animation-delay: 0.2s; }
        .delay-2 { animation-delay: 0.4s; }
        .delay-3 { animation-delay: 0.6s; }
        .delay-4 { animation-delay: 0.8s; }
        
        .form-check-label {
            font-weight: 500;
            color: #555;
        }
        
        /* Decorative elements */
        .floating-circle {
            position: absolute;
            border-radius: 50%;
            z-index: -1;
            opacity: 0.6;
        }
        
        .circle-1 {
            width: 150px;
            height: 150px;
            background: var(--secondary-color);
            top: -75px;
            right: -75px;
            animation: float 7s ease-in-out infinite;
        }
        
        .circle-2 {
            width: 100px;
            height: 100px;
            background: var(--primary-color);
            bottom: -50px;
            left: -50px;
            animation: float 5s ease-in-out infinite reverse;
        }
        
        .circle-3 {
            width: 70px;
            height: 70px;
            background: var(--accent-color);
            top: 40%;
            right: -35px;
            animation: float 6s ease-in-out infinite 1s;
        }
        
        /* Responsive adjustments */
        @media (max-width: 768px) {
            .auth-card {
                margin: 1rem 15px;
            }
            
            .auth-header h4 {
                font-size: 1.75rem;
            }
            
            .auth-body {
                padding: 2rem 1.5rem;
            }
        }
    </style>

    <div class="auth-card">
        <div class="floating-circle circle-1"></div>
        <div class="floating-circle circle-2"></div>
        <div class="floating-circle circle-3"></div>
        
        <div class="auth-header">
            <h4 class="mb-0 float">{{ __('Welcome Back!') }}</h4>
        </div>
        <div class="auth-body">
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email Address -->
                <div class="mb-4 animated-element delay-1">
                    <x-input-label for="email" :value="__('Email')" class="mb-2 fw-bold" />
                    <x-text-input id="email" class="auth-input" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="mb-4 animated-element delay-2">
                    <x-input-label for="password" :value="__('Password')" class="mb-2 fw-bold" />
                    <x-text-input id="password" class="auth-input" type="password" name="password" required autocomplete="current-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Remember Me -->
                <div class="mb-4 animated-element delay-3">
                    <div class="form-check">
                        <input id="remember_me" type="checkbox" class="form-check-input" name="remember">
                        <label class="form-check-label" for="remember_me">{{ __('Remember me') }}</label>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-4 animated-element delay-4">
                    @if (Route::has('password.request'))
                        <a class="auth-link" href="{{ route('password.request') }}">
                            {{ __('Forgot your password?') }}
                        </a>
                    @endif

                    <button type="submit" class="auth-btn pulse">
                        {{ __('Log in') }}
                    </button>
                </div>
                
                <div class="text-center mt-4 animated-element delay-4">
                    <p class="mb-0">{{ __("Don't have an account?") }} <a href="{{ route('register') }}" class="auth-link">{{ __('Register Now') }}</a></p>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>

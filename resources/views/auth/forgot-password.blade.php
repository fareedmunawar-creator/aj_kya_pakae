<x-guest-layout>
    <style>
        .auth-card {
            background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            transition: all 0.3s ease;
            transform: translateY(0);
        }
        
        .auth-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
        }
        
        .auth-header {
            background: linear-gradient(135deg, #FF6B6B 0%, #FFE66D 100%);
            color: white;
            padding: 1.5rem;
            position: relative;
            overflow: hidden;
        }
        
        .auth-header::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.2) 0%, rgba(255,255,255,0) 80%);
            opacity: 0;
            transform: scale(0.5);
            transition: all 0.5s ease;
        }
        
        .auth-card:hover .auth-header::before {
            opacity: 1;
            transform: scale(1);
        }
        
        .auth-body {
            padding: 2rem;
        }
        
        .auth-input {
            border-radius: 8px;
            border: 1px solid #e0e0e0;
            padding: 0.75rem 1rem;
            transition: all 0.3s ease;
        }
        
        .auth-input:focus {
            border-color: #FF6B6B;
            box-shadow: 0 0 0 0.2rem rgba(255, 107, 107, 0.25);
        }
        
        .auth-btn {
            background: linear-gradient(135deg, #FF6B6B 0%, #FF8E53 100%);
            border: none;
            border-radius: 8px;
            padding: 0.75rem 1.5rem;
            color: white;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(255, 107, 107, 0.2);
        }
        
        .auth-btn:hover {
            background: linear-gradient(135deg, #FF8E53 0%, #FF6B6B 100%);
            transform: translateY(-2px);
            box-shadow: 0 6px 8px rgba(255, 107, 107, 0.3);
        }
        
        .auth-link {
            color: #FF6B6B;
            transition: all 0.3s ease;
            text-decoration: none;
        }
        
        .auth-link:hover {
            color: #FF8E53;
            text-decoration: none;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .animated-element {
            animation: fadeIn 0.5s ease forwards;
        }
        
        .delay-1 { animation-delay: 0.1s; }
        .delay-2 { animation-delay: 0.2s; }
        .delay-3 { animation-delay: 0.3s; }
    </style>

    <div class="auth-card">
        <div class="floating-circle circle-1"></div>
        <div class="floating-circle circle-2"></div>
        <div class="floating-circle circle-3"></div>
        
        <div class="auth-header">
            <h4 class="mb-0 float">{{ __('Reset Password') }}</h4>
        </div>
        <div class="auth-body">
            <div class="mb-4 text-muted animated-element delay-1">
                {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <!-- Email Address -->
                <div class="mb-4 animated-element delay-2">
                    <x-input-label for="email" :value="__('Email')" class="mb-2 fw-bold" />
                    <x-text-input id="email" class="auth-input" type="email" name="email" :value="old('email')" required autofocus />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div class="d-flex justify-content-between align-items-center animated-element delay-3">
                    <a class="auth-link" href="{{ route('login') }}">
                        {{ __('Back to login') }}
                    </a>

                    <button type="submit" class="auth-btn pulse">
                        {{ __('Send Reset Link') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>

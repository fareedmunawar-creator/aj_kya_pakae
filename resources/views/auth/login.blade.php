<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card shadow-lg border-0 rounded-lg">
                    <div class="card-header gradient-primary text-white py-3">
                        <h3 class="text-center font-weight-light my-2">{{ __('Welcome Back') }}</h3>
                    </div>
                    <div class="card-body p-4">
                        <div class="text-center mb-4">
                            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="img-fluid mb-3" style="max-height: 80px;">
                            <p class="lead text-muted">{{ __('Sign in to your account') }}</p>
                        </div>
                        
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <!-- Email Address -->
                            <div class="mb-3">
                                <label for="email" class="form-label fw-bold">{{ __('Email Address') }}</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="bi bi-envelope"></i></span>
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="{{ __('Enter your email') }}">
                                </div>
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>

                            <!-- Password -->
                            <div class="mb-4">
                                <label for="password" class="form-label fw-bold">{{ __('Password') }}</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="bi bi-lock"></i></span>
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="{{ __('Enter your password') }}">
                                </div>
                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>

                            <!-- Remember Me -->
                            <div class="mb-4 form-check">
                                <input id="remember_me" type="checkbox" class="form-check-input" name="remember">
                                <label class="form-check-label" for="remember_me">{{ __('Remember me') }}</label>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="bi bi-box-arrow-in-right me-2"></i>{{ __('Sign In') }}
                                </button>
                            </div>
                            
                            <div class="d-flex justify-content-between align-items-center mt-4">
                                @if (Route::has('password.request'))
                                    <a class="text-decoration-none small" href="{{ route('password.request') }}">
                                        <i class="bi bi-question-circle me-1"></i>{{ __('Forgot your password?') }}
                                    </a>
                                @endif
                            </div>
                        </form>
                    </div>
                    <div class="card-footer text-center py-3 bg-light">
                        <div class="small">
                            {{ __('Don\'t have an account?') }} 
                            <a href="{{ route('register') }}" class="fw-bold text-decoration-none">
                                {{ __('Register now') }} <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>

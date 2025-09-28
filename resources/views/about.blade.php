@extends('layouts.app')

@section('title', 'About Us - Vision')

@section('content')
<div class="container py-5">
    <!-- Hero Section -->
    <div class="row mb-5 fade-in">
        <div class="col-lg-8 mx-auto text-center">
            <h1 class="display-4 fw-bold gradient-text mb-4">About Vision</h1>
            <p class="lead text-muted mb-4">Transforming the way you cook, one recipe at a time.</p>
            <div class="d-flex justify-content-center">
                <span class="badge bg-gold px-3 py-2 me-2">Established 2023</span>
                <span class="badge bg-primary-light text-primary px-3 py-2">Made with ❤️ in Pakistan</span>
            </div>
        </div>
    </div>

    <!-- Our Story Section -->
    <div class="card border-0 shadow-sm rounded-4 mb-5 slide-in-up">
        <div class="card-body p-5">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <h2 class="fw-bold mb-4">Our Story</h2>
                    <p class="mb-4">Vision was born from a simple idea: to make cooking accessible, enjoyable, and stress-free for everyone. We believe that good food brings people together, and our mission is to help you create delicious meals with confidence.</p>
                    <p>What started as a small project has grown into a comprehensive cooking companion that helps thousands of users plan meals, manage ingredients, and discover new recipes every day.</p>
                </div>
                <div class="col-lg-6">
                    <div class="position-relative rounded-4 overflow-hidden shadow-sm" style="height: 300px;">
                        <img src="https://images.unsplash.com/photo-1556911220-e15b29be8c8f?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1170&q=80" 
                             class="w-100 h-100 object-fit-cover" alt="Team cooking together">
                        <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark opacity-10"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div class="row mb-5">
        <div class="col-12 text-center mb-4">
            <h2 class="fw-bold gradient-text">What Makes Us Special</h2>
            <p class="text-muted">Discover the features that set Vision apart</p>
        </div>
        
        <div class="col-md-4 mb-4 slide-in-left" style="animation-delay: 0.1s;">
            <div class="card h-100 border-0 shadow-sm hover-lift">
                <div class="card-body p-4 text-center">
                    <div class="feature-icon-wrapper mb-3">
                        <i class="bi bi-search text-primary fs-1"></i>
                    </div>
                    <h4 class="fw-bold mb-3">Smart Recipe Search</h4>
                    <p class="text-muted">Find the perfect recipe based on ingredients you already have at home.</p>
                </div>
            </div>
        </div>
        
        <div class="col-md-4 mb-4 slide-in-up" style="animation-delay: 0.2s;">
            <div class="card h-100 border-0 shadow-sm hover-lift">
                <div class="card-body p-4 text-center">
                    <div class="feature-icon-wrapper mb-3">
                        <i class="bi bi-calendar-check text-primary fs-1"></i>
                    </div>
                    <h4 class="fw-bold mb-3">Meal Planning</h4>
                    <p class="text-muted">Plan your meals for the week with our intuitive drag-and-drop calendar.</p>
                </div>
            </div>
        </div>
        
        <div class="col-md-4 mb-4 slide-in-right" style="animation-delay: 0.3s;">
            <div class="card h-100 border-0 shadow-sm hover-lift">
                <div class="card-body p-4 text-center">
                    <div class="feature-icon-wrapper mb-3">
                        <i class="bi bi-basket text-primary fs-1"></i>
                    </div>
                    <h4 class="fw-bold mb-3">Pantry Management</h4>
                    <p class="text-muted">Keep track of your ingredients and get notified when you're running low.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Team Section -->
    <div class="card border-0 shadow-sm rounded-4 mb-5 slide-in-up">
        <div class="card-body p-5">
            <h2 class="fw-bold text-center mb-5">Meet Our Team</h2>
            <div class="row">
                <div class="col-lg-3 col-md-6 mb-4 text-center">
                    <div class="team-member hover-lift">
                        <div class="rounded-circle overflow-hidden mx-auto mb-3" style="width: 150px; height: 150px;">
                            <img src="https://randomuser.me/api/portraits/women/44.jpg" class="w-100 h-100 object-fit-cover" alt="Team Member">
                        </div>
                        <h5 class="fw-bold mb-1">Sarah Ahmed</h5>
                        <p class="text-primary mb-2">Founder & CEO</p>
                        <p class="small text-muted">Passionate foodie with a vision to make cooking accessible to everyone.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4 text-center">
                    <div class="team-member hover-lift">
                        <div class="rounded-circle overflow-hidden mx-auto mb-3" style="width: 150px; height: 150px;">
                            <img src="https://randomuser.me/api/portraits/men/32.jpg" class="w-100 h-100 object-fit-cover" alt="Team Member">
                        </div>
                        <h5 class="fw-bold mb-1">Ali Khan</h5>
                        <p class="text-primary mb-2">Head Chef</p>
                        <p class="small text-muted">Professional chef with 15 years of experience in international cuisine.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4 text-center">
                    <div class="team-member hover-lift">
                        <div class="rounded-circle overflow-hidden mx-auto mb-3" style="width: 150px; height: 150px;">
                            <img src="https://randomuser.me/api/portraits/women/68.jpg" class="w-100 h-100 object-fit-cover" alt="Team Member">
                        </div>
                        <h5 class="fw-bold mb-1">Fatima Zaidi</h5>
                        <p class="text-primary mb-2">Nutritionist</p>
                        <p class="small text-muted">Certified nutritionist ensuring all recipes are balanced and healthy.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4 text-center">
                    <div class="team-member hover-lift">
                        <div class="rounded-circle overflow-hidden mx-auto mb-3" style="width: 150px; height: 150px;">
                            <img src="https://randomuser.me/api/portraits/men/75.jpg" class="w-100 h-100 object-fit-cover" alt="Team Member">
                        </div>
                        <h5 class="fw-bold mb-1">Hassan Malik</h5>
                        <p class="text-primary mb-2">Tech Lead</p>
                        <p class="small text-muted">Tech enthusiast making sure our platform runs smoothly for all users.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- CTA Section -->
    <div class="card border-0 shadow-sm rounded-4 mb-5 cta-card slide-in-up" style="background: linear-gradient(135deg, #fad0c4 0%, #ff9a9e 100%);">
        <div class="card-body p-5 text-center">
            <h2 class="fw-bold text-white mb-4">Ready to Transform Your Cooking Experience?</h2>
            <p class="text-white mb-4">Join thousands of happy users who have discovered the joy of cooking with Vision.</p>
            <a href="{{ route('recipes.index') }}" class="btn btn-light btn-lg px-4 py-2 hover-lift">
                <i class="bi bi-journal-text me-2"></i>Explore Recipes
            </a>
        </div>
    </div>
</div>
@endsection
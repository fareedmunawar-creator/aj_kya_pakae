@extends('layouts.app')

@section('title', __('Profile'))

@section('content')
    <div class="container py-4">
        <div class="row">
            <div class="col-12">
                <h2 class="mb-4 fw-bold">{{ __('Profile') }}</h2>
            </div>
        </div>
        
        <div class="row g-4">
            <div class="col-md-12">
                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="card shadow-sm">
                    <div class="card-body">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

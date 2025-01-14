@extends('layouts.default')

@section('content')
<section class="content">
    <div class="body_scroll">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-7 col-md-6 col-sm-12">
                    <h2>Quote Request Details</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('home') }}"><i class="zmdi zmdi-home"></i> Home</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('quoterequests.index') }}">Quote Requests</a>
                        </li>
                        <li class="breadcrumb-item active">View Quote Request</li>
                    </ul>
                </div>
                <div class="col-lg-5 col-md-6 col-sm-12 text-right">
                    <a href="{{ route('quoterequests.index') }}" class="btn btn-primary btn-sm">
                        <i class="zmdi zmdi-arrow-left"></i> Back to List
                    </a>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="card shadow-lg">
                <div class="header bg-primary text-white">
                    <h2 class="text-white">Quote Request #{{ $quoteRequest->id }}</h2>
                </div>
                <div class="body">
                    <div class="row mb-3">
                        <!-- Company Information -->
                        <div class="col-md-4">
                            <div class="card border-info mb-3">
                                <div class="card-header bg-secondary text-white">
                                    <strong>Company Information</strong>
                                </div>
                                <div class="card-body">
                                    <p><strong>Company Name:</strong> {{ $quoteRequest->company }}</p>
                                    <p><strong>Contact Name:</strong> {{ $quoteRequest->contact_name }}</p>
                                    <p><strong>Email:</strong> <a href="mailto:{{ $quoteRequest->email }}">{{ $quoteRequest->email }}</a></p>
                                    <p><strong>Phone:</strong> <a href="tel:{{ $quoteRequest->phone }}">{{ $quoteRequest->phone }}</a></p>
                                </div>
                            </div>
                        </div>

                        <!-- Request Information -->
                        <div class="col-md-4">
                            <div class="card border-success mb-3">
                                <div class="card-header bg-secondary text-white">
                                    <strong>Request Information</strong>
                                </div>
                                <div class="card-body">
                                    <p><strong>Location:</strong> {{ $quoteRequest->location }}</p>
                                    <p><strong>Message:</strong> {{ $quoteRequest->message }}</p>
                                    <p><strong>Status:</strong>
                                        <span class="badge {{ $quoteRequest->status == 1 ? 'badge-success' : 'badge-warning' }}">
                                            {{ $quoteRequest->status == 1 ? 'Verified' : 'Not Verified' }}
                                        </span>
                                    </p>
                                    <p><strong>Machine:</strong> {{ $quoteRequest->sellmachine->title }}</p>
                                    <p><strong>Created At:</strong> {{ $quoteRequest->created_at->format('d M, Y h:i A') }}</p>
                                    <p><strong>Updated At:</strong> {{ $quoteRequest->updated_at->format('d M, Y h:i A') }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- User Information -->
                        <div class="col-md-4">
                            <div class="card border-warning mb-3">
                                <div class="card-header bg-secondary text-white">
                                    <strong>User Information</strong>
                                </div>
                                <div class="card-body">
                                    <p><strong>User Name:</strong> {{ $quoteRequest->user->name }}</p>
                                    <p><strong>User Email:</strong> <a href="mailto:{{ $quoteRequest->user->email }}">{{ $quoteRequest->user->email }}</a></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <a href="{{ route('quoterequests.index') }}" class="btn btn-secondary">
                                <i class="zmdi zmdi-arrow-left"></i> Back to List
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

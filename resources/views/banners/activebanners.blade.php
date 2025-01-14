@extends('layouts.default')

@section('content')
<section class="content">
    <div class="body_scroll">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-7 col-md-6 col-sm-12">
                    <h2>Active Boosted Ads</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('home')}}"><i class="zmdi zmdi-home"></i> Home</a></li>
                        <li class="breadcrumb-item active">Boosted Ads</li>
                    </ul>

                </div>

            </div>
        </div>

        @livewire('boosted-ad-filters',['status' => '1'])

    </div>
</section>
@endsection
@extends('layout.master')

    
@section('content')
     <section class="profile_section layout_padding">
        <div class="container">
            <div class="row">
               @include('profile.layout.sidebar')
                @yield('main')
            </div>
        </div>
    </section>
@endsection
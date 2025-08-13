@extends('layout.master')
@section('title', 'About Page')

@section('content')
@php
    $about = App\Models\About::first();
@endphp

<section class="about_section layout_padding">
        <div class="container">

            <div class="row">
                <div class="col-md-6 ">
                    <div class="img-box">
                        <img src="{{ asset('images/about-img.png') }}" alt="" />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="detail-box">
                        <div class="heading_container">
                            <h2>
                                {{ $about->title }}
                            </h2>
                        </div>
                        <p>
                            {{ $about->body }}
                        </p>
                        <a href="{{ $about->link }}">
                            مشاهده بیشتر
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@extends('layouts.master')

@section('title','首頁')

@section('content')
<header class="masthead bg-primary text-white text-center">
    <div class="container d-flex align-items-center flex-column">
        <!-- Masthead Avatar Image-->
        <img class="masthead-avatar mb-5" src="{{ asset('images/disaster-prevention-goods-svgrepo-com.svg') }}" alt="..." />
        <!-- Masthead Heading-->
        <h1 class="masthead-heading text-uppercase mb-0">多一分準備；多一份安心</h1>
        <!-- Icon Divider-->
        <div class="divider-custom divider-light">
            <div class="divider-custom-line"></div>
            <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
            <div class="divider-custom-line"></div>
        </div>
        <!-- Masthead Subheading-->
        <p class="masthead-subheading font-weight-light mb-0">凡事提前規劃周全，才能減少焦慮，心裡更加踏實安心。</p>
    </div>
</header>

<section class="page-section" id="contact">
    <div class="container">
        <!-- Contact Section Heading-->                
        <h2 class="page-section-heading text-center text-secondary mb-0">網站公告</h2>
        <!-- Icon Divider-->
        <div class="divider-custom">
            <div class="divider-custom-line"></div>
            <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
            <div class="divider-custom-line"></div>
        </div>
        <!-- Contact Section Form-->
        <div class="row justify-content-center">
            <div class="col-lg-3 col-xl-3">
                <div class="card" style="width: 100%;">
                    <img src="{{ asset('images/title1.png') }}" class="card-img-top" alt="...">
                    <div class="card-body">
                      <ul>
                        <li>
                            123
                        </li>
                        <li>
                            456
                        </li>
                      </ul>
                    </div>
                  </div>
            </div>
            <div class="col-lg-6 col-xl-6">
                <div class="card">                    
                    <div class="card-body">
                      <h5 class="card-title">最新公告</h5>
                      
                    </div>
                  </div>
            </div>
            <div class="col-lg-3 col-xl-3">
                <div class="card" style="width: 100%;">
                    <img src="{{ asset('images/title2.png') }}" class="card-img-top" alt="...">
                    <div class="card-body">
                        <ul>
                          <li>
                              123
                          </li>
                          <li>
                              456
                          </li>
                        </ul>
                      </div>
                  </div>
            </div>
        </div>
    </div>
</section>
@endsection
@extends('layouts.master')

@section('title','GSuite 登入')

@section('content')
<section class="page-section" id="contact">
    <div class="container">
        <!-- Contact Section Heading-->                
        <h2 class="page-section-heading text-center text-secondary mb-0">登入</h2>
        <!-- Icon Divider-->
        <div class="divider-custom">
            <div class="divider-custom-line"></div>
            <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
            <div class="divider-custom-line"></div>
        </div>        
        <div class="row justify-content-center">
            <div class="col-md-4">                            
                <div class="card">            
                    <div class="card-header d-flex align-items-center">
                        <a href="https://eip.chc.edu.tw" target="_blank"><img src="{{ asset('images/chc2.png') }}" alt="CHC Logo" width="50" class="me-2" style="margin-right:10px; border:1px solid #000000;"></a>
                        彰化縣教育雲端帳號登入
                    </div>
                    <div class="card-body">                
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">                        
                                <div class="text-center">
                                    <a href="{{ route('sso') }}" class="image-button2">
                                        <img src="{{ asset('images/chc.jpg') }}" alt="彰化chc的logo" width="120">
                                    </a>
                                    <br>OpenID登入
                                </div>
                                <div class="text-center mt-3">
                                    <a href="https://eip.chc.edu.tw/recovery-password" target="_blank" class="btn btn-warning">
                                        忘記密碼？
                                    </a>              
                                </div>
                                <div class="text-end">
                                    <a href="{{ route('login') }}" style="text-decoration: none;"><i class="fas fa-cog"></i> 使用本機帳號</a>
                                </div>                                                                      
                            </div>                               
                        </div>                                  
                    </div>
                </div>                               
            </div>
        </div>
    </div>
</section>
@endsection
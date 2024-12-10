@extends('layouts.master')

@section('title','GSuite 登入')

@section('content')
<section class="page-section" id="contact">
    <div class="container">
        <!-- Contact Section Heading-->                
        <h2 class="page-section-heading text-center text-secondary mb-0">彰化縣 <img class="masthead-avatar mb-5" src="{{ asset('images/gsuite_logo.png') }}" alt="..." /> 登入</h2>
        <!-- Icon Divider-->
        <div class="divider-custom">
            <div class="divider-custom-line"></div>
            <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
            <div class="divider-custom-line"></div>
        </div>
        <!-- Contact Section Form-->
        <div class="row justify-content-center">
            <div class="col-lg-8 col-xl-7">
                <!-- * * * * * * * * * * * * * * *-->
                <!-- * * SB Forms Contact Form * *-->
                <!-- * * * * * * * * * * * * * * *-->
                <!-- This form is pre-integrated with SB Forms.-->
                <!-- To make this form functional, sign up at-->
                <!-- https://startbootstrap.com/solution/contact-forms-->
                <!-- to get an API token!-->
                <form id="login_form" action="{{ route('gauth') }}" method="post">
                    @csrf
                    <!-- Name input-->
                    <div class="form-floating mb-3">
                        <input class="form-control" id="username" name="username" type="text" placeholder="輸入帳號..." data-sb-validations="required" required autofocus />
                        <label for="username">GSuite 帳號 ( 可省略 @chc.edu.tw )</label>
                        <div class="invalid-feedback" data-sb-feedback="username:required">必填欄位</div>
                    </div>
                    <div class="form-floating mb-3">
                        <input class="form-control" id="password" name="password" type="password" placeholder="輸入密碼..." data-sb-validations="required" required />
                        <label for="password">OpenID 密碼</label>
                        <div class="invalid-feedback" data-sb-feedback="password:required">必填欄位</div>
                    </div>
                    <!-- Phone number input-->
                    <div class="form-floating mb-3">
                        <input class="form-control" id="chaptcha" name="chaptcha" type="number" placeholder="輸入驗證碼..." maxlength="5" data-sb-validations="required" required />
                        <label for="chaptcha">驗證碼</label>
                        <div class="invalid-feedback" data-sb-feedback="chaptcha:required">必填欄位</div>                        
                    </div>                      
                    <div class="form-floating mb-3">                        
                        <a href="{{ route('glogin') }}"><img src="{{ route('pic') }}" class="img-fluid"></a><small class="text-secondary"> (按一下更換)</small>
                        <?php
                                $text = session('chaptcha');                                
                                $html = file_get_contents('https://translate.google.com/translate_tts?ie=UTF-8&client=tw-ob&q='.$text.'&tl=zh-TW');                                  
                        ?>
                        <audio controls id="myAudio"><source src="data:audio/mpeg;base64,{{ base64_encode($html) }}"></audio><br>                        
                        <span id="playButton"><a href="#!"><i class="fas fa-volume-up"></i> [語音播放]</a></span>
                    </div>                                                          
                    <!-- Submit error message-->
                    <!---->
                    <!-- This is what your users will see when there is-->
                    <!-- an error submitting the form-->
                    @include('layouts.errors')          
                    <div class="d-flex">
                        <a href="{{ route('login')}}" class="ms-auto text-decoration-none"><i class="fas fa-cog"></i> 管理者登入</a>
                    </div>          
                    <!-- Submit Button-->
                    <button class="btn btn-primary btn-xl" id="submitButton" type="submit">送出</button>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
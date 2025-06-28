@extends('layouts.master')

@section('title','本機登入')

@section('content')
<section class="page-section" id="contact">
    <div class="container">
        <!-- Contact Section Heading-->                
        <h2 class="page-section-heading text-center text-secondary mb-0">管理者及評審登入</h2>
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
                <form id="login_form" action="{{ route('auth') }}" method="post">
                    @csrf
                    <!-- Name input-->
                    <div class="form-floating mb-3">
                        <input class="form-control" id="username" name="username" type="text" placeholder="輸入帳號..." data-sb-validations="required" required autofocus />
                        <label for="username">本機帳號</label>
                        <div class="invalid-feedback" data-sb-feedback="username:required">必填欄位</div>
                    </div>
                    <div class="form-floating mb-3">
                        <input class="form-control" id="password" name="password" type="password" placeholder="輸入密碼..." data-sb-validations="required" required />
                        <label for="password">密碼</label>
                        <div class="invalid-feedback" data-sb-feedback="password:required">必填欄位</div>
                    </div>
                    <!-- Phone number input-->
                    <div class="form-floating mb-3">
                        <input class="form-control" id="chaptcha" name="chaptcha" type="number" placeholder="輸入驗證碼..." maxlength="5" data-sb-validations="required" required />
                        <label for="chaptcha">驗證碼</label>
                        <div class="invalid-feedback" data-sb-feedback="chaptcha:required">必填欄位</div>                        
                    </div>                      
                    <div class="form-floating mb-3">                        
                        <a href="{{ route('login') }}"><img src="{{ route('pic') }}" class="img-fluid"></a><small class="text-secondary"> (按一下更換)</small>
                        <?php
                                $text = session('chaptcha');                                
                                $a = substr($text,0,1);
                                $b = substr($text,1,1);
                                $c = substr($text,2,1);
                                $d = substr($text,3,1);
                                $e = substr($text,4,1);
                                $string = $a." ".$b." ".$c." ".$d." ".$e;
                                $string = urlencode($string);
                                $html = file_get_contents('https://translate.google.com/translate_tts?ie=UTF-8&client=tw-ob&q='.$string.'&tl=zh-TW');                                  
                        ?>
                        <audio id="myAudio"><source src="data:audio/mpeg;base64,{{ base64_encode($html) }}"></audio><br>                        
                        <span id="playButton"><a href="#!"><i class="fas fa-volume-up"></i> [語音播放]</a></span>
                    </div>                                                          
                    <!-- Submit error message-->
                    <!---->
                    <!-- This is what your users will see when there is-->
                    <!-- an error submitting the form-->
                    @include('layouts.errors')          
                    <div class="text-end">
                        <a href="{{ route('sso') }}" class="image-button2"><img src="{{ asset('images/chc.jpg') }}" alt="彰化chc的logo" width="80"></a>
                        <br>OpenID登入
                    </div>          
                    <!-- Submit Button-->
                    <button class="btn btn-primary btn-xl" id="submitButton" type="submit">送出</button>
                </form>
            </div>
        </div>
    </div>
</section>
<script>
    // 取得音頻和按鈕元素
    const audio = document.getElementById('myAudio');
    const playButton = document.getElementById('playButton');

    // 點擊按鈕時播放音樂
    playButton.addEventListener('click', () => {
        audio.play(); // 播放音頻
    });
</script>
@endsection
@extends('layouts.master')

@section('title','帳號管理')

@section('content')
<section class="page-section" id="contact">
    <div class="container">     
        <div class="row justify-content-center">
            <div class="col-lg-8 col-xl-7">
                <div class="card" >
                    <div class="card-body">
                        <h3 class="card-title">新增帳號</h5>
                            <form action="{{ route('user.store') }}" method="post" id="create_user" onsubmit="return false;">
                            @csrf
                            <div class="form-floating mb-3">
                                <input class="form-control" id="name" name="name" type="text" placeholder="輸入姓名..." data-sb-validations="required" required autofocus />
                                <label for="name">姓名</label>
                                <div class="invalid-feedback" data-sb-feedback="name:required">必填欄位</div>
                            </div>
                            <div class="form-floating mb-3">
                                <input class="form-control" id="username" name="username" type="text" placeholder="輸入帳號..." data-sb-validations="required" required autofocus />
                                <label for="username">本機帳號</label>
                                <div class="invalid-feedback" data-sb-feedback="username:required">必填欄位</div>
                            </div>
                            <div class="form-floating mb-3">
                                <input class="form-control" id="password1" name="password1" type="text" placeholder="輸入密碼1..." data-sb-validations="required" required />
                                <label for="password1">預設密碼</label>
                                <div class="invalid-feedback" data-sb-feedback="password1:required">必填欄位</div>
                            </div>
                            <div class="form-floating mb-3">
                                <input class="form-control" id="password2" name="password2" type="text" placeholder="再次輸入密碼..." data-sb-validations="required" required />
                                <label for="password1">再次輸入密碼</label>
                                <div class="invalid-feedback" data-sb-feedback="password2:required">必填欄位</div>
                            </div>
                            <div class="form-group mb-3">
                                <label for="password1">權限</label>
                                <select class="form-select form-select-lg mb-3" name="power" aria-label=".form-select-lg example">                                    
                                    <option value="review">評審</option>
                                    <option value="admin">系統管理者</option>                                    
                                </select>
                            </div>       
                            <input type="hidden" name="login_type" value="local">
                            @include('layouts.errors')          
                            <a href="{{ route('user.index') }}" class="btn btn-secondary">返回</a>
                            <button class="btn btn-primary" id="submitButton" type="submit" onclick="sw_confirm2('確定儲存','create_user')">送出</button>       
                        </form>                                          
                    </div>
                </div> 
            </div>
        </div>               
    </div>
</section>
@endsection
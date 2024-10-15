@extends('layouts.master')

@section('title','更改密碼')

@section('content')
<section class="page-section" id="contact">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-xl-7">
                <div class="card" >
                    <div class="card-body">
                        <h3 class="card-title">更改密碼</h3>
                        <form action="{{ route('password_update') }}" method="post" id="change_pwd">
                            @csrf
                            @method('patch')
                            <div class="form-group">
                                <label for="exampleInputPassword0">舊密碼*</label>
                                <input type="password" class="form-control" name="password0" id="oldpw" required autofocus>
                            </div>
                            <br>
                            <div class="form-group">
                                <label for="exampleInputPassword1">新密碼*</label>
                                <input type="password" class="form-control" name="password1" id="npw1" required>
                            </div>
                            <br>
                            <div class="form-group">
                                <label for="exampleInputPassword2">確認新密碼*</label>
                                <input type="password" class="form-control" name="password2" id="npw2" required>
                            </div>
                            <br>							
                            <a class="btn btn-primary btn-sm" onclick="checkPassword()"><i class="fas fa-save"></i> 送出</a>
                        </form>						
                        @include('layouts.errors')
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
	function checkPassword() {
			var password0 = document.getElementById("oldpw").value;
			var password1 = document.getElementById("npw1").value;
            var password2 = document.getElementById("npw2").value;

            // 檢查欄位是否為空
            if (password0 === "" || password1 === "" || password2 === "") {
                sw_alert("錯誤","密碼欄位不能為空！","error");
                clearFields();
                return false;
            }

            // 檢查兩個密碼是否相同
            if (password1 !== password2) {
				sw_alert("錯誤","兩個密碼不相同！","error");                
                clearFields();
                return false;
            }

            sw_confirm2('確定變更密碼？','change_pwd')
            return true;
        }

        function clearFields() {
            document.getElementById("npw1").value = "";
            document.getElementById("npw2").value = "";			
        }
</script>
@endsection
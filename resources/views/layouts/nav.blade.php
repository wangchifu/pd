<nav class="navbar navbar-expand-lg bg-secondary text-uppercase fixed-top" id="mainNav">
    <div class="container">
        <a class="navbar-brand" href="{{ route('index') }}">彰化縣學校防災教育網</a>
        <button class="navbar-toggler text-uppercase font-weight-bold bg-primary text-white rounded" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            Menu
            <i class="fas fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-3 px-0 px-lg-3 rounded" href="{{ route('post.index') }}">最新公告</a></li>
                <li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-3 px-0 px-lg-3 rounded" href="{{ route('result.index') }}">成果列表</a></li>
                @auth
                    @if(auth()->user()->review=="1")
                        <li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-3 px-0 px-lg-3 rounded" href="{{ route('reviewer.index') }}">審查學校</a></li>
                    @endif
                @endauth                    
                @guest
                <li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-3 px-0 px-lg-3 rounded" href="{{ route('glogin') }}">登入</a></li>
                @endguest
                @auth
                    @if(!empty(auth()->user()->school_name))                    
                        <li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-3 px-0 px-lg-3 rounded" href="{{ route('fill.index') }}">學校填報</a></li>
                    @endif
                    <li class="nav-item dropdown mx-0 mx-lg-1">
                        <a class="nav-link dropdown-toggle py-3 px-0 px-lg-3 rounded" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ auth()->user()->school_name }} {{ auth()->user()->name }}
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><span class="dropdown-item">{{ auth()->user()->title }} 你好</span></li>
                            @if(auth()->user()->login_type=="local")
                                <li><a class="dropdown-item" href="{{ route('password_edit') }}"><i class="fas fa-key"></i> 更改密碼</a></li>
                            @endif
                            @if(auth()->user()->admin=="1")
                                <li><hr class="dropdown-divider" style="width:80%;margin: 0 auto;"></li>                                                                
                                <li><a class="dropdown-item" href="{{ route('user.index') }}"><i class="fas fa-user"></i> 帳號管理</a></li>
                                <li><a class="dropdown-item" href="{{ route('link.index') }}"><i class="fas fa-link"></i> 連結管理</a></li>
                                <li><hr class="dropdown-divider" style="width:80%;margin: 0 auto;"></li>      
                                <li><a class="dropdown-item" href="{{ route('report.index') }}"><i class="fas fa-list-ol"></i> 1.填報管理</a></li>                                
                                <li><a class="dropdown-item" href="{{ route('review.index') }}"><i class="fas fa-user-edit"></i> 2.評審與學校</a></li>                                
                            @endif                            
                            <li><hr class="dropdown-divider" style="width:80%;margin: 0 auto;"></li>
                            @impersonating                            
                                <li><a class="dropdown-item" href="#!" onclick="return sw_confirm1('確定返回原本帳琥？','{{ route('impersonate_leave') }}')"><i class="fas fa-user-slash"></i> 結束模擬</a></li>
                            @endImpersonating
                            <li><a class="dropdown-item" href="#!" onclick="sw_confirm1('確定登出？','{{ route('logout') }}')"><i class="fas fa-sign-out-alt"></i> 登出</a></li>
                        </ul>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>
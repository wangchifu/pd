@extends('layouts.master')

@section('title','帳號管理')

@section('content')
<section class="page-section" id="contact">
    <div class="container">
        <div class="mb-2">
            <a href="{{ route('user.create') }}" class="btn btn-primary">新增帳號</a>
        </div>        
        <div class="card" >
            <div class="card-body">
                <h3 class="card-title">帳號管理</h3>
                <form action="{{ route('user.search') }}" method="post">
                    @csrf
                    <table>
                        <tr>
                            <td>
                                <input type="text" name="want" class="form-control" style="width: 150px;">
                            </td>
                            <td>
                                <button type="submit" class="btn btn-sm btn-dark">搜尋</button>
                            </td>
                        </tr>
                    </table>                     
                </form>
                <table class="table table-hover table-bordered">
                    <thead class="bg-secondary text-light">
                        <tr>
                            <th>
                                姓名(帳號)
                            </th>
                            <th>
                                登入類型
                            </th>
                            <th>
                                學校
                            </th>
                            <th>
                                職稱
                            </th>
                            <th>
                                系統權限
                            </th>
                            <th>
                                動作
                            </th>
                        </tr>
                    </thead>                    
                    <tbody>
                        @foreach($users as $user)                        
                            <tr>
                                <td>
                                    @if(empty($user->disable))
                                        <i class="fas fa-check text-success"></i> 
                                    @else
                                        <i class="fas fa-times text-danger"></i> 
                                    @endif
                                    {{ $user->name }} ({{ $user->username }})
                                    @if(auth()->user()->id != $user->id)
                                        <a class="btn btn-info btn-sm" href="#!" onclick="sw_confirm1('確定模擬他？','{{ route('impersonate',$user->id) }}')">模擬</a>
                                    @endif
                                </td>
                                <td>
                                    @if($user->login_type=="gsuite")
                                        GSuite 認證
                                    @endif
                                    @if($user->login_type=="local")
                                        本機帳號
                                    @endif
                                </td>
                                <td>
                                    {{ $user->school_code }}
                                    {{ $user->school_name }}
                                </td>
                                <td>
                                    {{ $user->title }}
                                </td>
                                <td>
                                    @if($user->admin=="1")
                                        <span class="text-primary"><i class="fas fa-crown"></i> 系統管理者</span>
                                    @endif
                                    @if($user->review=="1")
                                        <span class="text-warning"><i class="fas fa-star"></i> 評審</span>
                                    @endif
                                    @if(empty($user->admin) and empty($user->review))
                                        一般使用者
                                    @endif
                                </td>
                                <td>                                    
                                    @if(empty($user->disable))
                                        @if(auth()->user()->id != $user->id)
                                            <a href="#!" class="btn btn-secondary btn-sm" onclick="sw_confirm1('確定停用？','{{ route('user.change_user',$user->id) }}')">停用</a>
                                        @endif
                                    @else
                                    <a href="#!" class="btn btn-outline-secondary btn-sm" onclick="sw_confirm1('確定再啟用？','{{ route('user.change_user',$user->id) }}')">再啟用</a>
                                    @endif
                                    @if(empty($user->admin))
                                        <a href="#!" class="btn btn-primary btn-sm" onclick="sw_confirm1('確定他是評審？','{{ route('user.add_user_power',['user'=>$user->id,'power'=>'admin']) }}')">設為系統管理者</a>                                        
                                    @else
                                        @if(auth()->user()->id != $user->id)
                                            <a href="#!" class="btn btn-outline-primary btn-sm" onclick="sw_confirm1('取消他的系統管理權？','{{ route('user.remove_user_power',['user'=>$user->id,'power'=>'admin']) }}')">取消系統管理權</a>
                                        @endif
                                    @endif
                                    @if(empty($user->review))
                                        <a href="#!" class="btn btn-warning btn-sm" onclick="sw_confirm1('確定他是評審？','{{ route('user.add_user_power',['user'=>$user->id,'power'=>'review']) }}')">設為評審</a>
                                    @else
                                        <a href="#!" class="btn btn-outline-warning btn-sm" onclick="sw_confirm1('取消他是評審？','{{ route('user.remove_user_power',['user'=>$user->id,'power'=>'review']) }}')">取消評審權</a>
                                    @endif                                                                                
                                </td>
                            </tr>
                        @endforeach
                    </tbody>                    
                </table>
                <div class="d-flex justify-content-left">						
                    {{ $users->withQueryString()->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>        
    </div>
</section>
@endsection
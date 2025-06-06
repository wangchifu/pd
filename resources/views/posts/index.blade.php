@extends('layouts.master')

@section('title','公告系統')

@section('content')
<section class="page-section" id="contact">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ route('index') }}" class="text-decoration-none">首頁</a></li>              
              <li class="breadcrumb-item active" aria-current="page">公告系統</li>
            </ol>
          </nav>
        <div class="card">                    
            <div class="card-body">
              <h3 class="card-title">最新公告</h3>
              @auth
                @if(auth()->user()->admin=="1")
                    <a href="{{ route('post.create') }}" class="btn btn-primary">新增公告</a>                  
                @endif
              @endauth
              <div class="table-responsive">
                <table class="table table-hover table-bordered">                        
                    <thead class="bg-secondary text-light">
                        <tr>
                            <th nowrap>
                                公告標題
                            </th>
                            <td style="width:80px;" nowrap>
                                動作
                            </td>
                            <th style="width:100px;" nowrap>
                                發佈人
                            </th>
                            <th style="width:150px;" nowrap>
                                發佈時間
                            </th>                                
                            <th style="width:60px;" nowrap>
                                點閱
                            </th>                                
                        </tr>
                    </thead>                    
                    <tbody>       
                        @foreach($posts as $post)                     
                            <tr>
                                <td>
                                    {{ $post->title }}
                                    <?php
                                        $files = get_files(storage_path('app/public/posts/'.$post->id));                                        
                                    ?>
                                    @if(!empty($files))
                                        <i class="fas fa-download"></i>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('post.show',$post->id) }}" class="btn btn-secondary btn-sm">
                                        查看
                                    </a>
                                </td>
                                <td>
                                    {{ $post->user->name }}
                                </td>
                                <td>
                                    {{ $post->user->created_at }}
                                </td>
                                <td>
                                    {{ $post->views }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $posts->withQueryString()->links('pagination::bootstrap-5') }}
              </div>
            </div>
        </div>     
    </div>
</section>
@endsection
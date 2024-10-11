@extends('layouts.master')

@section('title','顯示公告')

@section('content')
<section class="page-section" id="contact">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ route('index') }}" class="text-decoration-none">首頁</a></li>
              <li class="breadcrumb-item"><a href="{{ route('post.index') }}" class="text-decoration-none">公告系統</a></li>
              <li class="breadcrumb-item active" aria-current="page">{{ $post->title }}</li>
            </ol>
          </nav>
        <div class="card">                    
            <div class="card-body">                
              <h3 class="card-title">{{ $post->title }}</h3>
              <span style="color:gray">公告：{{ $post->user->name }} / 時間：{{ $post->created_at }} / 點閱：{{ $post->views }}</span>
              @auth
                @if(auth()->user()->id == $post->user_id)
                    <a href="{{ route('post.edit',$post->id) }}" class="btn btn-success btn-sm">編輯</a>
                    <a href="#!" class="btn btn-danger btn-sm" onclick="sw_confirm1('確定刪除？','{{ route('post.destroy',$post->id) }}')">刪除</a>
                @endif
              @endauth
              <hr>
                {!! nl2br($post->content) !!}              
              @if(!empty($files))  
                <br><br>  
                附件下載：<br>                
                    @foreach($files as $k=>$v)
                        <a href="{{ asset('storage/posts/'.$post->id.'/'.$v) }}" class="btn btn-primary btn-sm" style="margin:3px" target="_blank"><i class="fas fa-download"></i> {{ $v }}</a>
                    @endforeach    
                                   
              @endif    
              <hr>                        
              <button class="btn btn-dark" onclick="window.history.back();">返回</button>
            </div>
        </div>     
    </div>
</section>
@endsection
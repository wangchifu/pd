@extends('layouts.master')

@section('title','編輯公告')

@section('content')
<section class="page-section" id="contact">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ route('index') }}" class="text-decoration-none">首頁</a></li>
              <li class="breadcrumb-item"><a href="{{ route('post.index') }}" class="text-decoration-none">公告系統</a></li>
              <li class="breadcrumb-item active" aria-current="page">編輯公告</li>
            </ol>
          </nav>
        <div class="card">                    
            <div class="card-body">
              <h3 class="card-title">編輯公告</h3>
                <form action="{{ route('post.update',$post->id) }}" method="post" enctype="multipart/form-data" id="update_post">
                    @csrf
                    <div class="mb-3">
                        <label for="title" class="form-label text-danger">公告標題*</label>
                        <input type="text" class="form-control" id="title" name="title" value="{{ $post->title }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="content" class="form-label text-danger">公告內容*</label>
                        <textarea class="form-control" id="content" name="content" rows="6" required>{{ $post->content }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="files" class="form-label">附加檔案</label>
                        @if(!empty($files))  
                            @foreach($files as $k=>$v)
                            <a href="#!" class="btn btn-danger btn-sm" onclick="sw_confirm1('確定刪除？','{{ route('post.delete_file',['post'=>$post->id,'filename'=>$v]) }}')" style="margin: 5px;"><i class="fas fa-times-circle"></i> {{ $v }}</a>                                
                            @endforeach                                       
                        @endif 
                        <input class="form-control" type="file" id="files" name="files[]" multiple>
                    </div>
                    @include('layouts.errors')
                    <a href="{{ route('post.index') }}" class="btn btn-dark">返回</a>
                    <a href="#!" class="btn btn-primary" onclick="sw_confirm2('確定儲存？','update_post')">儲存公告</a>
                </form>
            </div>
        </div>     
    </div>
</section>
@endsection
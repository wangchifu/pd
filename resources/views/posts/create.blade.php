@extends('layouts.master')

@section('title','新增公告')

@section('content')
<section class="page-section" id="contact">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ route('index') }}" class="text-decoration-none">首頁</a></li>
              <li class="breadcrumb-item"><a href="{{ route('post.index') }}" class="text-decoration-none">公告系統</a></li>
              <li class="breadcrumb-item active" aria-current="page">新增公告</li>
            </ol>
          </nav>
        <div class="card">                    
            <div class="card-body">
              <h3 class="card-title">新增公告</h3>
                <form action="{{ route('post.store') }}" method="post" enctype="multipart/form-data" id="create_post">
                    @csrf
                    <div class="mb-3">
                        <label for="title" class="form-label text-danger">公告標題*</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label for="content" class="form-label text-danger">公告內容*</label>
                        <textarea class="form-control" id="content" name="content" rows="6" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="files" class="form-label">附加檔案</label>
                        <input class="form-control" type="file" id="files" name="files[]" multiple>
                    </div>
                    <a href="{{ route('post.index') }}" class="btn btn-dark">返回</a>
                    <a href="#!" class="btn btn-primary" onclick="sw_confirm2('確定儲存？','create_post')">儲存公告</a>
                </form>
            </div>
        </div>     
    </div>
</section>
@endsection
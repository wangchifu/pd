@extends('layouts.master')

@section('title','首頁')

@section('content')
<header class="masthead bg-primary text-white text-center">
    <div class="container d-flex align-items-center flex-column">
        <!-- Masthead Avatar Image-->
        <img class="masthead-avatar mb-5" src="{{ asset('images/disaster-prevention-goods-svgrepo-com.svg') }}" alt="..." />
        <!-- Masthead Heading-->
        <h1 class="masthead-heading text-uppercase mb-0">多一分準備；多一份安心</h1>
        <!-- Icon Divider-->
        <div class="divider-custom divider-light">
            <div class="divider-custom-line"></div>
            <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
            <div class="divider-custom-line"></div>
        </div>
        <!-- Masthead Subheading-->
        <p class="masthead-subheading font-weight-light mb-0">凡事提前規劃周全，才能減少焦慮，心裡更加踏實安心。</p>
    </div>
</header>

<section class="page-section" id="contact">
    <div class="container">
        <!-- Contact Section Heading-->                
        <h2 class="page-section-heading text-center text-secondary mb-0">網站公告</h2>
        <!-- Icon Divider-->
        <div class="divider-custom">
            <div class="divider-custom-line"></div>
            <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
            <div class="divider-custom-line"></div>
        </div>
        <!-- Contact Section Form-->
        <div class="row justify-content-center">
            <!--
            <div class="col-lg-2 col-xl-2">
                <div class="list-group">
                    <a class="list-group-item p-0 disabled">
                        <img src="{{ asset('images/title1.png') }}" alt="Image" class="img-fluid w-100">
                    </a>
                    @foreach($link1s as $link)
                        <a href="{{ $link->url }}" class="list-group-item list-group-item-action" target="_blank">{{ $link->title }}</a>                    
                    @endforeach
                </div>  
            </div>
            -->
            <div class="col-lg-10 col-xl-10">
                <div class="card">                    
                    <div class="card-body">
                      <h5 class="card-title">最新公告</h5>
                      @auth
                        @if(auth()->user()->admin=="1")
                            <a href="{{ route('post.create') }}" class="btn btn-primary">新增公告</a>                  
                        @endif
                      @endauth
                      <div class="table-responsive">
                        <table class="table table-hover table-bordered">                        
                            <thead class="bg-secondary text-light">
                                <tr>
                                    <th style="width:600px;" nowrap>
                                        公告標題
                                    </th>
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
                                            <a href="{{ route('post.show',$post->id) }}" class="text-decoration-none">
                                                {{ $post->title }}
                                            </a>
                                            <?php
                                                $files = get_files(storage_path('app/public/posts/'.$post->id));                                        
                                             ?>
                                            @if(!empty($files))
                                                <i class="fas fa-download"></i>
                                            @endif
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
                      </div>
                      <a href="{{ route('post.index') }}" class="text-decoration-none">...更多公告</a>
                    </div>
                  </div>
            </div>
            <div class="col-lg-2 col-xl-2">
                <div class="list-group">
                    <a class="list-group-item p-0 disabled">
                        <img src="{{ asset('images/title2.png') }}" alt="Image" class="img-fluid w-100">
                    </a>
                    @foreach($link2s as $link)
                        <a href="{{ $link->url }}" class="list-group-item list-group-item-action" target="_blank">{{ $link->title }}</a>                    
                    @endforeach
                </div>                                  
            </div>
        </div>
    </div>
</section>
@endsection
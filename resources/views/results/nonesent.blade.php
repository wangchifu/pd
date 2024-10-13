@extends('layouts.master')

@section('title','未送完成果')

@section('content')
<section class="page-section" id="contact">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ route('index') }}" class="text-decoration-none">首頁</a></li>
              <li class="breadcrumb-item"><a href="{{ route('result.index') }}" class="text-decoration-none">成果列表</a></li>
              <li class="breadcrumb-item active" aria-current="page">填報...</li>
            </ol>
          </nav>
          <div class="card" >
            <div class="card-body">
                <h3 class="card-title">未送完成果</h3>
                @foreach($schools as $school)
                  @if($upload_count != $school_fill[$school->code])  
                    {{ $school->name }},
                  @endif
                @endforeach
            </div>
        </div>
    </div>
</section>
@endsection
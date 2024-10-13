@extends('layouts.master')

@section('title','填報成果')

@section('content')
<section class="page-section" id="contact">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('index') }}" class="text-decoration-none">首頁</a></li>
                <li class="breadcrumb-item"><a href="{{ route('result.index') }}" class="text-decoration-none">成果列表</a></li>              
                <li class="breadcrumb-item active" aria-current="page">各校列表</li>
            </ol>
        </nav>
        <div class="card" >
            <div class="card-body">
                <h3 class="card-title">填報「{{ $report->title }}」成果</h3>
                @foreach($township_ids as $k=>$v)
                    <h4><i class="fab fa-fort-awesome"></i> {{ $k }}</h4>
                    @foreach($school_array[$v] as $k1=>$v1)
                        <?php
                            $color = "secondary";                            
                            if(str_contains($v1,'國小')) $color = "primary";
                            if(str_contains($v1,'國中')) $color = "success";
                            if(str_contains($v1,'國中小')) $color = "warning";
                            if(str_contains($v1,'高中')) $color = "info";

                            $disabled = "disabled";
                            $onclick = "";
                            if($school_fill[$k1]>0){
                                $disabled = "";
                                $onclick = "window.location.href = '".route('result.show',['report'=>$report->id,'code'=>$k1])."'";
                            }
                        ?>
                        <button type="button" class="btn btn-{{ $color }} position-relative mx-2 my-2 {{ $disabled }}" onclick="{{ $onclick }}">
                            {{ $v1 }}
                            @if($school_fill[$k1]>0)
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                    {{ $school_fill[$k1] }}                                                        
                                </span>
                            @endif
                        </button>
                    @endforeach
                    <hr>
                @endforeach
            </div>
        </div>
    </div>
</section>
@endsection
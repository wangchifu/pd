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
                            if($report->id >1 and $v1=='民靖國小') continue; //114年起 民靖滅校
                            
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
                            $award = \App\Models\Opinion::where('report_id',$report->id)->where('school_code','like','%'.$k1.'%')->first();
                        ?>                        
                        <button type="button" class="btn btn-{{ $color }} position-relative mx-2 my-2 {{ $disabled }}" onclick="{{ $onclick }}">
                            @if(!empty($award->id))
                                @if($award->open==1)                                    
                                    @if($award->grade=="特優")
                                        <span class="badge bg-warning"><i class="fas fa-crown"></i> 特優</span>
                                    @endif
                                    @if($award->grade=="優等")
                                        <span class="badge bg-success"><i class="fas fa-star"></i> 優等</span>
                                    @endif
                                    @if($award->grade=="甲等")
                                        <span class="badge bg-info"><i class="fas fa-thumbs-up"></i> 甲等</span>
                                    @endif
                                @endif
                            @endif
                            {{ $v1 }}
                            @if($school_fill[$k1]>0)
                                <span class="badge bg-light text-dark">{{ $school_fill[$k1] }}</span>
                            @endif                                               
                            @if(!empty($award->recommend))
                                @if($award->open==1)
                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">                                    
                                        👍推薦               
                                    </span>
                                @endif
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
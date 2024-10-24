@extends('layouts.master')

@section('title','學校填報')

@section('content')
<section class="page-section" id="contact">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ route('index') }}" class="text-decoration-none">首頁</a></li>              
              <li class="breadcrumb-item active" aria-current="page">學校填報</li>
            </ol>
          </nav>
        <div class="card" >
            <div class="card-body">
                <h3 class="card-title">「{{ $school->name }}」填報</h3>
                @include('layouts.errors')
                <table class="table table-hover table-bordered">
                    <thead class="bg-secondary text-light">
                        <tr>
                            <th>
                                成果項目 
                            </th>
                            <th style="width:150px;">
                                填報時間
                            </th>
                            <th>
                                動作
                            </th>
                        </tr>
                    </thead>
                    @foreach($reports as $report)
                        <?php 
                            $opinion = \App\Models\Opinion::where('report_id',$report->id)
                                ->where('school_code','like','%'.auth()->user()->school_code.'%')
                                ->first();
                        ?>                   
                        <tr>
                            <td>
                                {{ $report->title }}
                            </td>
                            <td>
                                <span class="text-nowrap">起：{{ $report->start_date }}</span><br>
                                <span class="text-nowrap">迄：{{ $report->stop_date }}</span>
                            </td>
                            <td>
                                @if(date('Y-m-d') >= $report->start_date and date('Y-m-d') <= $report->stop_date)
                                    <a href="{{ route('fill.create',$report->id) }}" class="btn btn-primary text-nowrap">進入填報</a>
                                @elseif(date('Y-m-d') < $report->start_date)
                                    <span class="text-nowrap">非上傳期間</span>
                                @else
                                    @if(!empty($opinion->id))                                
                                        @if($opinion->open==1)                                        
                                            <a href="{{ route('fill.award',$report->id) }}" class="btn btn-warning text-nowrap"><i class="fas fa-award"></i> 評審結果</a>
                                        @else
                                            <span class="text-nowrap">靜待公佈中</span>
                                        @endif                                    
                                    @else
                                        <span class="text-nowrap">靜待審查中</span>
                                    @endif                                    
                                @endif

                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
</section>
@endsection
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
                <h3 class="card-title">學校填報</h3>
                @include('layouts.errors')
                <table class="table table-hover table-bordered">
                    <thead class="bg-secondary text-light">
                        <tr>
                            <th>
                                成果項目 
                            </th>
                            <th style="width:200px;">
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
                                起：{{ $report->start_date }}<br>
                                迄：{{ $report->stop_date }}
                            </td>
                            <td>
                                @if(date('Y-m-d') >= $report->start_date and date('Y-m-d') <= $report->stop_date)
                                    <a href="{{ route('fill.create',$report->id) }}" class="btn btn-primary">進入填報</a>
                                @else
                                    @if(!empty($opinion->id))                                        
                                        <a href="{{ route('fill.award',$report->id) }}" class="btn btn-warning"><i class="fas fa-award"></i> 評審結果</a>
                                    @else
                                        非上傳期間
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
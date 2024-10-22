@extends('layouts.master')

@section('title','查閱結果')

@section('content')
<section class="page-section" id="contact">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ route('index') }}" class="text-decoration-none">首頁</a></li>
              <li class="breadcrumb-item"><a href="{{ route('reviewer.index') }}" class="text-decoration-none">審查學校列表</a></li>
              <li class="breadcrumb-item active" aria-current="page">{{ $group_name }}查閱結果</li>
            </ol>
          </nav>
        <div class="card" >
            <div class="card-body">
                <h3 class="card-title">「{{ $report->title }}」{{ $group_name }}查閱結果</h3>
                @include('layouts.errors')
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="bg-secondary text-light">
                            <tr>
                                <td style="width:150px;" nowrap>
                                    等級
                                </td>
                                <th nowrap>
                                    學校名稱 
                                </th>
                                @foreach($report->comments as $comment)
                                    <th style="width:50px;">
                                       {{ $comment->title }} 
                                    </th>
                                @endforeach
                                <th style="width:50px;">
                                    總分
                                </th>
                                <th>
                                    綜合意見
                                </th>
                                <td style="width:150px;" nowrap>
                                    選擇等級
                                </td>
                            </tr>
                        </thead>
                        <tbody>                                                     
                            @foreach($total_score as $k=>$v)
                                <tr>                                    
                                    <td>
                                        @if(isset($grade[$k]))
                                            @if($grade[$k]=="特優")
                                                <span class="badge bg-warning"><i class="fas fa-crown"></i> 特優</span>
                                                <a href="{{ route('reviewer.reward_remove',['report'=>$report->id,'school_code'=>$k]) }}"><i class="fas fa-times-circle text-danger"></i>
                                            @endif
                                            @if($grade[$k]=="優等")
                                                <span class="badge bg-success"><i class="fas fa-star"></i> 優等</span>
                                                <a href="{{ route('reviewer.reward_remove',['report'=>$report->id,'school_code'=>$k]) }}"><i class="fas fa-times-circle text-danger"></i>
                                            @endif
                                            @if($grade[$k]=="甲等")
                                                <span class="badge bg-info"><i class="fas fa-thumbs-up"></i> 甲等</span>
                                                <a href="{{ route('reviewer.reward_remove',['report'=>$report->id,'school_code'=>$k]) }}"><i class="fas fa-times-circle text-danger"></i>
                                            @endif
                                            @if($grade[$k]=="受訪")
                                                <span class="badge bg-danger"><i class="fas fa-sad-cry"></i> 受訪</span>
                                                <a href="{{ route('reviewer.reward_remove',['report'=>$report->id,'school_code'=>$k]) }}"><i class="fas fa-times-circle text-danger"></i>
                                            @endif
                                        @endif                                        
                                    </td>
                                    <td>
                                        {{ $schools_name[$k] }}
                                    </td>
                                    @foreach($report->comments as $comment)
                                        <td>
                                            @if(isset($score_data[$k][$comment->id]))
                                                {{ $score_data[$k][$comment->id] }}
                                            @endif                                        
                                        </td>
                                    @endforeach
                                    <td>
                                        {{ $v }}
                                    </td>
                                    <td>
                                        @if(isset($suggestion[$k]))
                                            {!! nl2br($suggestion[$k]) !!}
                                        @endif 
                                    </td>
                                    <td>
                                        @if(empty($grade[$k]))
                                            <a href="{{ route('reviewer.reward',['report'=>$report->id,'school_code'=>$k,'grade'=>'特優']) }}" class="btn btn-light btn-sm mx-1 my-1">特優</a>
                                            <a href="{{ route('reviewer.reward',['report'=>$report->id,'school_code'=>$k,'grade'=>'優等']) }}" class="btn btn-light btn-sm mx-1 my-1">優等</a>
                                            <a href="{{ route('reviewer.reward',['report'=>$report->id,'school_code'=>$k,'grade'=>'甲等']) }}" class="btn btn-light btn-sm mx-1 my-1">甲等</a>
                                            <a href="{{ route('reviewer.reward',['report'=>$report->id,'school_code'=>$k,'grade'=>'受訪']) }}" class="btn btn-light btn-sm mx-1 my-1">受訪</a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach                            
                        </tbody>
                    </table>
                    <button class="btn btn-secondary" onclick="history.go(-1);">返回</button>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
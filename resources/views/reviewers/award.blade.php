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
                            </tr>
                        </thead>
                        <tbody>                                                     
                            @foreach($total_score as $k=>$v)
                                <tr>
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
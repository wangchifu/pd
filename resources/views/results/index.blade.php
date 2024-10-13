@extends('layouts.master')

@section('title','成果列表')

@section('content')
<section class="page-section" id="contact">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ route('index') }}" class="text-decoration-none">首頁</a></li>              
              <li class="breadcrumb-item active" aria-current="page">成果列表</li>
            </ol>
          </nav>
        <div class="card" >
            <div class="card-body">
                <h3 class="card-title">成果列表</h3>
                @include('layouts.errors')
                <table class="table table-hover table-bordered">
                    <thead class="bg-secondary text-light">
                        <tr>
                            <th>
                                成果項目 
                            </th>
                            <th style="width:50px">
                                題數
                            </th>
                            <th style="width:50px">
                                應填
                            </th>
                            <th style="width:50px">
                                已填
                            </th>
                            <th style="width:50px">
                                未填
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
                        <tr>
                            <td>
                                {{ $report->title }}
                            </td>
                            <td>
                                {{ $upload_count[$report->id] }}
                            </td>
                            <td>
                                {{ $schools_num }}
                            </td>
                            <td>
                                {{ $school_has_finish[$report->id] }}
                            </td>
                            <th style="color:red">
                                <a href="{{ route('result.nonesent',$report->id) }}" class="btn btn-danger btn-sm">
                                    {{ $schools_num - $school_has_finish[$report->id] }}
                                </a>
                            </th>
                            <td>
                                起：{{ $report->start_date }}<br>
                                迄：{{ $report->stop_date }}
                            </td>
                            <td>
                                @if(date('Y-m-d') > $report->stop_date)
                                    <a href="{{ route('result.view',$report->id) }}" class="btn btn-primary">進入觀看</a>
                                @else
                                    非公開期間 {{ date('Y-m-d') }}
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
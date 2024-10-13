@extends('layouts.master')

@section('title','學校填報')

@section('content')
<section class="page-section" id="contact">
    <div class="container">
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
                                    非上傳期間
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
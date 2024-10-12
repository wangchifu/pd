@extends('layouts.master_clean')

@section('title','修改評分項目')

@section('content')
<section class="page-section" style="margin-top: -50px;">
    <div class="container">        
        <div class="card" >
            <div class="card-body">
                <h3 class="card-title">修改「{{ $report->title }}」評分項目</h5>
                    <table class="table table-hover table-bordered">                        
                        <thead class="bg-secondary text-light">
                            <tr>
                                <th>
                                    項目名稱
                                </th>
                                <th style="width:100px;">
                                    占分
                                </th>
                                <th style="width:100px;">
                                    排序
                                </th>
                            </tr>
                        </thead>                    
                        <tbody>
                            <form action="{{ route('report.comment_update',$comment->id) }}" method="post" id="comment_update">
                                <tr style="background-color: rgba(223, 216, 214, 0.493);">
                                    @csrf
                                    <td>                                    
                                        <input type="text" class="form-control" name="title" required value="{{ $comment->title }}"> 
                                        <input type="hidden" name="report_id" value="{{ $report->id }}">
                                        <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">                                                                                    
                                    </td>
                                    <td>
                                        <input type="number" class="form-control" name="score" required value="{{ $comment->score }}">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" name="order_by" value="{{ $comment->order_by }}">
                                    </td>                                    
                                </tr>
                                <tr class="bg-secondary text-light">
                                    <th colspan="3">
                                        評分標準
                                    </th>
                                </tr>
                                <tr>
                                    <td colspan="3">
                                        <textarea class="form-control" name="standard" rows="6">{{ $comment->standard }}</textarea>
                                    </td>
                                </tr>
                            </form>
                        </tbody>
                    </table>
                    @include('layouts.errors')
                    <a href="#!" class="btn btn-primary" onclick="sw_confirm2('確定儲存俢改？','comment_update')">儲存</a>
                    <div class="text-end">
                        <a href="#!" onclick="sw_confirm1('確定刪除？','{{ route('report.comment_destroy',$comment->id) }}')">
                            <i class="fas fa-times-circle text-danger"></i>
                        </a>
                    </div>
            </div>
        </div>        
    </div>
</section>
@endsection
@extends('layouts.master_clean')

@section('title','新增評分項目')

@section('content')
<section class="page-section" style="margin-top: -50px;">
    <div class="container">        
        <div class="card" >
            <div class="card-body">
                <h3 class="card-title">新增「{{ $report->title }}」評分項目</h5>
                    <table class="table table-hover table-bordered">                        
                        <thead class="bg-secondary text-light">
                            <tr>
                                <th>
                                    項目名稱*
                                </th>
                                <th style="width:100px;">
                                    占分*
                                </th>
                                <th style="width:100px;">
                                    排序
                                </th>
                            </tr>
                        </thead>                    
                        <tbody>
                            <form action="{{ route('report.comment_store') }}" method="post" id="comment_store">
                                <tr style="background-color: rgba(223, 216, 214, 0.493);">
                                    @csrf
                                    <td>                                    
                                        <input type="text" class="form-control" name="title" required> 
                                        <input type="hidden" name="report_id" value="{{ $report->id }}">
                                        <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">                                                                                    
                                    </td>
                                    <td>
                                        <input type="number" class="form-control" name="score" required>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" name="order_by">
                                    </td>                                    
                                </tr>
                                <tr class="bg-secondary text-light">
                                    <th colspan="3">
                                        評分標準
                                    </th>
                                </tr>
                                <tr>
                                    <td colspan="3">
                                        <textarea class="form-control" name="standard" rows="6"></textarea>
                                    </td>
                                </tr>
                            </form>
                        </tbody>
                    </table>
                    <a href="#!" class="btn btn-primary" onclick="sw_confirm2('確定新增','comment_store')">新增</a>
            </div>
        </div>        
    </div>
</section>
@endsection
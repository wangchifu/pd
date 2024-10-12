@extends('layouts.master_clean')

@section('title','修改填報')

@section('content')
<section class="page-section" style="margin-top: -50px;">
    <div class="container">        
        <div class="card" >
            <div class="card-body">
                <h3 class="card-title">修改「{{ $report->title }}」填報</h5>
                    <table class="table table-hover table-bordered">                        
                        <thead class="bg-secondary text-light">
                            <tr>
                                <th style="width:400px;" colspan="2">
                                    填報名稱
                                </th>
                            </tr>
                        </thead>                    
                        <tbody>
                            <form action="{{ route('report.update',$report->id) }}" method="post" id="report_update">
                                <tr style="background-color: rgba(223, 216, 214, 0.493);">
                                    @csrf
                                    <td colspan="2">                                    
                                        <input type="text" class="form-control" name="title" required value="{{ $report->title }}">                                         
                                        <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">                                                                                    
                                    </td>                                                                    
                                </tr>
                                <tr class="bg-secondary text-light">
                                    <th>
                                        開始填報日期
                                    </th>
                                    <th>
                                        結束填報日期
                                    </th>
                                </tr>
                                <tr>
                                    <td>
                                        <input type="date" class="form-control" name="start_date" required value="{{ $report->start_date }}"> 
                                    </td>
                                    <td>
                                        <input type="date" class="form-control" name="stop_date" required value="{{ $report->stop_date }}"> 
                                    </td>
                                </tr>
                            </form>
                        </tbody>
                    </table>
                    @include('layouts.errors')
                    <a href="#!" class="btn btn-primary" onclick="sw_confirm2('確定儲存俢改？','report_update')">儲存</a>
                    <div class="text-end">
                        <a href="#!" onclick="sw_confirm1('確定連同底下項目一同刪除？','{{ route('report.destroy',$report->id) }}')">
                            <i class="fas fa-times-circle text-danger"></i>
                        </a>
                    </div>                    
            </div>
        </div>        
    </div>
</section>
@endsection
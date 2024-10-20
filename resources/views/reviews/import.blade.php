@extends('layouts.master_clean')

@section('title','匯入學校評語')

@section('content')
<section class="page-section" style="margin-top: -50px;">
    <div class="container">        
        <div class="card" >
            <div class="card-body">
                <h3 class="card-title">匯入「{{ $report->title }}」學校評語</h5>
                    <table class="table table-hover table-bordered">                        
                        <thead class="bg-secondary text-light">
                            <tr>
                                <th style="width:400px;" colspan="2">
                                    填報名稱
                                </th>
                            </tr>
                        </thead>                    
                        <tbody>
                            <form action="{{ route('review.do_import',$report->id) }}" method="post" id="review_import" enctype="multipart/form-data">
                                @csrf
                                <tr style="background-color: rgba(223, 216, 214, 0.493);">                                    
                                    <td colspan="2">                                    
                                        <input type="file" accept=".xlsx" class="form-control" name="file" required>    
                                        <input type="hidden" name="report_id" value="{{ $report->id }}">
                                        <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">                                                                                    
                                    </td>                                                                    
                                </tr>
                            </form>
                        </tbody>
                    </table>
                    @include('layouts.errors')
                    <a href="{{ asset('sample.xlsx') }}" target="_blank" class="btn btn-info">下載範本</a>
                    <a href="#!" class="btn btn-primary" onclick="sw_confirm2('確定送出？會花點時間，完成後，會自己關閉，不可自行關閉視窗。已有評語的，將被覆蓋喔！','review_import')">儲存</a>                 
            </div>
        </div>        
    </div>
</section>
@endsection
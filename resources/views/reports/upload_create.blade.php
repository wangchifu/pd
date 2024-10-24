@extends('layouts.master_clean')

@section('title','新增填報項目')

@section('content')
<section class="page-section" style="margin-top: -50px;">
    <div class="container">        
        <div class="card" >
            <div class="card-body">
                <h3 class="card-title">新增「{{ $report->title }}」填報項目</h5>
                    <table class="table table-hover table-bordered">                        
                        <thead class="bg-secondary text-light">
                            <tr>
                                <th style="width: 100px;">
                                    排序
                                </th>
                                <th>
                                    項目名稱*
                                </th>
                                <th style="width:150px;">
                                    類型*
                                </th>                                
                            </tr>
                        </thead>                    
                        <tbody>
                            <form action="{{ route('report.upload_store') }}" method="post" id="upload_store">
                                <tr style="background-color: rgba(223, 216, 214, 0.493);">
                                    @csrf
                                    <td>
                                        <input type="number" class="form-control" name="order_by">
                                    </td>
                                    <td>                                    
                                        <input type="text" class="form-control" name="title" required> 
                                        <input type="hidden" name="report_id" value="{{ $report->id }}">
                                        <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">                                                                                    
                                    </td>
                                    <td>
                                        <select class="form-control" name="type" required>
                                            <option value="pdf">上傳 PDF 文件</option>
                                            <option value="mp4">上傳 MP4 影片</option>
                                            <!--
                                            <option value="link">上傳影片連結</option>
                                            -->
                                        </select>
                                    </td>                                                                        
                                </tr>
                            </form>
                        </tbody>
                    </table>
                    @include('layouts.errors')
                    <a href="#!" class="btn btn-primary" onclick="sw_confirm2('確定新增','upload_store')">新增</a>
            </div>
        </div>        
    </div>
</section>
@endsection
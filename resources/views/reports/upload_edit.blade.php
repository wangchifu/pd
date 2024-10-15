@extends('layouts.master_clean')

@section('title','修改填報項目')

@section('content')
<section class="page-section" style="margin-top: -50px;">
    <div class="container">        
        <div class="card" >
            <div class="card-body">
                <h3 class="card-title">修改「{{ $report->title }}」上傳項目</h5>
                    <table class="table table-hover table-bordered">                        
                        <thead class="bg-secondary text-light">
                            <tr>
                                <th style="width:100px;">
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
                            <form action="{{ route('report.upload_update',$upload->id) }}" method="post" id="upload_update">
                                <tr style="background-color: rgba(223, 216, 214, 0.493);">
                                    @csrf
                                    <td>
                                        <input type="number" class="form-control" name="order_by" value="{{ $upload->order_by }}">
                                    </td>
                                    <td>                                    
                                        <input type="text" class="form-control" name="title" required value="{{ $upload->title }}"> 
                                        <input type="hidden" name="report_id" value="{{ $report->id }}">
                                        <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">                                                                                    
                                    </td>
                                    <td>
                                        <?php
                                            $selected1 = ($upload->type=="pdf")?"selected":null;
                                            $selected2 = ($upload->type=="mp4")?"selected":null;
                                            $selected3 = ($upload->type=="link")?"selected":null;
                                        ?>
                                        <select class="form-control" name="type" required>
                                            <option value="pdf" {{ $selected1 }}>上傳 PDF 文件</option>
                                            <option value="mp4" {{ $selected2 }}>上傳 MP4 影片</option>
                                            <!--
                                            <option value="link" {{ $selected3 }}>上傳影片連結</option>
                                            -->
                                        </select>
                                    </td>                                                                        
                                </tr>
                            </form>
                        </tbody>
                    </table>
                    @include('layouts.errors')
                    <a href="#!" class="btn btn-primary" onclick="sw_confirm2('確定儲存俢改？','upload_update')">儲存</a>
                    <div class="text-end">
                        <a href="#!" onclick="sw_confirm1('確定刪除？','{{ route('report.upload_destroy',$upload->id) }}')">
                            <i class="fas fa-times-circle text-danger"></i>
                        </a>
                    </div>
            </div>
        </div>        
    </div>
</section>
@endsection
@extends('layouts.master_clean')

@section('title','新增填報項目')

@section('content')
<section class="page-section" style="margin-top: -50px;">
    <div class="container">        
        <div class="card" >
            <div class="card-body">
                <h3 class="card-title">新增「{{ $year->year_name }}」填報項目</h5>
                    <table class="table table-hover table-bordered">                        
                        <thead class="bg-secondary text-light">
                            <tr>
                                <th style="width:400px;">
                                    項目名稱
                                </th>
                                <th style="width:150px;">
                                    類型
                                </th>
                                <th>
                                    排序
                                </th>
                            </tr>
                        </thead>                    
                        <tbody>
                            <form action="{{ route('year.item_store') }}" method="post" id="item_store">
                                <tr style="background-color: rgba(223, 216, 214, 0.493);">
                                    @csrf
                                    <td>                                    
                                        <input type="text" class="form-control" name="title" required> 
                                        <input type="hidden" name="year_id" value="{{ $year->id }}">
                                        <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">                                                                                    
                                    </td>
                                    <td>
                                        <select class="form-control" name="type" required>
                                            <option value="pdf">上傳 PDF</option>
                                            <option value="link">上傳影片連結</option>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" name="order_by" style="width:50px;">
                                    </td>                                    
                                </tr>
                            </form>
                        </tbody>
                    </table>
                    <a href="#!" class="btn btn-primary" onclick="sw_confirm2('確定新增','item_store')">新增</a>
            </div>
        </div>        
    </div>
</section>
@endsection
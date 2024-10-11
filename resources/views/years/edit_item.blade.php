@extends('layouts.master_clean')

@section('title','修改填報項目')

@section('content')
<section class="page-section" style="margin-top: -50px;">
    <div class="container">        
        <div class="card" >
            <div class="card-body">
                <h3 class="card-title">修改「{{ $year->year_name }}」填報項目</h5>
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
                            <form action="{{ route('year.update_item',$item->id) }}" method="post" id="update_item">
                                <tr style="background-color: rgba(223, 216, 214, 0.493);">
                                    @csrf
                                    <td>                                    
                                        <input type="text" class="form-control" name="title" required value="{{ $item->title }}"> 
                                        <input type="hidden" name="year_id" value="{{ $year->id }}">
                                        <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">                                                                                    
                                    </td>
                                    <td>
                                        <?php
                                            $selected1 = ($item->type=="pdf")?"selected":null;
                                            $selected2 = ($item->type=="link")?"selected":null;
                                        ?>
                                        <select class="form-control" name="type" required>
                                            <option value="pdf" {{ $selected1 }}>上傳 PDF</option>
                                            <option value="link" {{ $selected2 }}>上傳影片連結</option>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" name="order_by" style="width:50px;" value="{{ $item->order_by }}">
                                    </td>                                    
                                </tr>
                            </form>
                        </tbody>
                    </table>
                    @include('layouts.errors')
                    <a href="#!" class="btn btn-primary" onclick="sw_confirm2('確定儲存俢改？','update_item')">儲存</a>
                    <a href="#!" onclick="sw_confirm1('確定刪除？','{{ route('year.item_destroy',$item->id) }}')">
                        <i class="fas fa-times-circle text-danger"></i>
                    </a>
            </div>
        </div>        
    </div>
</section>
@endsection
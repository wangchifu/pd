@extends('layouts.master')

@section('title','填報管理')

@section('content')
<section class="page-section" id="contact">
    <div class="container">        
        <div class="card" >
            <div class="card-body">
                <h3 class="card-title">填報管理</h5>
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered">                        
                            <thead class="bg-secondary text-light">
                                <tr>
                                    <th>
                                        id
                                    </th>
                                    <th style="width:500px;">
                                        成果填報名稱
                                    </th>
                                    <th>
                                        項目
                                    </th>
                                    <th>
                                        動作
                                    </th>
                                </tr>
                            </thead>                    
                            <tbody>
                                <tr style="background-color: rgba(223, 216, 214, 0.493);">
                                    <td></td>
                                    <td>
                                        <form action="{{ route('year.store') }}" method="post" id="create_year">
                                            <input type="text" class="form-control" name="year_name" value="年度學校辦理「防災教育」及「國家防災日活動」成果填報" required>                                        
                                            @csrf
                                        </form>                                    
                                    </td>
                                    <td>
                                    </td>
                                    <td>
                                        <a href="#!" class="btn btn-primary" onclick="sw_confirm2('確定新增','create_year')">新增填報</a>
                                    </td>
                                </tr>
                                @foreach($years as $year)                        
                                    <tr>
                                        <td>
                                            {{ $year->id }}
                                        </td>
                                        <td>
                                            <a href="javascript:open_window('{{ route('year.edit_year',$year->id) }}','修改填報')" class="text-decoration-none">
                                                {{ $year->year_name }}
                                            </a>
                                            <br><small class="text-secondary">({{ $year->user->name }} 建立)</small>
                                        </td>
                                        <td>
                                            <a href="javascript:open_window('{{ route('year.create_item',$year->id) }}','新增項目')" class="btn btn-primary btn-sm">新增</a>
                                            <ul>
                                                @foreach($year->items as $item)
                                                    <li>
                                                        <a href="javascript:open_window('{{ route('year.edit_item',$item->id) }}','修改項目')" class="text-decoration-none">
                                                            {{ $item->order_by }}.{{ $item->title }}
                                                        </a>
                                                        @if($item->type=="pdf")
                                                            <span class="text-info">(傳 PDF)</span>
                                                        @elseif($item->type=="link")
                                                            <span class="text-info">(傳影片連結)</span>
                                                        @endif                                                        
                                                        <br><small class="text-secondary">({{ $item->user->name }} 建立)</small>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </td>
                                        <td>
                                            <form action="{{ route('year.copy_year',$year->id) }}" method="post" id="copy_year{{ $year->id }}">
                                                從 id <input type="text" name="id" style="width:50px;">複製項目到此列                                                                                        
                                                @csrf
                                            </form>
                                            <a href="#!" class="btn btn-success btn-sm" onclick="sw_confirm2('確定複製？','copy_year{{ $year->id }}')">複製</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-left">						
                            {{ $years->withQueryString()->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
            </div>
        </div>        
    </div>
</section>
<script>
    function open_window(url,name)
        {
            window.open(url,name,'statusbar=no,scrollbars=yes,status=yes,resizable=yes,width=850,height=400');
        }
</script>
@endsection
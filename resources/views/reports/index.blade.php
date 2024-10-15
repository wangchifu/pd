@extends('layouts.master')

@section('title','填報管理')

@section('content')
<section class="page-section" id="contact">
    <div class="container">        
        <div class="card" >
            <div class="card-body">
                <h3 class="card-title">填報管理</h5>
                    <div class="table-responsive">
                        <h4>新增填報</h5>
                        <form action="{{ route('report.store') }}" method="post" id="report_store">
                            @csrf
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead class="bg-secondary text-light">
                                        <tr>
                                            <th nowrap>
                                                新增成果填報名稱 
                                            </th>
                                            <th style="width:200px;" nowrap>
                                                開始填報日期
                                            </th>
                                            <th style="width:200px;" nowrap>
                                                結束填報日期
                                            </th>
                                            <th style="width:95px;" nowrap>
                                                動作
                                            </th>
                                        </tr>
                                    </thead>
                                    <tr>
                                        <td>                                    
                                            <input type="text" class="form-control" name="title" value="年度學校辦理「防災教育」及「國家防災日活動」成果填報" required>
                                        </td>
                                        <td>
                                            <input type="date" class="form-control" name="start_date" required>
                                        </td>
                                        <td>
                                            <input type="date" class="form-control" name="stop_date" required>
                                        </td>
                                        <td>                                        
                                            <a href="#!" class="btn btn-primary btn-sm" onclick="sw_confirm2('確定新增？','report_store')">新增填報</a>
                                        </td>
                                    </tr>
                                </table>
                                @include('layouts.errors')
                            </div>
                        </form>
                        <h4>填報列表</h5>
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered">
                                <thead class="bg-secondary text-light">
                                    <tr>
                                        <th>
                                            id
                                        </th>
                                        <th style="width:200px;" nowrap>
                                            成果填報名稱
                                        </th>
                                        <th style="width:400px;" nowrap>
                                            1.上傳項目
                                        </th>
                                        <th style="width:400px;" nowrap>
                                            2.評分項目
                                        </th>
                                        <th nowrap>
                                            動作
                                        </th>
                                    </tr>
                                </thead>                    
                                <tbody>
                                    @foreach($reports as $report)                        
                                        <tr>
                                            <td>
                                                {{ $report->id }}
                                            </td>
                                            <td>
                                                <a href="javascript:open_window('{{ route('report.edit',$report->id) }}','修改填報')" class="text-decoration-none">
                                                    {{ $report->title }}
                                                </a>
                                                <small>
                                                <br>起：{{ $report->start_date }}
                                                <br>迄：{{ $report->stop_date }}
                                                </small>
                                                <br><small class="text-secondary">({{ $report->user->name }} 建立)</small>
                                            </td>                                        
                                            <td>
                                                <a href="javascript:open_window('{{ route('report.upload_create',$report->id) }}','新增項目')" class="btn btn-primary btn-sm">新增</a>
                                                <ul>
                                                    @foreach($report->uploads as $upload)
                                                        <li>
                                                            <a href="javascript:open_window('{{ route('report.upload_edit',$upload->id) }}','修改項目')" class="text-decoration-none">
                                                                {{ $upload->order_by }}.{{ $upload->title }}
                                                            </a>
                                                            @if($upload->type=="pdf")
                                                                <span class="text-info">(傳 PDF 文件)</span>
                                                            @elseif($upload->type=="mp4")
                                                                <span class="text-info">(傳 MP4 影片)</span>
                                                            @elseif($upload->type=="link")
                                                                <span class="text-info">(傳影片連結)</span>
                                                            @endif                                                        
                                                            <br><small class="text-secondary">({{ $upload->user->name }} 建立)</small>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </td>
                                            <td>
                                                <a href="javascript:open_window('{{ route('report.comment_create',$report->id) }}','新增項目')" class="btn btn-primary btn-sm">新增</a>
                                                <ul>
                                                    @foreach($report->comments as $comment)
                                                        <li>
                                                            <a href="javascript:open_window('{{ route('report.comment_edit',$comment->id) }}','修改項目')" class="text-decoration-none">
                                                                {{ $comment->order_by }}.{{ $comment->title }}
                                                            </a>
                                                            ({{ $comment->score }} 分)                                                       
                                                            <br><small class="text-secondary">({{ $comment->user->name }} 建立)</small>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </td>
                                            <td>
                                                <table>
                                                    <tr>
                                                        <td>
                                                            <form action="{{ route('report.upload_copy',$report->id) }}" method="post" id="upload_copy{{ $report->id }}">
                                                                1.從填報 id <input type="text" name="id" style="width:50px;">複製「上傳項目」到此列                                                                                        
                                                                @csrf
                                                            </form>
                                                            <a href="#!" class="btn btn-success btn-sm" onclick="sw_confirm2('確定複製？','upload_copy{{ $report->id }}')">複製1</a>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <form action="{{ route('report.comment_copy',$report->id) }}" method="post" id="comment_copy{{ $report->id }}">
                                                                2.從填報 id <input type="text" name="id" style="width:50px;">複製「評分項目」到此列                                                                                        
                                                                @csrf
                                                            </form>
                                                            <a href="#!" class="btn btn-success btn-sm" onclick="sw_confirm2('確定複製？','comment_copy{{ $report->id }}')">複製2</a>
                                                        </td>
                                                    </tr>
                                                </table>                                            
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="d-flex justify-content-left">						
                                {{ $reports->withQueryString()->links('pagination::bootstrap-5') }}
                            </div>
                        </div>
                    </div>
            </div>
        </div>        
    </div>
</section>
<script>
    function open_window(url,name)
        {
            window.open(url,name,'statusbar=no,scrollbars=yes,status=yes,resizable=yes,width=850,height=600');
        }
</script>
@endsection
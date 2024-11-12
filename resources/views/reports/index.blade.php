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
                                            <a href="#!" class="btn btn-primary btn-sm text-nowrap" onclick="sw_confirm2('確定新增？','report_store')">新增填報</a>
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
                                            先 1.上傳項目
                                        </th>
                                        <th style="width:250px;" nowrap>
                                            後 2.評分項目
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
                                                {{ $report->title }}                                     
                                                <a href="{{ route('report.edit',$report->id) }}" data-vbtype="iframe" class="text-decoration-none venobox-link">                                                    
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <small>
                                                <br>起：{{ $report->start_date }}
                                                <br>迄：{{ $report->stop_date }}
                                                </small>
                                                <br><small class="text-secondary">({{ $report->user->name }} 建立)</small>
                                            </td>                                        
                                            <td>
                                                <a href="{{ route('report.upload_create',$report->id) }}" data-vbtype="iframe" class="btn btn-primary btn-sm venobox-link">新增</a>
                                                <ul>
                                                    @foreach($report->uploads as $upload)
                                                        <li>
                                                            {{ $upload->order_by }}.{{ $upload->title }}
                                                            <a href="{{ route('report.upload_edit',$upload->id) }}" data-vbtype="iframe" class="text-decoration-none venobox-link">
                                                                <i class="fas fa-edit"></i>
                                                            </a>
                                                            <br>
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
                                                <a href="{{ route('report.comment_create',$report->id) }}" data-vbtype="iframe" class="btn btn-primary btn-sm venobox-link">新增</a>
                                                <ul>
                                                    @foreach($report->comments as $comment)
                                                        <li>
                                                            {{ $comment->order_by }}.{{ $comment->title }}
                                                            <a href="{{ route('report.comment_edit',$comment->id) }}" data-vbtype="iframe" class="text-decoration-none venobox-link">
                                                                <i class="fas fa-edit"></i>                                                                
                                                            </a>
                                                            <br>
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
                                                                1.先從填報 id <input type="text" name="id" style="width:50px;" required>複製「上傳項目」到此列                                                                                        
                                                                @csrf
                                                            </form>
                                                            <a href="#!" class="btn btn-success btn-sm text-nowrap" onclick="sw_confirm2('確定複製？','upload_copy{{ $report->id }}')">複製1</a>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <form action="{{ route('report.comment_copy',$report->id) }}" method="post" id="comment_copy{{ $report->id }}">
                                                                2.再從填報 id <input type="text" name="id" style="width:50px;" required>複製「評分項目」到此列                                                                                        
                                                                @csrf
                                                            </form>
                                                            <a href="#!" class="btn btn-success btn-sm text-nowrap" onclick="sw_confirm2('確定複製？','comment_copy{{ $report->id }}')">複製2</a>
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
    $(document).ready(function(){
        var vb = new VenoBox({
            selector: '.venobox-link',
            numeration: true,
            infinigall: true,
            //share: ['facebook', 'twitter', 'linkedin', 'pinterest', 'download'],
            spinner: 'rotating-plane'
        });

    $(document).on('click', '.vbox-close', function() {
            vb.close();
        });

    // 監聽 iframe 發送的消息
    window.addEventListener('message', function(event) {
        // 檢查消息內容，並且只處理關閉的請求
        if (event.data === 'closeVenobox') {
            vb.VBclose(); // 關閉 Venobox 視窗
        }
    }, false);
    });

    function open_window(url,name)
        {
            window.open(url,name,'statusbar=no,scrollbars=yes,status=yes,resizable=yes,width=850,height=800');
        }
</script>
@endsection
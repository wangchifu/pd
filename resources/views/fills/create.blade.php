@extends('layouts.master')

@section('title','學校填報')

@section('content')
<section class="page-section" id="contact">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ route('index') }}" class="text-decoration-none">首頁</a></li>
              <li class="breadcrumb-item"><a href="{{ route('fill.index') }}" class="text-decoration-none">學校填報</a></li>
              <li class="breadcrumb-item active" aria-current="page">填報...</li>
            </ol>
          </nav>
          <div class="card" >
            <div class="card-body">
                <h3 class="card-title">填報「{{ $report->title }}」</h3>
                @include('layouts.errors')
                註：
                <br>1.PDF 文件檔不得超過 20 MB。[<a href="https://www.ilovepdf.com/zh-tw/compress_pdf" class="text-decoration-none" target="_blank">線上壓縮</a>]
                <br>2.MP4 影片檔不得超過 300 MB。[<a href="https://www.adobe.com/tw/express/feature/video/convert/mp4" class="text-decoration-none" target="_blank">線上轉檔</a>]                
                <br>3.重覆上傳將覆蓋舊的檔案。
                <br><br>
                <h4>「{{ $school->name }}」</h4>
                <table class="table table-hover table-bordered">
                    <thead class="bg-secondary text-light">
                        <tr>
                            <th style="width:50px;">
                                項次
                            </th>
                            <th>
                                上傳項目 
                            </th>                            
                            <th style="width:300px;">
                                動作
                            </th>
                        </tr>
                    </thead>
                    <?php $n=1; ?>
                    @foreach($report->uploads as $upload)
                        <tr>
                            <td>
                                {{ $n }}
                            </td>
                            <td>
                                {{ $upload->title }}
                            </td>
                            <td>
                                <form action="{{ route('fill.store',$upload->id) }}" method="post" enctype="multipart/form-data" id="upload_file{{ $upload->id }}">
                                    @csrf
                                    <div class="mb-3">      
                                        <label for="up{{ $upload->id }}" class="form-label text-success">                                                    
                                            @if($upload->type=="pdf")
                                                上傳 PDF 文件
                                            @elseif($upload->type=="mp4") 
                                                上傳 MP4 影片
                                            @elseif($upload->type=="link") 
                                                貼上影片連結
                                            @endif
                                        </label>
                                        <table>
                                            <tr>
                                                <td>
                                                    @if($upload->type=="pdf")
                                                        <input class="form-control" type="file" accept=".pdf" id="up{{ $upload->id }}" name="file" required>                                                
                                                    @elseif($upload->type=="mp4")
                                                        <input class="form-control" type="file" accept=".mp4" id="up{{ $upload->id }}" name="file" required>                                                
                                                    @elseif($upload->type=="link")            
                                                        <input class="form-control" type="text" id="up{{ $upload->id }}" name="url" placeholder="貼上連結" required>                                                
                                                    @endif                                                            
                                                </td>
                                                <td style="width:50px;">
                                                    <a class="btn btn-primary btn-sm text-nowrap" onclick="sw_confirm2('確定送出？','upload_file{{ $upload->id }}')">送出</a>
                                                </td>
                                            </tr>
                                        </table>                                                                                  
                                    </div>                                            
                                </form>   
                                <?php 
                                    $check_fill = \App\Models\Fill::where('upload_id',$upload->id)->where('school_code','like','%'.auth()->user()->school_code.'%')->first();
                                ?>
                                @if(!empty($check_fill))
                                    已上傳 <small>(by{{ $check_fill->user->name }})
                                    @if($check_fill->disable == 1)
                                        <span class="text-danger">已退回，請重新上傳</span>
                                    @endif
                                    <br>(請按綠按鈕測試是否正常)</small><br>
                                    @if($upload->type=="pdf")
                                        <a href="{{ route('fill.open_file',['report'=>$report->id,'file_name'=>$check_fill->filename]) }}" data-vbtype="iframe" class="btn btn-success btn-sm venobox-link"><i class="fas fa-file-alt"></i> {{ $check_fill->filename }}</a>
                                        @if(!file_exists(storage_path('app/privacy/fills/'.$upload->report_id.'/'.$check_fill->school_name.'/'.$check_fill->filename)))
                                            <br><span class="text-danger">(檔案遺失)</span>
                                        @endif
                                    @elseif($upload->type=="mp4")
                                        <a href="{{ route('fill.open_file',['report'=>$report->id,'file_name'=>$check_fill->filename]) }}" data-vbtype="iframe" class="btn btn-success btn-sm venobox-link"><i class="fas fa-film"></i> {{ $check_fill->filename }}</a>
                                        @if(!file_exists(storage_path('app/privacy/fills/'.$upload->report_id.'/'.$check_fill->school_name.'/'.$check_fill->filename)))
                                            <br><span class="text-danger">(檔案遺失)</span>
                                        @endif
                                    @elseif($upload->type=="link")       
                                        <a href="{{ transfer_url_http($check_fill->filename) }}" data-vbtype="iframe" class="btn btn-success btn-sm venobox-link"><i class="fas fa-film"></i> 影片連結</a>
                                    @endif 
                                @else
                                    <span class="text-danger">未上傳</span>
                                @endif                                                                           
                            </td>
                        </tr>
                        <?php $n++; ?>
                    @endforeach
                </table>
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
</script>
@endsection
@extends('layouts.master')

@section('title','審查學校')

@section('content')
<section class="page-section" id="contact">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ route('index') }}" class="text-decoration-none">首頁</a></li>
              <li class="breadcrumb-item"><a href="{{ route('fill.index') }}" class="text-decoration-none">學校填報</a></li>              
              <li class="breadcrumb-item active" aria-current="page">評審結果</li>
            </ol>
          </nav>
        <div class="card" >
            <div class="card-body">
                <h3 class="card-title">學校名稱：{{ $opinion->school_name }}</h3>                
                <h4>{{ $report->title }}</h4>
                <div class="table-responsive">
                    <table class="table table-hover table-bordered">
                        <thead class="bg-secondary text-light">
                            <tr>
                                <th style="width:50px;" nowrap>
                                    項次
                                </th>
                                <th nowrap>
                                    上傳項目 
                                </th>                            
                                <th style="width:300px;" nowrap>
                                    成果
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
                                    @if(isset($fill_data[$upload->id]))                                 
                                        @if($upload->type=="pdf")                                    
                                            <a href="{{ asset('storage/fills/'.$upload->report_id.'/'.$school->name.'/'.$fill_data[$upload->id]) }}" data-vbtype="iframe" class="btn btn-success btn-sm venobox-link"><i class="fas fa-file-alt"></i> {{ $fill_data[$upload->id] }}</a>
                                            @if(!file_exists(storage_path('app/public/fills/'.$upload->report_id.'/'.$school->name.'/'.$fill_data[$upload->id])))
                                                <br><span class="text-danger">(檔案遺失)</span>
                                            @endif
                                        @elseif($upload->type=="mp4")
                                            <a href="{{ asset('storage/fills/'.$upload->report_id.'/'.$school->name.'/'.$fill_data[$upload->id]) }}" data-vbtype="iframe" class="btn btn-success btn-sm venobox-link"><i class="fas fa-film"></i> {{ $fill_data[$upload->id] }}</a>
                                            @if(!file_exists(storage_path('app/public/fills/'.$upload->report_id.'/'.$school->name.'/'.$fill_data[$upload->id])))
                                                <br><span class="text-danger">(檔案遺失)</span>
                                            @endif
                                        @elseif($upload->type=="link")            
                                            <a href="{{ transfer_url_http($fill_data[$upload->id]) }}" data-vbtype="iframe" class="btn btn-success btn-sm venobox-link"><i class="fas fa-film"></i> 影片連結</a>
                                        @endif                           
                                    @else
                                        <span class="text-danger">尚未上傳</span>
                                    @endif                                                
                                </td>
                            </tr>
                            <?php $n++; ?>
                        @endforeach
                    </table>
                    <hr>
                    @if(!empty($opinion->id))
                        @if(!empty($opinion))
                            <h2>審查等級：{{ $opinion->grade }}學校</h2>
                        @endif
                    @endif                    
                    <table class="table table-bordered">
                        <thead class="bg-warning text-dark">
                            <th colspan="4">
                                評審綜合意見
                            </th>
                        </thead>
                        <tbody>                                                        
                            <tr>
                                <td colspan="4">
                                    {!! nl2br($opinion->suggestion) !!}
                                </td>
                            </tr>
                        </tbody>
                    </table>        
                    <a href="#!" class="btn btn-secondary" onclick="history.go(-1);">返回</a>                                    
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
</script>
@endsection
@extends('layouts.master')

@section('title','學校成果')

@section('content')
<section class="page-section" id="contact">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ route('index') }}" class="text-decoration-none">首頁</a></li>
              <li class="breadcrumb-item"><a href="{{ route('result.index') }}" class="text-decoration-none">成果列表</a></li>
              <li class="breadcrumb-item"><a href="{{ route('result.view',$report->id) }}" class="text-decoration-none">各校列表</a></li>
              <li class="breadcrumb-item active" aria-current="page">「{{ $school_name }}」成果</li>
            </ol>
          </nav>
          @include('layouts.errors')
          <div class="card" >
            <div class="card-body">
                <h2>{{ $report->title }}</h2>
                <h3 class="card-title">
                    @if(!empty($opinion->recommend))        
                        👍<span class="text-danger">推薦</span>
                    @endif
                    @if($opinion->grade=="特優")
                        <span class="badge bg-warning"><i class="fas fa-crown"></i> 特優</span>
                    @endif
                    @if($opinion->grade=="優等")
                        <span class="badge bg-success"><i class="fas fa-star"></i> 優等</span>
                    @endif
                    @if($opinion->grade=="甲等")
                        <span class="badge bg-info"><i class="fas fa-thumbs-up"></i> 甲等</span>
                    @endif
                    「{{ $school_name }}」成果
                </h3>
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
                                        <!--                                    
                                            <a href="{{ asset('storage/fills/'.$upload->report_id.'/'.$school_name.'/'.$fill_data[$upload->id]) }}" data-vbtype="iframe" class="btn btn-success btn-sm venobox-link"><i class="fas fa-file-alt"></i> {{ $fill_data[$upload->id] }}</a>
                                        -->
                                            @auth
                                                @if(auth()->user()->admin==1 or strpos($code,auth()->user()->school_code) !== false)
                                                    <a href="{{ route('result.open_file',['report'=>$upload->report_id,'school_name'=>$school_name,'file_name'=>$fill_data[$upload->id]]) }}" data-vbtype="iframe" class="btn btn-success btn-sm venobox-link"><i class="fas fa-file-alt"></i> {{ $fill_data[$upload->id] }}</a>                                                
                                                @else
                                                    {{ $fill_data[$upload->id] }}
                                                @endif
                                            @endauth
                                            @guest
                                                {{ $fill_data[$upload->id] }}
                                            @endguest                                            
                                            @if(!file_exists(storage_path('app/privacy/fills/'.$upload->report_id.'/'.$school_name.'/'.$fill_data[$upload->id])))
                                                <br><span class="text-danger">(檔案遺失)</span>
                                            @endif
                                        @elseif($upload->type=="mp4")
                                        <!--
                                            <a href="{{ asset('storage/fills/'.$upload->report_id.'/'.$school_name.'/'.$fill_data[$upload->id]) }}" data-vbtype="iframe" class="btn btn-success btn-sm venobox-link"><i class="fas fa-film"></i> {{ $fill_data[$upload->id] }}</a>
                                        -->
                                            @auth
                                                @if(auth()->user()->admin==1 or strpos($code,auth()->user()->school_code) !== false)
                                                    <a href="{{ route('result.open_file',['report'=>$upload->report_id,'school_name'=>$school_name,'file_name'=>$fill_data[$upload->id]]) }}" data-vbtype="iframe" class="btn btn-success btn-sm venobox-link"><i class="fas fa-file-alt"></i> {{ $fill_data[$upload->id] }}</a>                                                
                                                @else
                                                    {{ $fill_data[$upload->id] }}
                                                @endif
                                            @endauth
                                            @guest
                                                {{ $fill_data[$upload->id] }}
                                            @endguest  
                                            @if(!file_exists(storage_path('app/privacy/fills/'.$upload->report_id.'/'.$school_name.'/'.$fill_data[$upload->id])))
                                                <br><span class="text-danger">(檔案遺失)</span>
                                            @endif
                                        @elseif($upload->type=="link")            
                                            <a href="{{ transfer_url_http($fill_data[$upload->id]) }}" data-vbtype="iframe" class="btn btn-success btn-sm venobox-link"><i class="fas fa-film"></i> 影片連結</a>
                                        @endif                           
                                    @else
                                        <span class="text-danger">尚未上傳正確檔案</span>
                                    @endif                                                
                                </td>
                            </tr>
                            <?php $n++; ?>
                        @endforeach
                    </table>
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
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
                    <table class="table table-bordered">
                        <thead class="bg-secondary text-light">
                            <tr>
                                <th style="width:50px;" nowrap>
                                    項次
                                </th>
                                <th nowrap>
                                    名稱 
                                </th>
                                <th nowrap>
                                    評分標準
                                </th>       
                                <th style="width:100px;" nowrap>
                                    得分
                                </th>                         
                            </tr>
                        </thead>
                        <tbody>
                            <?php $n=1; ?>
                            @foreach($report->comments as $comment)
                                <tr>
                                    <td>
                                        {{ $n }}
                                    </td>
                                    <td>
                                        <h5>{{ $comment->title }}({{ $comment->score }}分)</h5>
                                        @if(!empty($comment->refer))
                                            <?php 
                                                $refers = unserialize($comment->refer);
                                            ?>
                                            <span class="text-success">參考依據：</span>
                                            <ol>                                            
                                                @foreach($refers as $k=>$v)
                                                    <?php
                                                        $fill = \App\Models\Fill::where('school_code',$school->code)
                                                            ->where('report_id',$report->id)
                                                            ->where('upload_id',$v)
                                                            ->first();                                                            
                                                    ?>
                                                    @if(!empty($fill->id))
                                                        <li class="text-danger"><a href="{{ asset('storage/fills/'.$report->id."/".$school->name."/".$fill->filename) }}" data-vbtype="iframe" class="text-decoration-none venobox-link">{{ $upload_data[$v] }}</a></li>
                                                    @else
                                                        <li class="text-danger">{{ $upload_data[$v] }}</li>
                                                    @endif
                                                @endforeach
                                            </ol>
                                        @endif                                            
                                    </td>
                                    <td>
                                        {!! nl2br($comment->standard) !!}
                                    </td>
                                    <td>
                                        <?php
                                            $score = (isset($score_data[$comment->id]))?$score_data[$comment->id]:null;
                                        ?>
                                        {{ $score }}
                                    </td>
                                </tr>
                                <?php $n++; ?>
                            @endforeach
                            <thead class="bg-secondary text-light">
                                <th colspan="4">
                                    綜合意見
                                </th>
                            </thead>
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
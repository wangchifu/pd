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
                <br>1.PDF 檔不得超過 5 MB。
                <br>2.影片連結的做法：你可以放上YouTube，或是放在谷歌雲端硬碟，<span class="text-danger">記得設定權限為公開</span>。
                <br>3.重覆上傳將覆蓋舊的檔案或連結。
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
                                                上傳PDF檔
                                            @elseif($upload->type=="link") 
                                                貼上影片連結
                                            @endif
                                        </label>
                                        <table>
                                            <tr>
                                                <td>
                                                    @if($upload->type=="pdf")
                                                        <input class="form-control" type="file" accept=".pdf" id="up{{ $upload->id }}" name="file" required>                                                
                                                    @elseif($upload->type=="link")            
                                                        <input class="form-control" type="text" id="up{{ $upload->id }}" name="url" placeholder="貼上連結" required>                                                
                                                    @endif                                                            
                                                </td>
                                                <td style="width:50px;">
                                                    <a class="btn btn-primary btn-sm" onclick="sw_confirm2('確定送出？','upload_file{{ $upload->id }}')">送出</a>
                                                </td>
                                            </tr>
                                        </table>                                                                                  
                                    </div>                                            
                                </form>   
                                <?php 
                                    $check_fill = \App\Models\Fill::where('upload_id',$upload->id)->where('school_code','like','%'.auth()->user()->school_code.'%')->first();
                                ?>
                                @if(!empty($check_fill))
                                    已上傳 <small>(by{{ $check_fill->user->name }})</small><br>
                                    @if($upload->type=="pdf")
                                    <a href="{{ asset('storage/fills/'.$upload->report_id.'/'.$check_fill->school_code.'/'.$check_fill->filename) }}" target="_blank" class="btn btn-success btn-sm"><i class="fas fa-file-alt"></i></i> {{ $check_fill->filename }}</a>
                                    @elseif($upload->type=="link")            
                                        <a href="{{ transfer_url_http($check_fill->filename) }}" target="_blank" class="btn btn-success btn-sm"><i class="fas fa-film"></i> 影片連結</a>
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
@endsection
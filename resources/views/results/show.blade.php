@extends('layouts.master')

@section('title','學校填報')

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
          <div class="card" >
            <div class="card-body">
                <h2>{{ $report->title }}</h2>
                <h3 class="card-title">「{{ $school_name }}」成果</h3>
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
                                        <a href="{{ asset('storage/fills/'.$upload->report_id.'/'.$school_name.'/'.$fill_data[$upload->id]) }}" target="_blank" class="btn btn-success btn-sm"><i class="fas fa-file-alt"></i></i> {{ $fill_data[$upload->id] }}</a>
                                        @if(!file_exists(storage_path('app/public/fills/'.$upload->report_id.'/'.$fill_data[$upload->id])))
                                            <span class="text-danger">(檔案遺失)</span>
                                        @endif
                                    @elseif($upload->type=="link")            
                                        <a href="{{ transfer_url_http($fill_data[$upload->id]) }}" target="_blank" class="btn btn-success btn-sm"><i class="fas fa-film"></i> 影片連結</a>
                                    @endif                           
                                @else
                                    <span class="text-danger">尚未上傳</span>
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
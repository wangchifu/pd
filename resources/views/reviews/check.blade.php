@extends('layouts.master')

@section('title','檢查各校上傳')

@section('content')
<section class="page-section" id="contact">
    <div class="container">
        <div class="card" >
            <div class="card-body">
                <h3 class="card-title">檢查各校上傳</h3>
                @include('layouts.errors')
                <div class="table-responsive">
                    <select class="form-control" onchange="if(this.value) { window.location.href=this.value }">
                        <option value="{{ route('review.check') }}">請選擇成果項目</option>
                        @foreach($reports as $report)
                            <option value="{{ route('review.check',$report->id) }}" @if(isset($report_id) and $report_id == $report->id) selected @endif>
                                {{ $report->title }}
                            </option>
                        @endforeach 
                    </select>
                    <table class="table table-bordered mt-3">
                        <thead class="bg-secondary text-light">
                            <tr>
                                <th nowrap>
                                    學校名稱 
                                </th>
                                @foreach($uploads as $upload)
                                    <th>
                                        {{ $upload->title }}
                                    </th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>                                                     
                            @foreach($schools as $school)
                                <tr>                                    
                                    <td>                                        
                                        {{ $school->name }}                                        
                                    </td>                                    
                                    @foreach($uploads as $upload)
                                        <?php
                                            $check_fill = \App\Models\Fill::where('report_id',$report_id)
                                                ->where('upload_id',$upload->id)
                                                ->where('school_code',$school->code)                                                
                                                ->first();
                                        ?>
                                        <td>
                                            @if(!empty($check_fill->id))
                                                <a class="btn btn-success btn-sm text-nowrap" href="{{ route('review.open_file',['report'=>$report_id,'school_name'=>$school->name,'file_name'=>$check_fill->filename]) }}" target="_blank" class="text-decoration-none">打開</a>
                                                @if($check_fill->disable == 1)
                                                    <span class="text-danger">已退回</span>
                                                @else
                                                    <a href="#!" class="btn btn-danger btn-sm text-nowrap" onclick="sw_confirm1('確定退回{{ $school->name }} {{ $upload->title }}？','{{ route('review.back',$check_fill->id) }}')">退回</a>
                                                @endif                                                
                                                @if(file_exists(storage_path('app/privacy/fills/'.$report_id.'/'. $school->name .'/'. $check_fill->filename)))
                                                    <br><small>({{ filesizemb(storage_path('app/privacy/fills/'.$report_id.'/'. $school->name .'/'. $check_fill->filename)) }})</small>
                                                @else
                                                    <br><small class="text-danger">(檔案遺失)</small>
                                                @endif
                                            @endif
                                        </td>
                                    @endforeach
                                </tr>                                
                            @endforeach                           
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
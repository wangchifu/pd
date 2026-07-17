@extends('layouts.master')

@section('title','檢查各校上傳')

@section('content')
<style>
    .extra-small {
    padding: 0.1rem 0.25rem;  /* 上下、左右內距 */
    font-size: 0.75rem;       /* 字體再小一點 */
    line-height: 1;           /* 行高壓縮 */
}
</style>
<section class="page-section" id="contact">
    <div class="container">
        <div class="card" >
            <div class="card-body">
                <h3 class="card-title">視察後第二次評語</h3>
                @include('layouts.errors')
                <div class="table-responsive">
                    <select class="form-control" onchange="if(this.value) { window.location.href=this.value }">
                        <option value="{{ route('review.suggestion2') }}">請選擇成果項目</option>
                        @foreach($reports as $report)
                            <option value="{{ route('review.suggestion2',$report->id) }}" @if(isset($report_id) and $report_id == $report->id) selected @endif>
                                {{ $report->title }}
                            </option>
                        @endforeach 
                    </select>
                    <br>               
                    <form method="POST" action="{{ route('review.suggestion2_store') }}" id="this_form">
                        <button type="button" class="btn btn-primary" onclick="sw_confirm2('確定儲存？','this_form')">儲存</button>
                        @csrf
                        <input type="hidden" name="report_id" value="{{ $report_id }}">     
                    <table class="table table-bordered mt-3">
                        <thead class="bg-secondary text-light">
                            <tr>
                                <th width="100px;" nowrap>
                                    學校名稱 
                                </th>
                                <th width="50px;">
                                    等級                                    
                                </th>
                                <th width="500px">
                                    綜合意見
                                </th>
                                <th>
                                    視察後第二次評語
                                </th>
                            </tr>
                        </thead>
                        <tbody>                                                     
                            @foreach($school_option as $k=>$v)
                                <tr>                                    
                                    <td>
                                        @if(isset($schools_array[$k]))
                                            {{ $schools_array[$k] }}
                                        @else
                                            ---
                                        @endif                                        
                                    </td>                                    
                                    <td>
                                        @if(isset($school_option[$k]['grade']))                                            
                                            @if($school_option[$k]['grade']=="特優")
                                                <span class="badge bg-warning"><i class="fas fa-crown"></i> 特優</span>                                                
                                            @endif
                                            @if($school_option[$k]['grade']=="優等")
                                                <span class="badge bg-success"><i class="fas fa-star"></i> 優等</span>                                                
                                            @endif
                                            @if($school_option[$k]['grade']=="甲等")
                                                <span class="badge bg-info"><i class="fas fa-thumbs-up"></i> 甲等</span>                                                
                                            @endif
                                            @if($school_option[$k]['grade']=="輔導")
                                                <span class="badge bg-dark"><i class="fas fa-sad-cry"></i> 輔導</span>
                                            @endif
                                        @else
                                            ---
                                        @endif                                                                         
                                    </td>
                                    <td>
                                        @if(isset($school_option[$k]['suggestion']))                                            
                                            {!! nl2br($school_option[$k]['suggestion']) !!}
                                        @else
                                            ---
                                        @endif
                                    </td>
                                    <td>
                                        <textarea 
                                            name="suggestion2[{{ $k }}]"                                            
                                            class="form-control" 
                                            id="reviewTextArea" 
                                            rows="4" 
                                            placeholder="請在此輸入第二輪審查意見或修正建議...">{{ $school_option[$k]['suggestion2'] }}</textarea>                                        
                                    </td>
                                </tr>                                
                            @endforeach                           
                        </tbody>
                    </table>
                    <button type="button" class="btn btn-primary" onclick="sw_confirm2('確定儲存？','this_form')">儲存</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
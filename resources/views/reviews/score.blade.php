@extends('layouts.master')

@section('title','分數與結果')

@section('content')
<section class="page-section" id="contact">
    <div class="container">
        <div class="card" >
            <div class="card-body">
                <h3 class="card-title">分數與結果</h3>
                @include('layouts.errors')
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="bg-secondary text-light">
                            <tr>
                                <th nowrap>
                                    成果項目 
                                </th>
                                <th style="width:250px" nowrap>
                                    組別 / 評審
                                </th>
                                <th style="width:400px" nowrap>
                                    動作
                                </th>
                            </tr>
                        </thead>
                        <tbody>                                                     
                            @foreach($reports as $report)
                                <tr>
                                    <?php 
                                        $check_opinion = \App\Models\Opinion::where('report_id',$report->id)                                            
                                            ->first();
                                    ?>
                                    <td>                                        
                                        {{ $report->title }}
                                        @if(!empty($check_opinion->id))
                                            @if($check_opinion->open == 1)
                                                <span class="badge bg-warning text-dark"><i class="far fa-folder-open"></i>已公開</span>
                                            @endif
                                        @endif
                                    </td>
                                    <td>
                                        <table>
                                            <tr>
                                                <td>
                                                    <form action="{{ route('review.award') }}" method="post" id="review_award{{ $report->id }}">
                                                        @csrf
                                                        <input type="hidden" name="report_id" value="{{ $report->id }}">                                        
                                                        <select name="name" class="form-control" required>
                                                            <option value="第一組">
                                                                第一組
                                                                @if(isset($reviewers_array[$report->id]['第一組']))
                                                                    - {{ $reviewers_array[$report->id]['第一組'] }}
                                                                @else
                                                                    - 未指定
                                                                @endif
                                                            </option>
                                                            <option value="第二組">
                                                                第二組
                                                                @if(isset($reviewers_array[$report->id]['第二組']))
                                                                    - {{ $reviewers_array[$report->id]['第二組'] }}
                                                                @else
                                                                    - 未指定
                                                                @endif
                                                            </option>
                                                            <option value="第三組">
                                                                第三組
                                                                @if(isset($reviewers_array[$report->id]['第三組']))
                                                                    - {{ $reviewers_array[$report->id]['第三組'] }}
                                                                @else
                                                                    - 未指定
                                                                @endif
                                                            </option>
                                                            <option value="第四組">
                                                                第四組
                                                                @if(isset($reviewers_array[$report->id]['第四組']))
                                                                    - {{ $reviewers_array[$report->id]['第四組'] }}
                                                                @else
                                                                    - 未指定
                                                                @endif
                                                            </option>
                                                            <option value="第五組">
                                                                第五組
                                                                @if(isset($reviewers_array[$report->id]['第五組']))
                                                                    - {{ $reviewers_array[$report->id]['第五組'] }}
                                                                @else
                                                                    - 未指定
                                                                @endif
                                                            </option>
                                                        </select>      
                                                    </form>  
                                                </td>
                                                <td>
                                                    <a href="#!" class="btn btn-info btn-sm" onclick="go_submit('review_award{{ $report->id }}')">查閱</a>
                                                </td>
                                            </tr>
                                        </table>                                                                                   
                                    </td>
                                    <td>
                                        <a href="{{ route('review.import',$report->id) }}" data-vbtype="iframe" class="btn btn-primary btn-sm venobox-link">匯入綜合意見</a>    
                                        @if(!empty($check_opinion->id))
                                            @if($check_opinion->open == 1)
                                                <a href="#!" class="btn btn-outline-warning btn-sm" onclick="sw_confirm1('確定全部取消公開評審結果？','{{ route('review.close',$report->id) }}')">取消公開</a>
                                            @else
                                                <a href="#!" class="btn btn-warning btn-sm" onclick="sw_confirm1('確定全部公開評審結果？','{{ route('review.open',$report->id) }}')">公開結果</a>
                                            @endif
                                        @endif        
                                        <a href="#!" class="btn btn-danger btn-sm" onclick="sw_confirm1('會清掉全部的評分與意見喔！','{{ route('review.destroy',$report->id) }}')">清掉評分與意見</a>                                                                        
                                        <a href="#!" class="btn btn-secondary btn-sm" onclick="sw_confirm1('會花很久的時候喔，請不要中途關掉視窗！','{{ route('review.download',$report->id) }}')">下載全部檔案</a>                                        
                                    </td>
                                </tr>                                                            
                            @endforeach                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
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
        
    function go_submit(id){
        $('#'+id).submit();
    }

    function open_window(url,name)
        {
            window.open(url,name,'statusbar=no,scrollbars=yes,status=yes,resizable=yes,width=850,height=400');
        }
</script>
@endsection
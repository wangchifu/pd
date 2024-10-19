@extends('layouts.master')

@section('title','審查學校')

@section('content')
<section class="page-section" id="contact">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ route('index') }}" class="text-decoration-none">首頁</a></li>
              <li class="breadcrumb-item"><a href="{{ route('reviewer.index') }}" class="text-decoration-none">審查學校列表</a></li>              
              <li class="breadcrumb-item active" aria-current="page">「{{ $schools_name[$school_code] }}」</li>
            </ol>
          </nav>
        <div class="card" >
            <div class="card-body">
                <h3 class="card-title">學校名稱：{{ $schools_name[$school_code] }}</h3>                
                <h4>{{ $report->title }}</h4>
                <div class="table-responsive">
                    <form action="{{ route('reviewer.school_store') }}" method="post" id="school_review">
                        @csrf                        
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
                                                            $fill = \App\Models\Fill::where('school_code',$school_code)
                                                                ->where('report_id',$report->id)
                                                                ->where('upload_id',$v)
                                                                ->first();                                                                           
                                                        ?>
                                                        @if(!empty($fill->id))
                                                            <li class="text-danger"><a href="{{ asset('storage/fills/'.$report->id."/".$schools_name[$school_code]."/".$fill->filename) }}" target="_blank" class="text-decoration-none">{{ $upload_data[$v] }}</a></li>
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
                                            <input type="number" name="score_array[{{ $comment->id }}]" class="form-control" id="score{{ $comment->id }}" value="{{ $score }}" required>
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
                                        <textarea class="form-control" rows="5" name="suggestion" required>{{ $suggestion }}</textarea>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <input type="hidden" name="school_name" value="{{ $schools_name[$school_code] }}">
                        <input type="hidden" name="school_code" value="{{ $school_code }}">
                        <input type="hidden" name="report_id" value="{{ $report->id }}">
                        <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                        <a href="#!" class="btn btn-primary" onclick="sw_confirm2('確定送出？','school_review')">送出</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<script>    
    $(document).ready(function() {
        @foreach($report->comments as $comment)
            $('#score{{ $comment->id }}').on('input', function() {
                var value = $(this).val();
                if (value > {{ $comment->score }}) {
                    sw_alert('此欄最高分為：{{ $comment->score }}')
                    $(this).val(''); // 如果輸入值大於 30，將值設為 空值
                }
            });
        @endforeach
    });
</script>
@endsection
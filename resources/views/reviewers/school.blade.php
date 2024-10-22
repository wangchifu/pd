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
                    @include('layouts.errors')
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
                                                            <li class="text-danger"><a href="{{ asset('storage/fills/'.$report->id."/".$schools_name[$school_code]."/".$fill->filename) }}" data-vbtype="iframe" class="text-decoration-none venobox-link">{{ $upload_data[$v] }}</a></li>
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
                                        綜合意見(須滿50字)
                                    </th>
                                </thead>
                                <tr>
                                    <td colspan="4">
                                        <textarea class="form-control" rows="5" name="suggestion" id="suggestion" required>{{ $suggestion }}</textarea>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <input type="hidden" name="school_name" value="{{ $schools_name[$school_code] }}">
                        <input type="hidden" name="school_code" value="{{ $school_code }}">
                        <input type="hidden" name="report_id" value="{{ $report->id }}">
                        <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                        <a href="#!" class="btn btn-primary" onclick="check_submit()">送出</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<script>    
    function check_submit(){
        var isValid = true;
        $('input[name^="score_array"]').each(function() {
            // 检查每个输入框是否为空
            if ($(this).val() === "") {
                sw_alert('有項目分數未打！');
                isValid = false;
            }
        });
        
        if(!isValid){
            return false;
        }


        var textareaValue = $('#suggestion').val();

        // 匹配中文字符的正则表达式        
        var matchedCharacters = textareaValue.match(/[\u4e00-\u9fffA-Za-z0-9]/g) || [];

        // 检查中文字符的数量是否少于 50
        if (matchedCharacters.length < 50) {
            // 阻止表单提交
            event.preventDefault();
            sw_alert('綜合意見未滿 50 字！')
        } else {
            // 清除错误信息
            sw_confirm2('確定送出？','school_review')
        }
        

    }

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
</script>
@endsection
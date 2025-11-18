@extends('layouts.master_print')

@section('title','列印各組優良學校')

@section('content')
<style>
    /* CSS */
.onepx-table {
  margin: 0 auto; /* 水平置中 */  
  border-collapse: collapse; /* 合併邊框成單線 */
  width: 90%;
  /* 如果你也想讓外框有1px，可以加下面這行 */
  /* border: 1px solid #ccc; */
}

.onepx-table th,
.onepx-table td {
  border: 2px solid #000000; /* 1px 邊框 */
  padding: 8px;
  text-align: left;
  /* 可選：設定字體大小、行高等 */
  font-size: 20px;
  line-height: 1.4;
}
</style>
<?php $n=1; ?>
@foreach($groups as $group)
    @if($n>1)
        <div style="page-break-before: always;"></div>
    @endif
    <h3 class="text-center">彰化縣{{ $year }}年度校園災害防救計畫 {{ $group }} 學校成績一覽</h3>
    <table class="table table-bordered table-hover">
        <tbody>     
            <tr>
                <th nowrap>
                    等級
                </th>
                <th nowrap>
                    學校名稱 
                </th>
                @foreach($report->comments as $comment)
                    <th style="width:50px;">
                        {{ $comment->title }} 
                    </th>
                @endforeach
                <th style="width:50px;">
                    總分
                </th>
                <th>
                    綜合意見
                </th>
            </tr>                                                
            @foreach($total_score[$group] as $k=>$v)
                <tr>
                    <td>                                        
                        @if(isset($grade[$group][$k]))
                            @if(!empty($recommend[$group][$k]))
                                👍推薦<br>
                            @endif
                            @if($grade[$group][$k]=="特優")
                                <span class="badge bg-warning"><i class="fas fa-crown"></i> 特優</span>                                                
                            @endif
                            @if($grade[$group][$k]=="優等")
                                <span class="badge bg-success"><i class="fas fa-star"></i> 優等</span>                                                
                            @endif
                            @if($grade[$group][$k]=="甲等")
                                <span class="badge bg-info"><i class="fas fa-thumbs-up"></i> 甲等</span>                                                
                            @endif
                            @if($grade[$group][$k]=="輔導")
                                <span class="badge bg-dark"><i class="fas fa-sad-cry"></i> 輔導</span>                                                
                            @endif
                        @endif
                    </td>
                    <td>
                        {{ $schools_name[$k] }}
                    </td>
                    @foreach($report->comments as $comment)
                        <td>
                            @if(isset($score_data[$group][$k][$comment->id]))
                                {{ $score_data[$group][$k][$comment->id] }}
                            @endif                                        
                        </td>
                    @endforeach
                    <td>
                        {{ $v }}
                    </td>
                    <td>
                        @if(isset($suggestion[$group][$k]))
                            {!! nl2br($suggestion[$group][$k]) !!}
                        @endif 
                    </td>
                </tr>
            @endforeach                            
        </tbody>
    </table>    
    <?php $n++; ?>
@endforeach
@endsection
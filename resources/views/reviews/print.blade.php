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
<h3 class="text-center">彰化縣{{ $year }}年度校園災害防救計畫考評結果一覽表(<span style="color:blueviolet">優良學校</span>)</h3>
<table class="onepx-table">
    <tbody>
        <tr>
            <td>

            </td>
            <td>
                第一組
            </td>
            <td>
                第二組
            </td>
            <td>
                第三組
            </td>
            <td>
                第四組
            </td>
            <td>
                第五組
            </td>
            <td>
                備註
            </td>
        </tr>
        <tr class="text-warning">
            <td>
                特優
            </td>
            <td>
                @if(isset($opinion1['第一組']))
                    <?php $n=1; ?>
                    @foreach($opinion1['第一組'] as $k=>$v)
                        @if($n>1) <br> @endif
                            {{ $v }}
                        <?php $n++; ?>                    
                    @endforeach
                @endif                
            </td>  
            <td>
                @if(isset($opinion1['第二組']))
                    <?php $n=1; ?>
                    @foreach($opinion1['第二組'] as $k=>$v)
                        @if($n>1) <br> @endif
                            {{ $v }}
                        <?php $n++; ?>                     
                    @endforeach
                @endif                
            </td>
            <td>
                @if(isset($opinion1['第三組']))
                    <?php $n=1; ?>
                    @foreach($opinion1['第三組'] as $k=>$v)
                        @if($n>1) <br> @endif
                            {{ $v }}
                        <?php $n++; ?> 
                    @endforeach
                @endif                
            </td>
            <td>
                @if(isset($opinion1['第四組']))
                    <?php $n=1; ?>
                    @foreach($opinion1['第四組'] as $k=>$v)
                        @if($n>1) <br> @endif
                            {{ $v }}
                        <?php $n++; ?>                         
                    @endforeach
                @endif                
            </td>
            <td>
                @if(isset($opinion1['第五組']))
                    <?php $n=1; ?>
                    @foreach($opinion1['第五組'] as $k=>$v)
                        @if($n>1) <br> @endif
                            {{ $v }}
                        <?php $n++; ?> 
                    @endforeach
                @endif                
            </td>    
            <td>
            </td>                         
        </tr>
        <tr class="text-success">
            <td>
                優等
            </td>
            <td>
                @if(isset($opinion2['第一組']))
                    <?php $n=1; ?>
                    @foreach($opinion2['第一組'] as $k=>$v)
                        @if($n>1) <br> @endif
                            {{ $v }}
                        <?php $n++; ?>                    
                    @endforeach
                @endif                
            </td>  
            <td>
                @if(isset($opinion2['第二組']))
                    <?php $n=1; ?>
                    @foreach($opinion2['第二組'] as $k=>$v)
                        @if($n>1) <br> @endif
                            {{ $v }}
                        <?php $n++; ?>                     
                    @endforeach
                @endif                
            </td>
            <td>
                @if(isset($opinion2['第三組']))
                    <?php $n=1; ?>
                    @foreach($opinion2['第三組'] as $k=>$v)
                        @if($n>1) <br> @endif
                            {{ $v }}
                        <?php $n++; ?> 
                    @endforeach
                @endif                
            </td>
            <td>
                @if(isset($opinion2['第四組']))
                    <?php $n=1; ?>
                    @foreach($opinion2['第四組'] as $k=>$v)
                        @if($n>1) <br> @endif
                            {{ $v }}
                        <?php $n++; ?>                         
                    @endforeach
                @endif                
            </td>
            <td>
                @if(isset($opinion2['第五組']))
                    <?php $n=1; ?>
                    @foreach($opinion2['第五組'] as $k=>$v)
                        @if($n>1) <br> @endif
                            {{ $v }}
                        <?php $n++; ?> 
                    @endforeach
                @endif                
            </td>       
            <td>
            </td>            
        <tr style="color:blueviolet">
            <td>
                甲等
            </td>
            <td>
                @if(isset($opinion3['第一組']))
                    <?php $n=1; ?>
                    @foreach($opinion3['第一組'] as $k=>$v)
                        @if($n>1) <br> @endif
                            {{ $v }}
                        <?php $n++; ?>                    
                    @endforeach
                @endif                
            </td>  
            <td>
                @if(isset($opinion3['第二組']))
                    <?php $n=1; ?>
                    @foreach($opinion3['第二組'] as $k=>$v)
                        @if($n>1) <br> @endif
                            {{ $v }}
                        <?php $n++; ?>                     
                    @endforeach
                @endif                
            </td>
            <td>
                @if(isset($opinion3['第三組']))
                    <?php $n=1; ?>
                    @foreach($opinion3['第三組'] as $k=>$v)
                        @if($n>1) <br> @endif
                            {{ $v }}
                        <?php $n++; ?> 
                    @endforeach
                @endif                
            </td>
            <td>
                @if(isset($opinion3['第四組']))
                    <?php $n=1; ?>
                    @foreach($opinion3['第四組'] as $k=>$v)
                        @if($n>1) <br> @endif
                            {{ $v }}
                        <?php $n++; ?>                         
                    @endforeach
                @endif                
            </td>
            <td>
                @if(isset($opinion3['第五組']))
                    <?php $n=1; ?>
                    @foreach($opinion3['第五組'] as $k=>$v)
                        @if($n>1) <br> @endif
                            {{ $v }}
                        <?php $n++; ?> 
                    @endforeach
                @endif                
            </td>     
            <td>
            </td>            
        </tr>                                  
    </tbody>
</table>
<br>
<br>
<hr>
<br>
<br>
<h3 class="text-center">彰化縣{{ $year }}年度校園災害防救計畫考評結果一覽表(<span style="color:red">輔導學校</span>)</h3>
<table class="onepx-table">
    <tbody>
        <tr>
            <td>

            </td>
            <td>
                第一組
            </td>
            <td>
                第二組
            </td>
            <td>
                第三組
            </td>
            <td>
                第四組
            </td>
            <td>
                第五組
            </td>
            <td>
                備註
            </td>
        </tr>
        <tr class="text-danger">
            <td>
                輔導
            </td>
            <td>
                @if(isset($opinion4['第一組']))
                    <?php $n=1; ?>
                    @foreach($opinion4['第一組'] as $k=>$v)
                        @if($n>1) <br> @endif
                            {{ $v }}
                        <?php $n++; ?>                    
                    @endforeach
                @endif                
            </td>  
            <td>
                @if(isset($opinion4['第二組']))
                    <?php $n=1; ?>
                    @foreach($opinion4['第二組'] as $k=>$v)
                        @if($n>1) <br> @endif
                            {{ $v }}
                        <?php $n++; ?>                     
                    @endforeach
                @endif                
            </td>
            <td>
                @if(isset($opinion4['第三組']))
                    <?php $n=1; ?>
                    @foreach($opinion4['第三組'] as $k=>$v)
                        @if($n>1) <br> @endif
                            {{ $v }}
                        <?php $n++; ?> 
                    @endforeach
                @endif                
            </td>
            <td>
                @if(isset($opinion4['第四組']))
                    <?php $n=1; ?>
                    @foreach($opinion4['第四組'] as $k=>$v)
                        @if($n>1) <br> @endif
                            {{ $v }}
                        <?php $n++; ?>                         
                    @endforeach
                @endif                
            </td>
            <td>
                @if(isset($opinion4['第五組']))
                    <?php $n=1; ?>
                    @foreach($opinion4['第五組'] as $k=>$v)
                        @if($n>1) <br> @endif
                            {{ $v }}
                        <?php $n++; ?> 
                    @endforeach
                @endif                
            </td>    
            <td>
            </td>                         
        </tr>
    </tbody>
</table>
<br>
<hr>
<br>
<span style="font-size:20px;color:blueviolet">國家防災日推薦學校：</span><br>
<?php $n=1; ?>
<span style="font-size:18px;">
    @foreach($opinion_recommend as $k=>$v)
        @if($n>1) 、 @endif
        {{ $v }}
        <?php $n++; ?> 
    @endforeach
</span>
@endsection
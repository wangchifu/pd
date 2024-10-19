@extends('layouts.master')

@section('title','評審與學校')

@section('content')
<section class="page-section" id="contact">
    <div class="container">
        <div class="card" >
            <div class="card-body">
                <h3 class="card-title">分組的評審與學校</h3>
                @include('layouts.errors')
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="bg-secondary text-light">
                            <tr>
                                <th style="width:200px" nowrap>
                                    成果項目 
                                </th>
                                <th style="width:100px" nowrap>
                                    更換分組
                                </th>
                                <th style="width:200px" nowrap>
                                    動作1
                                </th>
                                <th style="width:100px" nowrap>
                                    動作2
                                </th>
                                <th nowrap>
                                    結果
                                </th>                                
                            </tr>
                        </thead>
                        <tbody>                                                     
                            @foreach($reports as $report)
                                <form action="{{ route('review.school_assign',$report->id) }}" method="get" id="school_assign{{ $report->id }}">
                                    @csrf   
                                    <tr>
                                        <td>
                                            {{ $report->title }}
                                        </td>                                        
                                        <td>
                                            <select name="name" class="form-control" required id="select_group{{ $report->id }}" onchange="change_group('select_group{{ $report->id }}',{{ $report->id }})">
                                                <option value="第一組">第一組</option>
                                                <option value="第二組">第二組</option>
                                                <option value="第三組">第三組</option>
                                                <option value="第四組">第四組</option>
                                                <option value="第五組">第五組</option>
                                            </select>                                            
                                        </td>
                                        <td>
                                            <table>
                                                <tr>
                                                    <td>
                                                        指定
                                                    </td>
                                                    <td>
                                                        <select name="user_id" required>
                                                            @foreach($reviewers as $reviewer)
                                                                <option value="{{ $reviewer->id }}">{{ $reviewer->name }}</option>                                             
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input type="submit" class="btn btn-secondary btn-sm" name="action" value="為評審">
                                                    </td>
                                                </tr>
                                            </table>                                                                                        
                                        </td>
                                        <td>
                                            <input type="submit" class="btn btn-primary btn-sm" name="action" value="指定學校">
                                        </td>
                                        <td>
                                            <div id="show_school{{ $report->id }}"></div>
                                        </td>                                        
                                    </tr>
                                    <input type="hidden" name="report_id" value="{{ $report->id }}">
                                </form>
                            @endforeach                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    @foreach($reports as $report)
        $(document).ready(function() {            
            // 當頁面載入時，執行 AJAX 請求
            var firstOptionValue = $('#select_group{{ $report->id }} option:first').val(); // 取得第一個 option 的值
            fetchData(firstOptionValue,{{ $report->id }}); // 根據這個值取資料
        });                  
    @endforeach

    function change_group(id,report_id){
        var selectedValue = $('#'+id).val(); // 取得選中的值
        fetchData(selectedValue,report_id); // 根據選中的值取資料
    }
    
                // AJAX 取資料的函數
            function fetchData(name,report_id) {
                $.ajax({
                    url: '/review/check_group/'+report_id+'/'+name, // 伺服器端 API 的 URL
                    type: 'GET',
                    dataType : 'json',
                    success: function(result) {
                        // 成功後將返回的數據顯示在 show_school div 中
                        $('#show_school'+report_id).html(result);
                    },
                    error: function(xhr, status, error) {
                        // 處理錯誤
                        $('#show_school'+report_id).html('資料加載失敗，請稍後再試。');
                    }
                });
            }
</script>
@endsection
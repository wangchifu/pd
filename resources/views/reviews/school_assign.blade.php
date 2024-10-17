@extends('layouts.master')

@section('title','評審管理')

@section('content')
<section class="page-section" id="contact">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ route('index') }}" class="text-decoration-none">首頁</a></li>
              <li class="breadcrumb-item"><a href="{{ route('review.index') }}" class="text-decoration-none">評審管理</a></li>
              <li class="breadcrumb-item active" aria-current="page">評審指定學校</li>
            </ol>
          </nav>
        <div class="card" >
            <div class="card-body">
                <h3 class="card-title">評審指定學校</h3>
                @include('layouts.errors')
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="bg-secondary text-light">
                            <tr>
                                <th style="width:200px" nowrap>
                                    成果項目 
                                </th>
                                <th style="width:100px" nowrap>
                                    評審
                                </th>
                                <th nowrap>
                                    學校
                                </th>
                                <th style="width:100px" nowrap>
                                    動作
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <form action="{{ route('review.do_school_assign') }}" method="post" id="do_assign">
                                @csrf
                                <tr>
                                    <td>
                                        {{ $report->title }}
                                    </td>
                                    <td>
                                        {{ $reviewer->name }}
                                    </td>
                                    <td>
                                        @foreach($township_ids as $k=>$v)
                                            <h4 style="clear:both;"><i class="fab fa-fort-awesome"></i> {{ $k }}</h4>
                                            <div>
                                                <a href="#!" class="btn btn-secondary btn-sm" onclick="selectAll{{ $v }}()">勾選全部{{ $k }}</a>
                                                <a href="#!" class="btn btn-outline-secondary btn-sm" onclick="nonselectAll{{ $v }}()">取消勾選全部{{ $k }}</a>
                                            </div>
                                            @foreach($school_array[$v] as $k1=>$v1)                                        
                                            <div style="float: left;">
                                                <?php
                                                    $checked = in_array($k1,$select_schools)?"checked":null;
                                                    $disabled = (isset($other_select_school_data[$k1]))?"disabled":null;
                                                ?>
                                                <input class="form-check-input area{{ $v }}" type="checkbox" name="select_school[]" value="{{ $k1 }}" id="cb{{ $k1 }}" {{ $checked }} {{ $disabled }}>
                                                <label for="cb{{ $k1 }}">
                                                    {{ $v1 }}
                                                    @if(isset($other_select_school_data[$k1]))
                                                        <small class="text-secondary">({{ $other_select_school_data[$k1] }})</small>
                                                    @endif
                                                    　　
                                                </label>
                                            </div>                                                
                                            @endforeach                                            
                                            <hr style="clear:both;">
                                        @endforeach
                                    </td>
                                    <td>
                                        <a href="#!" class="btn btn-primary btn-sm" onclick="sw_confirm2('確定？','do_assign')">儲存</a>
                                    </td>
                                </tr>
                                <input type="hidden" name="report_id" value="{{ $report->id }}">
                                <input type="hidden" name="user_id" value="{{ $reviewer->id }}">
                            </form>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    @foreach($township_ids as $k=>$v)
        function selectAll{{ $v }}() {
            var checkboxes = document.querySelectorAll('.area{{ $v }}'); // 選取所有 class 為 'my-checkbox' 的 checkbox
            checkboxes.forEach(function(checkbox) {
                checkbox.checked = true; // 將 checkbox 的 checked 屬性設為 true，表示勾選
            });
        }
        function nonselectAll{{ $v }}() {
            var checkboxes = document.querySelectorAll('.area{{ $v }}'); // 選取所有 class 為 'my-checkbox' 的 checkbox
            checkboxes.forEach(function(checkbox) {
                checkbox.checked = false; // 將 checkbox 的 checked 屬性設為 true，表示勾選
            });
        }
    @endforeach
</script>
@endsection
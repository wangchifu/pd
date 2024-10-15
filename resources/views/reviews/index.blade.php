@extends('layouts.master')

@section('title','評審管理')

@section('content')
<section class="page-section" id="contact">
    <div class="container">
        <div class="card" >
            <div class="card-body">
                <h3 class="card-title">評審管理</h3>
                @include('layouts.errors')
                <div class="table-responsive">
                    <table class="table table-hover table-bordered">
                        <thead class="bg-secondary text-light">
                            <tr>
                                <th nowrap>
                                    成果項目 
                                </th>
                                <th style="width:100px" nowrap>
                                    評審
                                </th>
                                <th style="width:500px" nowrap>
                                    學校
                                </th>
                                <th style="width:50px" nowrap>
                                    動作
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($reports as $report)
                                <tr>
                                    <td>
                                        {{ $report->title }}
                                    </td>
                                    <td>
                                        <select name="reviewer_id" class="form-control">
                                            @foreach($reviewer as $reviewer)
                                                <option>{{ $reviewer->name }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        
                                    </td>
                                    <td>
                                        
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
@endsection
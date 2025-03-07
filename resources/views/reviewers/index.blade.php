@extends('layouts.master')

@section('title','審查學校列表')

@section('content')
<section class="page-section" id="contact">
    <div class="container">
        <div class="card" >
            <div class="card-body">
                <h3 class="card-title">審查學校列表</h3>                
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="bg-secondary text-light">
                            <tr>
                                <th style="width:150px" nowrap>
                                    成果項目 
                                </th>
                                <th style="width:200px" nowrap>
                                    注意事項
                                </th>
                                <th style="width:150px" nowrap>
                                    組內排名與得獎
                                </th>
                                <th nowrap>
                                    已審學校
                                </th>  
                                <th nowrap>
                                    未審學校
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
                                        {!! nl2br($report->notice) !!}
                                    </td>
                                    <td>
                                        @if(isset($group_name[$report->id]))   
                                            <a href="{{ route('reviewer.group',['report'=>$report->id,'name'=>$group_name[$report->id]]) }}" class="btn btn-secondary btn-sm my-2 text-nowrap">{{ $group_name[$report->id] }}狀況</a>
                                        @endif
                                    </td>
                                    <td>
                                        @if(isset($assign_schools[$report->id]))                                        
                                            @foreach($assign_schools[$report->id] as $k=>$v)
                                            <?php
                                                $check = \App\Models\Opinion::where('report_id',$report->id)->where('school_code',$v)->first();
                                            ?>
                                            @if(!empty($check->id))
                                                <a href="{{ route('reviewer.school',['report'=>$report->id,'school_code'=>$v]) }}" class="btn btn-primary btn-sm position-relative mx-2 my-2 text-nowrap">
                                                    {{ $schools_name[$v] }}                                                                                                        
                                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                                        ok
                                                    </span>                                                    
                                                </a>
                                                @endif                                                
                                            @endforeach
                                        @endif
                                    </td>
                                    <td>                                        
                                        @if(isset($assign_schools[$report->id]))                                        
                                            @foreach($assign_schools[$report->id] as $k=>$v)
                                            <?php
                                                $check = \App\Models\Opinion::where('report_id',$report->id)->where('school_code',$v)->first();
                                            ?>
                                            @if(empty($check->id))
                                                <a href="{{ route('reviewer.school',['report'=>$report->id,'school_code'=>$v]) }}" class="btn btn-primary btn-sm position-relative mx-2 my-2 text-nowrap">
                                                    {{ $schools_name[$v] }}                                                                                                                                                          
                                                </a>
                                                @endif                                                
                                            @endforeach
                                        @endif
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
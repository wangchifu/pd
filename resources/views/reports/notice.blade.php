@extends('layouts.master_clean')

@section('title','給評審的注意事項')

@section('content')
<section class="page-section" style="margin-top: -50px;">
    <div class="container">        
        <div class="card" >
            <div class="card-body">
                <h3 class="card-title">編輯「{{ $report->title }}」</h5>
                    <table class="table table-hover table-bordered">                        
                        <thead class="bg-secondary text-light">
                            <tr>
                                <th>
                                    給評審的注意事項
                                </th>                            
                            </tr>
                        </thead>                    
                        <tbody>
                            <form action="{{ route('report.notice_update',$report->id) }}" method="post" id="notice_update">
                                <tr style="background-color: rgba(223, 216, 214, 0.493);">
                                    @csrf
                                    <td>
                                        <textarea class="form-control" rows="6" name="notice">{{ $report->notice }}</textarea>
                                    </td>                                    
                                </tr>
                            </form>
                        </tbody>
                    </table>
                    @include('layouts.errors')
                    <a href="#!" class="btn btn-primary" onclick="sw_confirm2('確定儲存？','notice_update')">儲存</a>
            </div>
        </div>        
    </div>
</section>
@endsection
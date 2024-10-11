@extends('layouts.master_clean')

@section('title','修改填報')

@section('content')
<section class="page-section" style="margin-top: -50px;">
    <div class="container">        
        <div class="card" >
            <div class="card-body">
                <h3 class="card-title">修改「{{ $year->year_name }}」填報</h5>
                    <table class="table table-hover table-bordered">                        
                        <thead class="bg-secondary text-light">
                            <tr>
                                <th style="width:400px;">
                                    填報名稱
                                </th>
                            </tr>
                        </thead>                    
                        <tbody>
                            <form action="{{ route('year.update_year',$year->id) }}" method="post" id="update_year">
                                <tr style="background-color: rgba(223, 216, 214, 0.493);">
                                    @csrf
                                    <td>                                    
                                        <input type="text" class="form-control" name="year_name" required value="{{ $year->year_name }}">                                         
                                        <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">                                                                                    
                                    </td>                                                                    
                                </tr>
                            </form>
                        </tbody>
                    </table>
                    @include('layouts.errors')
                    <a href="#!" class="btn btn-primary" onclick="sw_confirm2('確定儲存俢改？','update_year')">儲存</a>
                    <a href="#!" onclick="sw_confirm1('確定連同底下項目一同刪除？','{{ route('year.year_destroy',$year->id) }}')">
                        <i class="fas fa-times-circle text-danger"></i>
                    </a>
            </div>
        </div>        
    </div>
</section>
@endsection
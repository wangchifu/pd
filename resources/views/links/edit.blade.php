@extends('layouts.master_clean')

@section('title','修改連結')

@section('content')
<section class="page-section" style="margin-top: -50px;">
    <div class="container">        
        <div class="card" >
            <div class="card-body">
                <h3 class="card-title">修改連結</h5>
                    <table class="table table-hover table-bordered">                        
                        <thead class="bg-secondary text-light">
                            <tr>
                                <th style="width:200px;">
                                    連結名稱
                                </th>
                                <th>
                                    連結網址
                                </th>
                            </tr>
                        </thead>                    
                        <tbody>
                            <form action="{{ route('link.update',$link->id) }}" method="post" id="update_link">
                                <tr style="background-color: rgba(223, 216, 214, 0.493);">
                                    @csrf
                                    <td>                                    
                                        <input type="text" class="form-control" name="title" required value="{{ $link->title }}">                                         
                                        <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">                                                                                    
                                    </td>    
                                    <td>
                                        <input type="text" class="form-control" name="url" required value="{{ $link->url }}">                                         
                                    </td>                                                                
                                </tr>
                            </form>
                        </tbody>
                    </table>
                    @include('layouts.errors')
                    <a href="#!" class="btn btn-primary" onclick="sw_confirm2('確定儲存俢改？','update_link')">儲存</a>
                    <div class="text-end">
                        <a href="#!" onclick="sw_confirm1('確定刪除','{{ route('link.destroy',$link->id) }}')"><i class="fas fa-times-circle text-danger"></i></a>
                    </div>
            </div>
        </div>        
    </div>
</section>
@endsection
@extends('layouts.master')

@section('title','連結管理')

@section('content')
<section class="page-section" id="contact">
    <div class="container">
        <div class="row justify-content-center">
            <!--
            <div class="col-lg-6 col-xl-6">
                <div class="card" style="width: 100%;">
                    <img src="{{ asset('images/title1.png') }}" class="card-img-top" alt="...">
                    <div class="card-body">
                        <form action="{{ route('link.store') }}" method="post" id="create_link1">
                            @csrf
                            <table>
                                <tr>
                                    <td style="width:80px">
                                        <input type="text" class="form-control" name="order_by" required placeholder="排序">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" name="title" required placeholder="標題">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" name="url" required placeholder="網址">
                                    </td>
                                    <td>
                                        <a href="#!" class="btn btn-primary btn-sm" onclick="sw_confirm2('確定？','create_link1')">儲存</a>
                                    </td>
                                </tr>
                            </table>                            
                            <input type="hidden" name="side" value="left">
                        </form>
                        <hr>
                      <ul>
                        @foreach($link1s as $link1)
                            <li>
                                <a href="{{ transfer_url_http($link1->url) }}" target="_blank" class="text-decoration-none">
                                    ({{ $link1->order_by }}) {{ $link1->title }}
                                </a>
                                (by {{ $link1->user->name }})                                
                                <a href="#!" onclick="javascript:open_window('{{ route('link.edit',$link1->id) }}','修改連結')"><i class="fas fa-edit"></i></a>
                            </li>
                        @endforeach
                      </ul>
                    </div>
                  </div>
            </div>
            -->
            <div class="col-lg-6 col-xl-6">
                <div class="card" style="width: 100%;">
                    <img src="{{ asset('images/title2.png') }}" class="card-img-top" alt="...">
                    <div class="card-body">
                        <form action="{{ route('link.store') }}" method="post" id="create_link2">
                            @csrf
                            <table>
                                <tr>
                                    <td style="width:80px">
                                        <input type="text" class="form-control" name="order_by" required placeholder="排序">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" name="title" required placeholder="標題">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" name="url" required placeholder="網址">
                                    </td>
                                    <td>
                                        <a href="#!" class="btn btn-primary btn-sm" onclick="sw_confirm2('確定？','create_link2')">儲存</a>
                                    </td>
                                </tr>
                            </table>                            
                            <input type="hidden" name="side" value="right">
                        </form>
                        <hr>
                      <ul>
                        @foreach($link2s as $link2)
                            <li>
                                <a href="{{ transfer_url_http($link2->url) }}" target="_blank" class="text-decoration-none">
                                    ({{ $link2->order_by }}) {{ $link2->title }}
                                </a>
                                (by {{ $link2->user->name }})                                
                                <a href="#!" onclick="javascript:open_window('{{ route('link.edit',$link2->id) }}','修改連結')"><i class="fas fa-edit"></i></a>
                            </li>
                        @endforeach
                      </ul>
                    </div>
                  </div>
            </div>
        </div>
    </div>
</section>

<script>
    function open_window(url,name)
        {
            window.open(url,name,'statusbar=no,scrollbars=yes,status=yes,resizable=yes,width=850,height=400');
        }
</script>
@endsection
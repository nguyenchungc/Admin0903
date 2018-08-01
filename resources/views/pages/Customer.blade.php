@extends('layout.admin-layout')
@section('title','Trang chủ')
@section('content')
<div class="panel panel-body">
    <section class="content">
        <div class="panel panel-default">
            <div class="panel-heading">
                <b>
                    Danh sách khách hàng <i></i>
                </b>
            </div>
            <div class="panel-body">
                @if(Session::has('success'))
                <div class="alert alert-success">
                    {{Session::get('success')}}
                </div>
                @endif
                @if(Session::has('error'))
                <div class="alert alert-danger">
                    {{Session::get('error')}}
                </div>
                @endif
                <table class="table table-bordered">
                    <thead>
                      <tr>
                        <th>Tên</th>
                        <th>Giới tính</th>
                        <th>Địa chỉ email</th>
                        <th>Địa chỉ</th>
                        <th>Điện thoại</th>
                      </tr>
                    </thead>
                    <tbody>
                       @foreach ($Users as $U)
                        <tr>
                           
                            <td>
                                {{$U->name}}
                            </td>
                            <td>
                                {{$U->gender}}
                            </td>
                            <td>
                                {{$U->email}}
                            </td>
                            <td>
                                {{$U->address}}
                            </td>
                            <td>
                                {{$U->phone}}
                            </td>
                           
                        </tr>
                        @endforeach
                    </tbody>

                  </table>
                  
            </div>
        </div>
    </section>
</div>


@endsection
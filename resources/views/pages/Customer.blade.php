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
                        <th>Username</th>
                        <th>Tên đầy đủ</th>
                        <th>Ngày tháng năm sinh</th>
                        <th>Giới tính</th>
                        <th>Địa chỉ</th>
                        <th>Địa chỉ email</th>
                        <th>Số điện thoại</th>
                      </tr>
                    </thead>
                    <tbody>
                       @foreach ($Users as $U)
                        <tr>
                           
                            <td>
                                {{$U->usersname}}
                            </td>
                           
                        </tr>
                        @endforeach
                    </tbody>

                  </table>
                  {{$Users->links()}}
            </div>
        </div>
    </section>
</div>

<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
    
        <!-- Modal content-->
        <div class="modal-content">
        <div class="modal-body">
            <p>Bạn có chắc chắn xoá sản phẩm <b id="nameProduct">...</b> ?</p>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary">
                <a href="admin/delete-product" id="addIdProduct">OK</a>
            </button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        </div>
        </div>
    
    </div>
</div>
<script src="admin-master/js/jquery.js"></script>
<script>
    $(document).ready(function(){
        // $('#myModal').modal('show')
        $('.updateProduct').click(function(){
            var idProduct = $(this).attr('data-id') //get 
            var nameProduct = $('#name-'+idProduct).text()
            $('#nameProduct').html(nameProduct)
            $('#addIdProduct').attr('href',"admin/delete-product-"+idProduct) //set
        })
    })
</script>
@endsection
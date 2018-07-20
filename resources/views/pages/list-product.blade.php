@extends('layout.admin-layout')
@section('title','Trang chủ')
@section('content')
<div class="panel panel-body">
    <section class="content">
        <div class="panel panel-default">
            <div class="panel-heading">
                <b>
                   Danh sách sản phẩm thuộc loại ......
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
                          <th>Mã sản phẩm</th>
                        <th>Tên sản phẩm</th>
                        <th>hình</th>
                        <th>Đơn giá - giá khuyến mãi</th>
                        <th>Loại sản phẩm</th>
                        <th>Sản phẩm mới</th>
                        <th>Ẩn ngoài web</th>
                        
                        <th>Tuỳ chọn</th>
                      
                      </tr>
                    </thead>
                    <tbody>
                     @foreach($products as $product)
                      <tr>
                      <td>DH000{{$product->id}}</td>
                        <td>
                            {{$product->name}}
                        </td>
                        <td> <img src="" alt=""</td>
                        <td>
                            {{number_format($product->price)}}
                            <br>
                            {{number_format($product->promotion_price)}}
                        </td>
                        <td>
                            <input type="checkbox" @if($product->status==1) checked @endif>
                        </td>
                        <td><input type="checkbox" @if($product->new==1) checked @endif></td>
                        <td><input type="checkbox" @if($product->deleted==1) checked @endif></td>
                        
                        <td>
                            <button class="btn btn-primary btn-sm updateBill" data-toggle="modal" data-target="#myModal" data-id="{{$product->id}}">Xóa</button>
                            <button class="btn btn-default btn-sm">Sửa</button>
                        </td>
                        
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                {{$products->links()}}
            </div>
        </div>
    </section>
</div>

<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
    
        <!-- Modal content-->
        <div class="modal-content">
        <div class="modal-body">
            <p>Bạn có chắc chắn chuyển <b id="idBill">DH000</b> sang đã giao?</p>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary">
                <a href="admin/update-bill" id="addIdBill">OK</a>
            </button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        </div>
        </div>
    
    </div>
</div>
<script src="admin-master/js/jquery.js"></script>
<script>
    $(document).ready(function(){
        $('.updateBill').click(function(){
            var idBill = $(this).attr('data-id') //get 
            $('#addIdBill').attr('href',"admin/update-bill-"+idBill) //set
        })
    })
</script>
@endsection
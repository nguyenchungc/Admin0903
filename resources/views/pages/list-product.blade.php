@extends('layout.admin-layout')
@section('title','Trang chủ')
@section('content')
<div class="panel panel-body">
    <section class="content">
        <div class="panel panel-default">
            <div class="panel-heading">
                <b>
                    Danh sách sản phẩm thuộc loại <i>{{$nameType}}</i>
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
                        <th>Hình</th>
                        <th>Đơn giá - Giá khuyến mãi</th>
                        <th>Sản phẩm đặc biệt</th>
                        <th>Sản phẩm mới</th>
                        <th>Ẩn ngoài web</th>
                        <th>Tuỳ chọn</th>
                      </tr>
                    </thead>
                    <tbody>
                     @foreach($products as $product)
                      <tr>
                      <td>SP000{{$product->id}}</td>
                        <td id="name-{{$product->id}}">
                            {{$product->name}}
                        </td>
                        <td>
                            <img height="100px" src="admin-master/products/{{$product->image}}" alt="">
                        </td>
                        <td>
                            {{number_format($product->price)}}
                            <br>
                            {{number_format($product->promotion_price)}}
                        </td>
                        <td>
                            <input type="checkbox" disabled @if($product->status==1) checked @endif>
                        </td>
                        <td>
                            <input type="checkbox" disabled @if($product->new==1) checked  @endif>
                        </td>
                        <td>
                            <input type="checkbox" disabled @if($product->deleted==1) checked   @endif>
                        </td>
                        <td>
                            <button class="btn btn-primary btn-sm updateProduct" data-toggle="modal" data-target="#myModal" data-id="{{$product->id}}">Xoá</button>
                            @if(Auth::user()->role=='admin')
                            <a href="{{route('updateProduct',$product->id)}}"><button class="btn btn-default btn-sm">Sửa</button></a>
                            @endif
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
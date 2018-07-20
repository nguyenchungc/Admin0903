@extends('layout.admin-layout')
@section('title','Trang chủ')
@section('content')
<div class="panel panel-body">
    <section class="content">
        <div class="panel panel-default">
            <div class="panel-heading">
                <b>
                   Danh sách sản phẩm thuộc loại {{$nameType}}
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
                        <td id="name-{{$product->id}}">
                            {{$product->name}}
                        </td>
                    <td> <img height=100px src="admin-master/images/{{$product->image}}" alt=""</td>
                        <td>
                            {{number_format($product->price)}}
                            <br>
                            {{number_format($product->promotion_price)}}
                        </td>
                        <td>
                            <input class="form-control" disabled type="checkbox" @if($product->status==1) checked @endif>
                        </td>
                        <td><input type="checkbox" disabled @if($product->new==1) checked @endif></td>
                        <td><input type="checkbox" disabled @if($product->deleted==1) checked @endif></td>
                        
                        <td>
                            <button class="btn btn-primary btn-sm updateProduct" data-toggle="modal" data-target="#myModal" data-id="{{$product->id}}">Xóa</button>
                        <button class="btn btn-default btn-sm"><a href="{{route('updateProduct',$product->id)}}">Sửa</button>
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
            <p>Bạn có chắc chắn xóa sản phẩm <b id="nameProduct"></b> hay không?</p>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary">
                <a href="admin/delete-Product" id="addIdProduct">OK</a>
            </button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        </div>
        </div>
    
    </div>
</div>
<script src="admin-master/js/jquery.js"></script>
<script>
    $(document).ready(function(){
        $('.updateProduct').click(function(){
            var idProduct = $(this).attr('data-id') //get 
            var nameProduct = $('#name-'+idProduct).text() //# la id
           // console.log(nameProduct)
            $('#nameProduct').html(nameProduct)
            $('#addIdProduct').attr('href',"admin/delete-Product-"+idProduct) //set
        })
    })
</script>
@endsection
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Hash;
use Auth;
use App\Bills;
use App\Products;
use App\Categories;
use App\PageUrl;
use App\Helpers\Helpers;

class AdminController extends Controller
{
    function getLogin(){
        return view('pages.login');
    }
    function getRegister(){
        return view('pages.register');
    }
    function postRegister(Request $req){
        $validator = \Validator::make($req->all(), [
            'username' => 'required|unique:users|max:50|min:10',
            'email' => 'required|unique:users|email',
            'gender' => "required",
            'password'=>'required|min:6',
            'confirm_password' => 'same:password'
        ],[
            'username.unique' => "Username đã có người sử dụng",
            'email.email' => "Email ko đúng định dạng",
            'confirm_password.same' => 'Mật khẩu không giống nhau'
        ]);

        if ($validator->fails()) {
            return redirect()->route('get-register')
                        ->withErrors($validator)
                        ->withInput();
        }
        $user = new User;
        $user->username = $req->username;
        $user->email = $req->email;
        $user->fullname = $req->fullname;
        $user->birthdate = date('Y-m-d',strtotime($req->birthdate));
        $user->gender = $req->gender;
        $user->address = $req->address;
        $user->phone = $req->phone;
        $user->password = Hash::make($req->password);
        $user->save();
        return redirect()->route('getlogin')->with('success','Đăng kí thành công!');
    }

    function postLogin(Request $req){
        $data = [
            'email' => $req->email,
            'password' => $req->password
        ];
        if(Auth::attempt($data)){
            return redirect()->route('home');
        }
        return redirect()->back()->with('error',' Sai thông tin đăng nhập!');
    }
    function getLogout(){
        Auth::logout();
        return redirect()->route('getlogin');
    }

    function getHome(){
        // $user = Auth::user();
        // dd($user);
        $status = 1;
        $bills = Bills::with('customer','billDetail','billDetail.product')
                ->where('status',$status)->paginate(5);
        return view('pages.home',compact('bills','status'));
    }

    function getUpdateBill($id){
        $bill = Bills::where('id',$id)->first();
        if($bill){
            $bill->status = 2; //0:KH chua xac nhan| 1:KH da xac nhan | 2:admin da giao hang | 3:DH bi huy
            $bill->save();
            return redirect()->route('home')->with('success','Cập nhật thành công');
        }
        else{
            return redirect()->route('home')->with('error',"Không tìm thấy đơn hàng HD000$id");
        }
    }

    function getBillsByStatus($status){
        $bills = Bills::with('customer','billDetail','billDetail.product')          
                ->where('status',$status)->orderBy('id','DESC')->paginate(5);
        return view('pages.home',compact('bills','status'));
    }
    function getlistProduct($idType){
        $nameType=Categories::where('id',$idType)->value('name');
        $products = Products::where('id_type',$idType)->paginate(10); //paginate dung de phan trang
        return view('pages.list-product',compact('products','nameType'));
    }
    function getDeleteProduct($id){
        $product = Products::findOrFail($id);
        if($product){
            $product->deleted = 1;
            $product->save();
            return redirect()->route('listProduct',$product->id_type)->with('success','xóa thành công');
        }else {
            return redirect()->back()->with('error','không tìm thấy sản phẩm');
        }

    }
    function getUpdateProduct($id){
        $product = Products::where('id',$id)->first();
        $levelOne = Categories::where('id_parent',NULL)->get();
        $levelTwo = Categories::where('id_parent',NULL)->get();
        if($product){
            return view('pages.edit-product',compact('product','levelOne','levelTwo'));
        } else {

        
        return redirect()->back()->with('error','không tìm thấy sản phẩm');
        }
    }

    function getLevelTwo(Request $req){
        $levelTwo = Categories::where('id_parent',$req->id)->get();
        if(empty($levelTwo->toArray())){
            echo "nolevel2";
        }
        else{
            return view('ajax.leveltwo',compact('levelTwo'));
        }
    }
    function postUpdateProduct(Request $req)
    {
        //dd($req->input());
        $product = Products::findOrFail($req->id);
        if($product){

            $product->id_type = $req->id_type;
            $product->name = $req->name;
            $product->detail = $req->detail;
            $product->price = $req->price;
            $product->promotion_price = $req->promotion_price;
            $product->promotion = $req->promotion;
            $product->status = isset($req->status) && $req->status=="on" ? 1: 0;
            $product->status = isset($req->new) && $req->new=="on" ? 1: 0;
            $product->update_at = date('Y-m-d',time());
            $product->deleted = isset($req->deleted) && $req->deleted=="on" ? 1: 0;
            if($req->hasFile('image')){
                $image =$req->file('image');
                $name = time().$image->getClientOriginalName();
                $image->move('admin-master/images',$name);
                $product->image = $name;
            }
            $product ->save();
            $url =PageUrl::findOrFail($product->id_url);
            $helper = new Helpers;
            $url->url = $helper->changeTitle($product->name);
            $url->save();
            return redirect()->route('listProduct',$product->id_type)->with('success','cập nhật thành công');

        } else {
            return redirect()->back()->with('error','Không tìm thấy sản phẩm');
        }  
    }
    function getAddProduct(){
        $levelOne = Categories::where('id_parent',NULL)->get();
        return view('pages.add-product',compact('levelOne'));

    }
    function postAddProduct(Request $req)
    {
            //dd($req->all());

            $url =new PageUrl;
            $helper = new Helpers;
            $url->url = $helper->changeTitle($req->name);
            $url->save();

            $product = new Products;
            $product->id_url = $url->id;

            $product->id_type = $req->id_type;
            $product->name = $req->name;
            $product->detail = $req->detail;
            $product->price = $req->price;
            $product->promotion_price = $req->promotion_price;
            $product->promotion = $req->promotion;
            $product->status = isset($req->status) && $req->status=="on" ? 1: 0;
            $product->status = isset($req->new) && $req->new=="on" ? 1: 0;
            $product->update_at = date('Y-m-d',time());
            $product->deleted = isset($req->deleted) && $req->deleted=="on" ? 1: 0;
            if($req->hasFile('image')){
                $image =$req->file('image');
                $name = time().$image->getClientOriginalName();
                $image->move('admin-master/images',$name);
                $product->image = $name;
            }
            else {
                $url->delete();
                return redirect()->back()->with('error','Vui lòng chọn ảnh')->withInput($req->all());
            }
            $product ->save();
            
            // return redirect()->route('listProduct',$product->id_type)->with('success','cập nhật thành công');
            return redirect()->route('listProduct',$product->id_type)->with('success','thêm mới thành công');
    } 
           
        
    
}

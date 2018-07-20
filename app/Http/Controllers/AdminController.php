<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Hash;
use Auth;
use App\Bills;

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
}

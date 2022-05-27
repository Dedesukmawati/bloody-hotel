<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class user extends BaseController
{
    public function index()
    {
    return view('admin/login');
        
    }
    public function login()
    {
        //menampung user dan password
      $usernya =$this->request->getpost('txtuser');
      $passwordnya =md5($this->request->getpost('txtpass'));

       //array
       $syarat=[
           'username'=> $usernya,
           'password'=>  $passwordnya
       ];

       // mencari user bedasarkan syarat diatas
      $queryuser =$this->admin->where($syarat)->find();  

      // sql = select * form tbluser where username = ? and password = ?

      //membuktikan apakah user ada atau tidak
        //var_dump( $queryuser);
      if(count( $queryuser)==1){
          //membuat session
          $dataSession=[
              'user' => $queryuser[0]['username'],
              'nama' => $queryuser[0]['namauser'],
              'level' => $queryuser[0]['level'],
              'sudahkahLogin'=>true
          ];
          session()->set($dataSession);
         
          //jika sukses login arahkan ke dashboard
          return redirect()->to(site_url('/dashboard'));
        } else{
              //mengembalikan ke halaman login
              return redirect()->to(site_url('/login'))->with('info','<div style="color:pink;font-size:20px">gagal login </div>');

        }  
      
    }
    public function logout(){
        //menghapus session
        sessiion()->destory();
        //mengarahkan ke halaman login
        return redirect()->to(site_url('/login'));
    }
}

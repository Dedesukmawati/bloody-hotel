<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Fasilitashotel extends BaseController
{
    public function index()
    {
        //memuat data denagn index judulhalamann dan mengirim ke view
        $data['JudulHalaman']='Fasilitas Hotel';
        
        //memuat data denagn index dan mengirim ke view
         $data['introText']='<p>berikut ini adalah daftar fasilitas hotel,silahkan lakukan 
         pengolahan fasilitas moon hotel</p>';

         // memanggil data fasilitas dari mysql
         $data['listfasilitas']=$this->fasilitashotel->find();
         
        //memanggil  file tampil-fasilitas.php di folder view/admin
        return view('admin/tampil-fasilitas-hotel',$data);
    }

    public function tambah()
    {
         //memuat data denagn index judulhalamann dan mengirim ke view
        $data['JudulHalaman']='penambahan Fasilitas Hotel';
        
        //memuat data denagn index dan mengirim ke view
         $data['introText']='<p>berikut ini adalah daftar fasilitas moon hotel,silahkan lakukan 
         pengolahan fasilitas moon hotel</p>';

         //lod helper form
         helper(['form']);
 
         //buat aturan form
         $aturanform=[
             'txtNamaFasilitas'=>'required',
             'txtDeskripsiFasilitas'=>'required',
         ];
 
         //mengecek apakah tombol simpan diklil ?
         if($this->validate($aturanform)){
             //poses upload
            $foto= $this->request->getFile('txtFotoFasilitas');
              //poses upload
            $foto->move('uploads');
             //menyiapkan data yang akan di simpan ke mysql

             $data=[
               'nama_fasilitas'=>$this->request->getPost('txtNamaFasilitas'),
               'deskripsi_fasilitas'=>$this->request->getPost('txtDeskripsiFasilitas'),
               'foto_fasilitas'=>$foto->getClientName()    //<-----mengambil nama file
           ];
           //menyimpan ke mysql tbl_fasilitas_hotel
           $this->fasilitashotel->save($data);
           //menyimpan kehalaman/fasilitas-hotel dng membuka pesan sukses
           return redirect()->to(site_url('/Fasilitashotel'))->with('info','<div class="alert alert-success">data berhasil disimpan</div>');

         }


        //memanggil  file tampil-fasilitas.php di folder view/admin
        return view('admin/tambah-fasilitas-hotel',$data);
    }

    public function hapus($id_fasilitas_hotel){
        // Menenetukan primary key dari data yang akan dihapus
        $syarat=[
        'id_fasilitas_hotel'=>$id_fasilitas_hotel
        ];
        
        //  Ambil detail untuk mengambil nama file yang akan dihapus
               $fileInfo=$this->fasilitashotel->where($syarat)->find()[0];
        
        if(file_exists('uploads/'.$fileInfo['foto_fasilitas']))
        {
        // Menghapus file foto
        unlink('uploads/'.$fileInfo['foto_fasilitas']);
        
        // Menghapus data fasiltias di mysql
        $this->fasilitashotel->where($syarat)->delete();
        
        // Kembali ke tampil fasilitas       	 
        return redirect()->to(site_url('/fasilitas-hotel'))->with('info','<div class="alert alert-success">Data berhasil dihapus</div>');
        }
        }

        public function edit($id_fasilitas_hotel=null){
   	 
            //  Menyiapakan judulHalaman dan intro text
            
            $data['JudulHalaman']='Perubahan Fasilitas Hotel';
            $data['introText']='<p>Untuk merubah data fasilitas hotel silahkan lakukan perubahan pada form dibawah ini</p>';
            
            //  hanya dijalankan ketika memilih tombol edit
            if($id_fasilitas_hotel!=null){
            
            // mencari data fasilitas berdasarkan primary key
            $syarat=[
            'id_fasilitas_hotel' => $id_fasilitas_hotel
            ];
                $data['detailFasilitasHotel']=$this->fasilitashotel->where($syarat)->find()[0];
            }
            
            // loading helper form
            helper(['form']);
                    
            // mengatur form
            $aturanForm=[
                        'txtNamaFasilitas'=>'required',
                        'txtDeskripsiFasilitas'=>'required'
            ];
            
            //  dijalankan saat tombol update ditekan 
            //    dan semua kolom diisi
            
            if($this->validate($aturanForm)){
            
            $foto=$this->request->getFile('txtFotoFasilitas');
            // jika foto di ganti
            if($foto->isValid()){
            $foto->move('uploads');
            $data=[
            'nama_fasilitas'=> $this->request->getPost('txtNamaFasilitas'),
            'deskripsi_fasilitas' => $this->request->getPost('txtDeskripsiFasilitas'),
            'foto_fasilitas'=> $foto->getClientName()
            ];
                unlink('uploads/'.$this->request->getPost('txtFotoFasilitas'));
            } else {
            // jika foto tidak diganti
            $data=[
            'nama_fasilitas'=> $this->request->getPost('txtNamaFasilitas'),
            'deskripsi_fasilitas' => $this->request->getPost('txtDeskripsiFasilitas')
            ];
            }
                        
            // update fasilitas hotel        	
            $this->fasilitashotel->update($this->request->getPost('txtIdFasilitasHotel'),$data);
            
            // redirect ke fasilitas-hotel 
            return 
            redirect()->to(site_url('/fasilitas-hotel'))->with('info','<div class="alert alert-success">Data berhasil diupdate</div>');
            }
                    
            return view('admin/edit-fasilitas-hotel',$data);
                    
            }
            public function tampilDiHome(){
                $data['JudulHalaman']='Fasilitas Hotel';
                $data['listFasilitas']=$this->fasilitashotel->find();
                $data['introText']='<p>Berikut ini adalah fasilitas hotel yang tersedia untuk para tamu hotel</p>';
        
                return view('home-fasilitas-hotel',$data);
        }
        
                
            

       
}

        
    


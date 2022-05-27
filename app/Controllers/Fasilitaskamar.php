<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Fasilitaskamar extends BaseController
{
    public function index()
    {
        //memuat data denagn index judulhalamann dan mengirim ke view
        $data['JudulHalaman']='Fasilitas kamar';
        
        //memuat data denagn index dan mengirim ke view
         $data['introText']='<p>berikut ini adalah daftar fasilitas kamar,silahkan lakukan 
         pengolahan fasilitas moon hotel</p>';

         // memanggil data fasilitas dari mysql
         $data['listfasilitaskamar']=$this->fasilitaskamar->find();
         
        //memanggil  file tampil-fasilitas.php di folder view/admin
        return view('admin/tampil-fasilitas-kamar',$data);
    }

    public function tambah()
    {
         //memuat data denagn index judulhalamann dan mengirim ke view
        $data['JudulHalaman']='penambahan Fasilitas kamar';
        
        //memuat data denagn index dan mengirim ke view
         $data['introText']='<p>berikut ini adalah daftar fasilitas moon hotel,silahkan lakukan 
         pengolahan fasilitas moon hotel</p>';

         //lod helper form
         helper(['form']);
 
         //buat aturan form
         $aturanform=[
             'txtNamaKamar'=>'required',
             'txtDeskripsiKamar'=>'required',
         ];
 
         //mengecek apakah tombol simpan diklil ?
         if($this->validate($aturanform)){
             //poses upload
            $foto= $this->request->getFile('txtFotoKamar');
              //poses upload
            $foto->move('uploads');
             //menyiapkan data yang akan di simpan ke mysql

             $data=[
               'nama_kamar'=>$this->request->getPost('txtNamaKamar'),
               'deskripsi_kamar'=>$this->request->getPost('txtDeskripsiKamar'),
               'foto_kamar'=>$foto->getClientName()    //<-----mengambil nama file
           ];
           //menyimpan ke mysql tbl_fasilitas_kamar
           $this->fasilitaskamar->save($data);
           //menyimpan kehalaman/fasilitas-kamar dng membuka pesan sukses
           return redirect()->to(site_url('/fasilitaskamar'))->with('info','<div class="alert alert-success">data berhasil disimpan</div>');

         }


        //memanggil  file tampil-fasilitas.php di folder view/admin
        return view('admin/tambah-fasilitas-kamar',$data);
    }

    public function hapus($id_fasilitas_kamar){
        // Menenetukan primary key dari data yang akan dihapus
        $syarat=[
        'id_fasilitas_kamar'=>$id_fasilitas_kamar
        ];
        
        //  Ambil detail untuk mengambil nama file yang akan dihapus
               $fileInfo=$this->fasilitaskamar->where($syarat)->find()[0];
        
        if(file_exists('uploads/'.$fileInfo['foto_kamar']))
        {
        // Menghapus file foto
        unlink('uploads/'.$fileInfo['foto_kamar']);
        
        // Menghapus data fasiltias di mysql
        $this->fasilitaskamar->where($syarat)->delete();
        
        // Kembali ke tampil fasilitas       	 
        return redirect()->to(site_url('/fasilitas-kamar'))->with('info','<div class="alert alert-success">Data berhasil dihapus</div>');
        }
        }

        public function edit($id_fasilitas_kamar=null){
   	 
            //  Menyiapakan judulHalaman dan intro text
            
            $data['JudulHalaman']='Perubahan Fasilitas kamar';
            $data['introText']='<p>Untuk merubah data fasilitas kamar silahkan lakukan perubahan pada form dibawah ini</p>';
            
            //  hanya dijalankan ketika memilih tombol edit
            if($id_fasilitas_kamar!=null){
            
            // mencari data fasilitas berdasarkan primary key
            $syarat=[
            'id_fasilitas_kamar' => $id_fasilitas_kamar
            ];
                $data['detailFasilitasKamar']=$this->fasilitaskamar->where($syarat)->find()[0];
            }
            
            // loading helper form
            helper(['form']);
                    
            // mengatur form
            $aturanForm=[
                        'txtNamaKamar'=>'required',
                        'txtDeskripsiKamar'=>'required'
            ];
            
            //  dijalankan saat tombol update ditekan 
            //    dan semua kolom diisi
            
            if($this->validate($aturanForm)){
            
            $foto=$this->request->getFile('txtFotoKamar');
            // jika foto di ganti
            if($foto->isValid()){
            $foto->move('uploads');
            $data=[
            'nama_kamar'=> $this->request->getPost('txtNamaKamar'),
            'deskripsi_kamar' => $this->request->getPost('txtDeskripsiKamar'),
            'foto_kamar'=> $foto->getClientName()
            ];
                unlink('uploads/'.$this->request->getPost('txtFotoKamar'));
            } else {
            // jika foto tidak diganti
            $data=[
            'nama_kamar'=> $this->request->getPost('txtNamaKamar'),
            'deskripsi_kamar' => $this->request->getPost('txtDeskripsiKamar')
            ];
            }
                        
            // update fasilitas kamar 	
            $this->fasilitaskamar->update($this->request->getPost('txtIdFasilitasKamar'),$data);
            
            // redirect ke fasilitas-kamar
            return 
            redirect()->to(site_url('/fasilitas-kamar'))->with('info','<div class="alert alert-success">Data berhasil diupdate</div>');
            }
                    
            return view('admin/edit-fasilitas-kamar',$data);
                    
            }
        
            public function tampilDiHome(){
                $data['JudulHalaman']='Fasilitas Kamar';
                $data['listFasilitas']=$this->fasilitaskamar->find();
                $data['introText']='<p>Berikut ini adalah fasilitas kamar yang tersedia sesuai tipe kamar yang ada.</p>';
        
                return view('home-fasilitas-kamar',$data);
        }
        
    
        
}

<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Kamar extends BaseController
{
    public function index()
    {
        $data['JudulHalaman']='Data Kamar';

 	$data['introText']='<p>Berikut ini adalah daftar kamar, silahkan lakukan pengelolaan  data kamar </p>';   
	 
 	$data['listKamar']=$this->kamar->find();
 	return view('admin/tampil-kamar',$data);   

    }
    public function tambah(){
    	// Set judul halaman
    	$data['JudulHalaman']='Data Kamar';

    	//  Set intro halaman
    	$data['introText']='<p>Berikut ini adalah daftar kamar, silahkan lakukan pengelolaan  data kamar </p>';  
 	 
    	//  kirim data fasilitas kamar untuk checkbox
    	$data['listFasilitasKamar']=$this->fasilitaskamar->find();

    	// load form helper
    	helper(['form']);
    	$aturanForm=[
        	'txtHargaKamar'=>'required'
    	];

        // cek apakah txtHargaKamar diisi saat tombol simpan ditekan
    	if($this->validate($aturanForm)){
        	//  ambil file foto simpan di variabel $foto
        	$foto=$this->request->getFile('txtFotoKamar');

        	//  upload foto ke folder upload
        	$foto->move('uploads');

        	//  siapkan data kamar dalam array
          $dataKamar=[
           'jumlah_kamar'=>$this->request->getPost('txtJumlahKamar'),
           'harga_kamar'=>$this->request->getPost('txtHargaKamar'),
           'tipe_kamar'=>$this->request->getPost('txtTipeKamar'),

            // nama file foto disimpan ke database
            'foto_kamar'=>$foto->getClientName()  
             ];

        	//  simppan ke tbl_kamar
        	$this->kamar->save($dataKamar);

           //  kumpulkan fasiltias kamar yang di ceklist dalam array
        	$txtIdFasilitasKamar=$this->request->getPost('txtIdFasilitasKamar');
        	for($a=0;$a<count($txtIdFasilitasKamar);$a++){
            	$dataFasilitasKamar[]=[

         // id_kamar berasal dari id_kamar terakhir yang disimpan
           'id_kamar'=>$this->kamar->getInsertID(),
           'id_fasilitas_kamar'=>$txtIdFasilitasKamar[$a]    
            	];
        	}
        	// simpan fasilitas kamar ke tbl_detail_kamar
        	$this->detailkamar->insertBatch($dataFasilitasKamar);

        	//  arahkan ke tampil kamar
        	return redirect()->to(site_url('/tampil-kamar'))->with('info','<div class="alert alert-success">Data berhasil disimpan</div>');

    	};
        	//  load view admin/tambah-kamar.php   	 
    	return view('admin/tambah-kamar',$data); 	 
   }

     public function hapus($idKamar){
         //  syarat hapus kamar
        $syaratHapus=[
           'id_kamar'=>$idKamar
        ];
    
         // info detail kamar yang akan dihapus
        $detailKamar=$this->kamar->where($syaratHapus)->find()[0];

        // hapus file foto kamar di folder upload
        //unlink('uploads/'.$detailKamar['foto_kamar']);

          // hapus kamar mysql
        $this->kamar->where($syaratHapus)->delete();

         // arahkan ke tampil-kamar dgn membawa pesan sukses 
        return redirect()->to('/tampil-kamar')->with('info','<div class="alert alert-success">Kamar berhasil dihapus</div>');   	 

    }
   
        public function edit($idKamar=null){
        //  Set judul halaman
       $data['JudulHalaman']='Data Kamar';

    //  Set intro halaman
    $data['introText']='<p>Berikut ini adalah daftar kamar, silahkan lakukan pengelolaan  data kamar </p>';  

    //  Bagian hanya dijalankan ketika mengklik tombol edit
    if($idKamar!=null){
        //  syarat hapus kamar
        $syarat=[
            'id_kamar'=>$idKamar
        ];
        
//  info  kamar yang akan dihapus
        $data['Kamar']=$this->kamar->where($syarat)->find()[0];
        $data['idKamar']=$idKamar;
    }

    //  kirim data fasilitas kamar untuk checkbox
    $data['listFasilitasKamar']=$this->fasilitaskamar->find();

    //  load form helper
    helper(['form']);
    $aturanForm=[
        'txtHargaKamar'=>'required'
    ];

    //  bagian ini dijalankan jika tombol update diklik
    if($this->validate($aturanForm)){
        
        //  menampung file foto
        $foto=$this->request->getFile('txtFotoKamar');
        
        //  mengecek apakah memilih file foto atau tidak
        if($foto->isValid()){
            
     //  hapus foto lama
          //  unlink('uploads/'.$this->request->getPost['txtFotoKamar']);

     //  upload yang baru
           $foto->move('uploads');
            $dataKamar=[
        'jumlah_kamar'=>$this->request->getPost('txtJumlahKamar'),
        'harga_kamar'=>$this->request->getPost('txtHargaKamar'),
        'tipe_kamar'=>$this->request->getPost('txtTipeKamar'),
        'foto_kamar'=>$foto->getClientName()
         ];
        }else {
            //  data kamar baru
            $dataKamar=[
        'jumlah_kamar'=>$this->request->getPost('txtJumlahKamar'),
        'harga_kamar'=>$this->request->getPost('txtHargaKamar'),
        'tipe_kamar'=>$this->request->getPost('txtTipeKamar')
        ];
        }

        //  update data  kamar
        $this->kamar->update($this->request->getPost('txtIdKamar'),$dataKamar);

        //  kosongkan fasilitas kamar
        $this->detailkamar->where('id_kamar',$this->request->getPost('txtIdKamar'))->delete();

        //  kumpulkan fasiltias yang baru kamar yang di ceklist dalam array
        $txtIdFasilitasKamar=$this->request->getPost('txtIdFasilitasKamar');
        if($txtIdFasilitasKamar!=null){
            for($a=0;$a<count($txtIdFasilitasKamar);$a++){
                $dataFasilitasKamar[]=[
       'id_kamar'=>$this->request->getPost('txtIdKamar'),
       'id_fasilitas_kamar'=>$txtIdFasilitasKamar[$a]    
        ];
            }
    // simpan fasilitas kamar ke tbl_detail_kamar
     $this->detailkamar->insertBatch($dataFasilitasKamar);
   }
    // arahkan ke tampil-kamar dengan membawa pesan sukses
        return redirect()->to('/tampil-kamar')->with('info','<div class="alert alert-success">Kamar berhasil diupdate</div>');   	 
    }   	 

    //  load view admin/tambah-kamar.php   	 
    return view('admin/edit-kamar',$data); 	 
}


}

<!---memanggil isi file dashboard di folder view/admin-->
 
<?=$this->extend('admin/dashboard');?>
<!-- area putih halaman dashboard-->
<?=$this->section('konten');?>

<h2><?=$JudulHalaman;?></h2>    
<?=$introText;?>

<form method ="POST" action="<?=site_url('/tambah-fasilitas-kamar');?>" enctype="multipart/form-data">
<div class="form-group">
    <label class="font-weight-blod">nama kamar</label>
    <input type="text"name="txtNamaKamar" class="form-control"/>
</div>

<div class="form-group">
    <label class="font-weight-blod">deskripsi kamar</label>
    <input type="text"name="txtDeskripsiKamar" class="form-control"/>
</div>

<div class="form-group">
    <label class="font-weight-blod">foto kamar</label>
    <input type="file"name="txtFotoKamar" class="form-control"/>
</div>

<div class="form-group">
    <button class="btn btn-primary">Simpan Data</button>

</div>



</form>



<?=$this->endSection();?>
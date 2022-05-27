<!---memanggil isi file dashboard di folder view/admin-->
 
<?=$this->extend('admin/dashboard');?>
<!-- area putih halaman dashboard-->
<?=$this->section('konten');?>

<h2><?=$JudulHalaman;?></h2>    
<?=$introText;?>

<form method ="POST" action="<?=site_url('/tambah-fasilitas-hotel');?>" enctype="multipart/form-data">
<div class="form-group">
    <label class="font-weight-blod">nama fasilitas</label>
    <input type="text"name="txtNamaFasilitas" class="form-control"/>
</div>

<div class="form-group">
    <label class="font-weight-blod">deskripsi fasilitas</label>
    <input type="text"name="txtDeskripsiFasilitas" class="form-control"/>
</div>

<div class="form-group">
    <label class="font-weight-blod">foto fasilitas</label>
    <input type="file"name="txtFotoFasilitas" class="form-control"/>
</div>

<div class="form-group">
    <button class="btn btn-primary">Simpan Data</button>

</div>



</form>



<?=$this->endSection();?>
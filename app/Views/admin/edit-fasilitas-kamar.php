<!-- memanggil isi file dashboard.php di folder view/admin -->
<?=$this->extend('admin/dashboard');?>
<!-- area putih halaman dashboard-->
<?=$this->section('konten');?>

<h2><?=$JudulHalaman;?></h2>
<?=$introText;?>

<form method="POST" action="<?=site_url('/edit-fasilitas-kamar');?>" enctype="multipart/form-data">

<div class="form-group">
	<label class="font-weight-bold">Nama kamar</label>
	<input type="text" name="txtNamaKamar" class="form-control" value="<?=$detailFasilitasKamar['nama_kamar'];?>"/>

	<input type="hidden" name="txtIdFasilitasKamar" class="form-control" value="<?=$detailFasilitasKamar['id_fasilitas_kamar'];?>"/>

	<input type="hidden" name="txtFotoKamar" class="form-control" value="<?=$detailFasilitasKamar['foto_kamar'];?>"/>
</div>

<div class="form-group">
	<label class="font-weight-bold">Deskripsi kamar</label>
	<textarea class="form-control" name="txtDeskripsiKamar" rows="5"><?=$detailFasilitasKamar['deskripsi_kamar'];?></textarea>
</div>

<div class="form-group">
	<label class="font-weight-bold">Foto kamars</label>
	<input type="file" name="txtFotoKamar" class="form-control"/>
</div>

<div class="form-group">
	<button class="btn btn-warning btn-sm" OnClick="javascipt:history.back()">Batal</button>
	<button class="btn btn-primary btn-sm">Update Data</button>

</div>

</form>

<?=$this->endSection();?>

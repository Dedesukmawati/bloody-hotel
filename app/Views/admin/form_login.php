<form method="post" action="<?=site_url('/login');?>">


<!---pesan eror login--->

<?=session()->getFlashData('info');?>

<p>username<br/>
    <input type="text" name="txtuser"/>
</p>

<p>password<br/>
     <input type="password" name="txtpass"/>
</p>

<p>
    <button type="submit">login</button>
</p>

</form>
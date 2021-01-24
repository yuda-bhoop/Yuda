<?php
	//Koneksi Database
	$server = "localhost";
	$user = "root";
	$pass = "";
	$database = "alumni";

	$koneksi = mysqli_connect($server, $user, $pass, $database)or die(mysqli_error($koneksi));

	//jika tombol simpan diklik
	if(isset($_POST['bsimpan']))
	{
		//Pengujian Apakah data akan diedit atau disimpan baru
		if(@$_GET['hal'] == "edit")
		{
			//Data akan di edit
			$edit = mysqli_query($koneksi, "UPDATE kelas set
											 	jurusan = '$_POST[tjurusan]',
												angkatan = '$_POST[tangkatan]',
											 	tahun_lulus = '$_POST[ttahun_lulus]'
											 WHERE id_kelas = '$_GET[id]'
										   ");
			if($edit) //jika edit sukses
			{
				echo "<script>
						alert('Edit data suksess!');
						document.location='kelas.php';
				     </script>";
			}
			else
			{
				echo "<script>
						alert('Edit data GAGAL!!');
						document.location='kelas.php';
				     </script>";
			}
		}
		else
		{
			//Data akan disimpan Baru
			$simpan = mysqli_query($koneksi, "INSERT INTO kelas (jurusan, angkatan, tahun_lulus)
										  VALUES ( 
										  		 '$_POST[tjurusan]', 
										  		 '$_POST[tangkatan]', 
										  		 '$_POST[ttahun_lulus]')
										 ");
			if($simpan) //jika simpan sukses
			{
				echo "<script>
						alert('Simpan data suksess!');
						document.location='kelas.php';
				     </script>";
			}
			else
			{
				echo "<script>
						alert('Simpan data GAGAL!!');
						document.location='kelas.php';
				     </script>";
			}
		}


		
	}


	//Pengujian jika tombol Edit / Hapus di klik
	if(isset($_GET['hal']))
	{
		//Pengujian jika edit Data
		if(@$_GET['hal'] == "edit")
		{
			//Tampilkan Data yang akan diedit
			$tampil = mysqli_query($koneksi, "SELECT * FROM kelas WHERE id_kelas = '$_GET[id]' ");
			$data = mysqli_fetch_array($tampil);
			if($data)
			{
				//Jika data ditemukan, maka data ditampung ke dalam variabel
			
				$vjurusan = $data['jurusan'];
				$vangkatan = $data['angkatan'];
				$vtahun_lulus = $data['tahun_lulus'];
			}
		}
		else if (@$_GET['hal'] == "hapus")
		{
			//Persiapan hapus data
			$hapus = mysqli_query($koneksi, "DELETE FROM kelas WHERE id_kelas = '$_GET[id]' ");
			if($hapus){
				echo "<script>
						alert('Hapus Data Suksess!!');
						document.location='kelas.php';
				     </script>";
			}
		}
	}

?>

<!DOCTYPE html>
<html>
<head>
	<!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">

	<title>Data Kelas</title>
</head>
<body style="background-color: #6c5ce7">
<div class="container">

	<h1 class="text-center">DATA KELAS</h1>
	<h2 class="text-center">Alumni Sekolah</h2>

	<!-- Awal Card Form -->
	<div class="card mt-3">
	  <div class="card-header bg-primary text-white">
	    Form Input Data Kelas
	  </div>
	  <div class="card-body">
	    <form method="post" action="">

	    	<div class="form-group">
	    		<label>Jurusan</label>
	    		<input type="text" name="tjurusan" value="<?=@$vjurusan?>" class="form-control" placeholder="Input Jurusan anda disini!" required>
	    	</div>
	    	<div class="form-group">
	    		<label>Angkatan</label>
	    		<textarea class="form-control" name="tangkatan"  placeholder="Input tahun angkatan anda disini!"><?=@$vangkatan?></textarea>
	    	</div>
	    	<div class="form-group">
	    		<label>Tahun Lulus</label>
	    		<textarea class="form-control" name="ttahun_lulus"  placeholder="Input tahun Lulus anda disini!"><?=@$vtahun_lulus?></textarea>
	    	</div>

	    	<button type="submit" class="btn btn-success" name="bsimpan">Simpan</button>
	    	<button type="reset" class="btn btn-danger" name="breset">Kosongkan</button>

	    </form>
	  </div>
	</div>
	<!-- Akhir Card Form -->

	<!-- Awal Card Tabel -->
	<div class="card mt-3">
	  <div class="card-header bg-success text-white">
	    Daftar Kelas
	  </div>
	  <div class="card-body">
	    
	    <table class="table table-bordered table-striped">
	    	<tr>
	    		<th>No.</th>
	    		<th>Jurusan</th>
	    		<th>Angkatan</th>
	    		<th>Tahun Lulus</th>
	    		<th>Aksi</th>
	    	</tr>
	    	<?php
	    		$no = 1;
	    		$tampil = mysqli_query($koneksi, "SELECT * from kelas order by id_kelas desc");
	    		while($data = mysqli_fetch_array($tampil)) :

	    	?>
	    	<tr>
	    		<td><?=$no++;?></td>
	    		<td><?=$data['jurusan']?></td>
	    		<td><?=$data['angkatan']?></td>
	    		<td><?=$data['tahun_lulus']?></td>
	    		<td>
	    			<a href="kelas.php?hal=edit&id=<?=$data['id_kelas']?>" class="btn btn-warning"> Edit </a>
	    			<a href="kelas.php?hal=hapus&id=<?=$data['id_kelas']?>" 
	    			   onclick="return confirm('Apakah yakin ingin menghapus data ini?')" class="btn btn-danger"> Hapus </a>
	    		</td>
	    	</tr>
	    <?php endwhile; //penutup perulangan while ?>
	    </table>

	  </div>
	</div>
	<!-- Akhir Card Tabel -->
	<a href="index.php" class="btn btn-warning">Data Siswa</a>
		<a href="kelas.php" class="btn btn-warning">Data Kelas</a>
			<a href="wali.php" class="btn btn-warning">Data Wali</a>
</div>
 <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>

</body>
</html>
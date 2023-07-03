<?php
	header("Content-Type:application/json");
	header("Access-Control-Allow-Origin: *");
	header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
	header("Access-Control-Allow-Headers: content-type");

	$conn = mysqli_connect('localhost', 'root', '', 'wandri'); 
	mysqli_set_charset($conn, 'utf8');
	$method = $_SERVER['REQUEST_METHOD'];
	$results = array();

	if ($method == 'GET') {
		$query = mysqli_query($conn, 'SELECT * FROM anggota');

		if (mysqli_num_rows($query) > 0) {
			while($row = mysqli_fetch_assoc($query)) {
				$results['Status']['success'] = true;
				$results['Status']['code'] = 200;
				$results['Status']['description'] = 'Request Valid';
				$results['Hasil'][] = [
					'id' => $row,
					'nomor' => $row['nomor'],
					'nama' => $row['nama'],
					'jenis_kelamin' => $row['jenis_kelamin'],
					'alamat' => $row['alamat'],
					'no_hp' => $row['no_hp'],
					'tanggal_terdaftar' => $row['tanggal_terdaftar']
				];
			}
		}
		else{
			$results['Status']['code'] = 400;
			$results['Status']['description'] = 'Request Invalid';
		}
	}


	elseif ($method == 'POST'){
		$nomor = $_POST['nomor'];
		$nama = $_POST['nama'];
		$jenis_kelamin = $_POST['jenis_kelamin'];
		$alamat = $_POST['alamat'];
		$no_hp = $_POST['no_hp'];
		$tanggal_terdaftar = $_POST['tanggal_terdaftar'];

		$sql = "INSERT INTO anggota (nomor, nama, jenis_kelamin, alamat, no_hp, tanggal_terdaftar) VALUES ('$nomor', '$nama', '$jenis_kelamin', '$alamat', '$no_hp', '$tanggal_terdaftar')";

		$conn->query($sql);

		$results['Status']['success'] = true;
		$results['Status']['code'] = 200;
		$results['Status']['description'] = 'Request Valid';
		$results['Hasil'] = array(
			'nomor' => $nomor,
			'nama' => $nama,
			'jenis_kelamin' => $jenis_kelamin,
			'alamat' => $alamat,
			'no_hp' => $no_hp,
			'tanggal_terdaftar' => $tanggal_terdaftar
		);			
	}

	// elseif ($method == 'PUT'){
	// 	parse_str(file_get_contents('php://input'), $_PUT);
	// 	$id = $_PUT['id'];
	// 	$kode = $_PUT['kode'];
	// 	$kode_kategori = $_PUT['kode_kategori'];
	// 	$judul = $_PUT['judul'];
	// 	$pengarang = $_PUT['pengarang'];
	// 	$penerbit = $_PUT['penerbit'];
	// 	$tahun = $_PUT['tahun'];
	// 	$tanggal_input = $_PUT['tanggal_input'];
	// 	$harga = $_PUT['harga'];
	// 	$file_cover = $_PUT['file_cover'];
		

	// 	$sql = "UPDATE books SET kode = '$kode', kode_kategori = '$kode_kategori', judul = '$judul', pengarang ='$pengarang', penerbit = '$penerbit', tahun = '$tahun', tanggal_input = '$tanggal_input', harga = '$harga', file_cover = '$file_cover' WHERE id ='$id'";
		
	// 	$conn->query($sql);

	// 	$results['Status']['success'] = true;
	// 	$results['Status']['code'] = 200;
	// 	$results['Status']['description'] = 'Data Succesfully Updated';
	// 	$results['Hasil'] = array(
	// 		'kode' => $kode,
	// 		'kode_kategori' => $kode_kategori,
	// 		'judul' => $judul,
	// 		'pengarang' => $pengarang,
	// 		'penerbit' => $penerbit,
	// 		'tahun' => $tahun,
	// 		'tanggal_input' => $tanggal_input,
	// 		'harga' => $harga,
	// 		'file_cover' => $file_cover,
	// 	);			
	// }
	elseif ($method == 'PUT') {
		$data = json_decode(file_get_contents('php://input'), true);
	
		if ($data !== null) {
			$id = $data['id'];
			$kode = $data['kode'];
			$kode_kategori = $data['kode_kategori'];
			$judul = $data['judul'];
			$pengarang = $data['pengarang'];
			$penerbit = $data['penerbit'];
			$tahun = $data['tahun'];
			$tanggal_input = $data['tanggal_input'];
			$harga = $data['harga'];
			$file_cover = $data['file_cover'];
	
			$sql = "UPDATE books SET kode = '$kode', kode_kategori = '$kode_kategori', judul = '$judul', pengarang ='$pengarang', penerbit = '$penerbit', tahun = '$tahun', tanggal_input = '$tanggal_input', harga = '$harga', file_cover = '$file_cover' WHERE id ='$id'";
			
			$conn->query($sql);
	
			$results['Status']['success'] = true;
			$results['Status']['code'] = 200;
			$results['Status']['description'] = 'Data Successfully Updated';
			$results['Hasil'] = array(
				'kode' => $kode,
				'kode_kategori' => $kode_kategori,
				'judul' => $judul,
				'pengarang' => $pengarang,
				'penerbit' => $penerbit,
				'tahun' => $tahun,
				'tanggal_input' => $tanggal_input,
				'harga' => $harga,
				'file_cover' => $file_cover,
			);
		} else {
			$results['Status']['code'] = 400;
			$results['Status']['description'] = 'Invalid JSON Data';
		}
	}
	
	

	elseif ($method == 'DELETE'){
		parse_str(file_get_contents('php://input'), $_DELETE);
		$id = $_DELETE['id'];

		$sql = "DELETE FROM anggota WHERE id ='$id'";
		$conn->query($sql);

		$results['Status']['success'] = true;
		$results['Status']['code'] = 200;
		$results['Status']['description'] = 'Data Succesfully Deleted';		
	}

	else{
		$results['Status']['code'] = 404;
	}

	//Menampilkan Data JSON dari Database
	$json = json_encode($results);
	print_r($json);
?>
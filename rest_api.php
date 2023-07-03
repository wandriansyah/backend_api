<?php
	header("Content-Type:application/json");
	header("Access-Control-Allow-Origin: *");
	header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
	header("Access-Control-Allow-Headers: content-type");

	$conn = mysqli_connect('localhost', 'root', '', 'wandri'); 
	mysqli_set_charset($conn, 'utf8');
	$method = $_SERVER['REQUEST_METHOD'];
	$results = array();

	// if($method == 'GET') {
	// 	// Mendapatkan nilai ID dari parameter URL
	// 	if (isset($_GET['id'])) {
	// 		$id = $_GET['id'];
	// 		$query = mysqli_query($conn, "SELECT * FROM books WHERE id = '$id'");
	
	// 		if (mysqli_num_rows($query) > 0) {
	// 			$row = mysqli_fetch_assoc($query);
	// 			$results['Status']['success'] = true;
	// 			$results['Status']['code'] = 200;
	// 			$results['Status']['description'] = 'Request Valid';
	// 			$results['Hasil'] = [
	// 				'id' => $row['id'],
	// 				'kode' => $row['kode'],
	// 				'kode_kategori' => $row['kode_kategori'],
	// 				'judul' => $row['judul'],
	// 				'pengarang' => $row['pengarang'],
	// 				'penerbit' => $row['penerbit'],
	// 				'tahun' => $row['tahun'],
	// 				'tanggal_input' => $row['tanggal_input'],
	// 				'harga' => $row['harga'],
	// 				'file_cover' => $row['file_cover'],
	// 			];
	// 		} else {
	// 			$results['Status']['code'] = 404;
	// 			$results['Status']['description'] = 'Data not found';
	// 		}
	// 	} else {
	// 		$results['Status']['code'] = 400;
	// 		$results['Status']['description'] = 'Request Invalid';
	// 	}
	// }

	// elseif($method == 'GET') {
	// 	$query = mysqli_query($conn, 'SELECT * FROM books');

	// 	if (mysqli_num_rows($query) > 0) {
	// 		while($row = mysqli_fetch_assoc($query)) {
	// 			$results['Status']['success'] = true;
	// 			$results['Status']['code'] = 200;
	// 			$results['Status']['description'] = 'Request Valid';
	// 			$results['Hasil'][] = [
	// 				'id' => $row,
	// 				'kode' => $row['kode'],
	// 				'kode_kategori' => $row['kode_kategori'],
	// 				'judul' => $row['judul'],
	// 				'pengarang' => $row['pengarang'],
	// 				'penerbit' => $row['penerbit'],
	// 				'tahun' => $row['tahun'],
	// 				'tanggal_input' => $row['tanggal_input'],
	// 				'harga' => $row['harga'],
	// 				'file_cover' => $row['file_cover'],
	// 			];
	// 		}
	// 	}
	// 	else{
	// 		$results['Status']['code'] = 400;
	// 		$results['Status']['description'] = 'Request Invalid';
	// 	}
	// }


	// elseif ($method == 'GET') {
	// 	// Mendapatkan nilai ID dari parameter URL
	// 	if (isset($_GET['id'])) {
	// 		$id = $_GET['id'];
	// 		$query = mysqli_query($conn, "SELECT * FROM books WHERE id = '$id'");
	
	// 		if (mysqli_num_rows($query) > 0) {
	// 			$row = mysqli_fetch_assoc($query);
	// 			$results['Status']['success'] = true;
	// 			$results['Status']['code'] = 200;
	// 			$results['Status']['description'] = 'Request Valid';
	// 			$results['Hasil'] = [
	// 				'id' => $row['id'],
	// 				'kode' => $row['kode'],
	// 				'kode_kategori' => $row['kode_kategori'],
	// 				'judul' => $row['judul'],
	// 				'pengarang' => $row['pengarang'],
	// 				'penerbit' => $row['penerbit'],
	// 				'tahun' => $row['tahun'],
	// 				'tanggal_input' => $row['tanggal_input'],
	// 				'harga' => $row['harga'],
	// 				'file_cover' => $row['file_cover'],
	// 			];
	// 		} else {
	// 			$results['Status']['code'] = 404;
	// 			$results['Status']['description'] = 'Data not found';
	// 		}
	// 	} else {
	// 		$results['Status']['code'] = 400;
	// 		$results['Status']['description'] = 'Request Invalid';
	// 	}
	// }

	if ($method == 'GET') {
		// Mendapatkan semua data buku
		if (!isset($_GET['id'])) {
			$query = mysqli_query($conn, "SELECT * FROM books");
	
			if (mysqli_num_rows($query) > 0) {
				$books = array();
	
				while ($row = mysqli_fetch_assoc($query)) {
					$book = [
						'id' => $row['id'],
						'kode' => $row['kode'],
						'kode_kategori' => $row['kode_kategori'],
						'judul' => $row['judul'],
						'pengarang' => $row['pengarang'],
						'penerbit' => $row['penerbit'],
						'tahun' => $row['tahun'],
						'tanggal_input' => $row['tanggal_input'],
						'harga' => $row['harga'],
						'file_cover' => $row['file_cover'],
					];
					$books[] = $book;
				}
	
				$results['Status']['success'] = true;
				$results['Status']['code'] = 200;
				$results['Status']['description'] = 'Request Valid';
				$results['Hasil'] = $books;
			} else {
				$results['Status']['success'] = false;
				$results['Status']['code'] = 404;
				$results['Status']['description'] = 'Data not found';
			}
		}
		// Mendapatkan data buku berdasarkan ID
		else {
			$id = $_GET['id'];
			$query = mysqli_query($conn, "SELECT * FROM books WHERE id = '$id'");
	
			if (mysqli_num_rows($query) > 0) {
				$row = mysqli_fetch_assoc($query);
				$results['Status']['success'] = true;
				$results['Status']['code'] = 200;
				$results['Status']['description'] = 'Request Valid';
				$results['Hasil'] = [
					'id' => $row['id'],
					'kode' => $row['kode'],
					'kode_kategori' => $row['kode_kategori'],
					'judul' => $row['judul'],
					'pengarang' => $row['pengarang'],
					'penerbit' => $row['penerbit'],
					'tahun' => $row['tahun'],
					'tanggal_input' => $row['tanggal_input'],
					'harga' => $row['harga'],
					'file_cover' => $row['file_cover'],
				];
			} else {
				$results['Status']['success'] = false;
				$results['Status']['code'] = 404;
				$results['Status']['description'] = 'Data not found';
			}
		}
	
		// // Mengembalikan response dalam format JSON
		// header('Content-Type: application/json');
		// echo json_encode($results);
	}
		

	elseif ($method == 'POST'){
		$kode = $_POST['kode'];
		$kode_kategori = $_POST['kode_kategori'];
		$judul = $_POST['judul'];
		$pengarang = $_POST['pengarang'];
		$penerbit = $_POST['penerbit'];
		$tahun = $_POST['tahun'];
		$tanggal_input = $_POST['tanggal_input'];
		$harga = $_POST['harga'];
		$file_cover = $_POST['file_cover'];


		$sql = "INSERT INTO books (kode, kode_kategori, judul, pengarang, penerbit, tahun, tanggal_input, harga, file_cover ) VALUES ('$kode', '$kode_kategori', '$judul', '$pengarang', '$penerbit', '$tahun', '$tanggal_input', '$harga', '$file_cover')";

		$conn->query($sql);

		$results['Status']['success'] = true;
		$results['Status']['code'] = 200;
		$results['Status']['description'] = 'Request Valid';
		$results['Hasil'] = array(
			'kode' => $kode,
			'kode_kategori' => $kode_kategori,
			'judul' => $judul,
			'pengarang' => $pengarang,
			'penerbit' => $penerbit,
			'tahun' => $tahun,
			'tanggal_input' => $tanggal_input,
			'harga' => $harga,
			'file_cover' => $file_cover
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

		$sql = "DELETE FROM books WHERE id ='$id'";
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
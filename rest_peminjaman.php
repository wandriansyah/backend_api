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
        $query = mysqli_query($conn, 'SELECT anggota.id, anggota.nomor, anggota.nama, anggota.jenis_kelamin, anggota.alamat, anggota.no_hp, anggota.tanggal_terdaftar, peminjaman_master.id AS peminjaman_id, peminjaman_master.tanggal_peminjaman, peminjaman_master.status_peminjaman, peminjaman_master.tanggal_pengembalian, peminjaman_master.durasi_keterlambatan FROM anggota LEFT JOIN peminjaman_master ON anggota.nomor = peminjaman_master.nomor_anggota');


        // $json = json_encode($query);
        // print_r($json);

        // die();
    
        if (mysqli_num_rows($query) > 0) {
            while ($row = mysqli_fetch_assoc($query)) {
                $results['Status']['success'] = true;
                $results['Status']['code'] = 200;
                $results['Status']['description'] = 'Request Valid';
                $results['Hasil'][] = [
                    'id' => $row['id'],
                    'nomor' => $row['nomor'],
                    'nama' => $row['nama'],
                    'alamat' => $row['alamat'],
                    'tanggal_peminjaman' => $row['tanggal_peminjaman'],
                    'status_peminjaman' => $row['status_peminjaman'],
                    'tanggal_pengembalian' => $row['tanggal_pengembalian'],
                
                ];
            }
        } else {
            $results['Status']['success'] = false;
            $results['Status']['code'] = 404;
            $results['Status']['description'] = 'Data not found';
        }
    } else {
		$id = $_GET['id'];
		$query = mysqli_query($conn, 'SELECT anggota.id, anggota.nomor, anggota.nama, anggota.jenis_kelamin, anggota.alamat, anggota.no_hp, anggota.tanggal_terdaftar, peminjaman_master.id AS peminjaman_id, peminjaman_master.tanggal_peminjaman, peminjaman_master.status_peminjaman, peminjaman_master.tanggal_pengembalian, peminjaman_master.durasi_keterlambatan FROM anggota LEFT JOIN peminjaman_master ON anggota.nomor = peminjaman_master.nomor_anggota WHERE anggota.id = "$id"');

		if (mysqli_num_rows($query) > 0) {
			$row = mysqli_fetch_assoc($query);
			$results['Status']['success'] = true;
			$results['Status']['code'] = 200;
			$results['Status']['description'] = 'Request Valid';
			$results['Hasil'] = [
				'nomor' => $row['nomor'],
				'nama' => $row['nama'],
				'alamat' => $row['alamat'],
				'tanggal_peminjaman' => $row['tanggal_peminjaman'],
				'status_peminjaman' => $row['status_peminjaman'],
				'tanggal_pengembalian' => $row['tanggal_pengembalian'],
			];
		} else {
			$results['Status']['success'] = false;
			$results['Status']['code'] = 404;
			$results['Status']['description'] = 'Data not found';
		}
	}


	if ($method == 'POST'){
		$tanggal_peminjaman = $_POST['tanggal_peminjaman'];
		$nomor_anggota = $_POST['nomor_anggota'];
		$status_peminjaman = $_POST['status_peminjaman'];
		$tanggal_pengembalian = $_POST['tanggal_pengembalian'];
		$durasi_keterlambatan = $_POST['durasi_keterlambatan'];
	

		$sql = "INSERT INTO peminjaman_master (tanggal_peminjaman, nomor_anggota, status_peminjaman, tanggal_pengembalian, durasi_keterlambatan) VALUES ('$tanggal_peminjaman', '$nomor_anggota', '$status_peminjaman', '$tanggal_pengembalian', '$durasi_keterlambatan')";

		$conn->query($sql);

		$results['Status']['success'] = true;
		$results['Status']['code'] = 200;
		$results['Status']['description'] = 'Request Valid';
		$results['Hasil'] = array(
			'tanggal_peminjaman' => $tanggal_peminjaman,
			'nomor_anggota' => $nomor_anggota,
			'status_peminjaman' => $status_peminjaman,
			'tanggal_pengembalian' => $tanggal_pengembalian,
			'durasi_keterlambatan' => $durasi_keterlambatan
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
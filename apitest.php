<?php
include_once 'koneksi.php'; // Koneksi ke database
include_once 'GempaRepository.php'; // Kelas untuk interaksi dengan database

$gempaRepository = new GempaRepository($conn);

// Menentukan metode HTTP yang digunakan
$method = $_SERVER['REQUEST_METHOD'];

// Mengatur header untuk respons JSON
header('Content-Type: application/json');

switch ($method) {
    case 'GET':
        if (isset($_GET['id'])) {
            // Ambil data gempa berdasarkan ID
        } else {
            // Ambil semua data gempa
            $dataGempa = $gempaRepository->readGempa();
            echo json_encode($dataGempa);
        }
        break;
    
        case 'POST':
            // Ambil data dari body permintaan
            $rawInput = file_get_contents('php://input');
            error_log("Raw input: " . $rawInput); // Debugging
            $input = json_decode($rawInput, true);
            
            // Periksa apakah data berhasil di-decode
            if ($input === null) {
                echo json_encode(['message' => 'Data tidak valid.', 'input' => 'Data tidak dapat di-decode.', 'error' => json_last_error_msg()]);
                break;
            }
        
            // Periksa apakah semua field yang diperlukan ada
            if (isset($input['Magnitude'], $input['Lokasi'], $input['Waktu'], $input['Shakemap'])) {
                $magnitude = (float)$input['Magnitude']; // Pastikan ini bertipe float
                $lokasi = $input['Lokasi'];
                $waktu = $input['Waktu'];
                $shakemap = $input['Shakemap'];
        
                // Panggil metode untuk menambahkan data gempa
                if ($gempaRepository->createGempa($magnitude, $lokasi, $waktu, $shakemap)) {
                    echo json_encode(['message' => 'Data gempa berhasil ditambahkan.']);
                } else {
                    echo json_encode(['message' => 'Gagal menambahkan data gempa.']);
                }
            } else {
                echo json_encode(['message' => 'Data tidak valid.', 'input' => $input]);
            }
            break;

    case 'PUT':
                // Ambil data dari body permintaan
                $rawInput = file_get_contents('php://input');
                error_log("Raw input: " . $rawInput); // Debugging
                $input = json_decode($rawInput, true);
                
                // Periksa apakah data berhasil di-decode
                if ($input === null) {
                    echo json_encode(['message' => 'Data tidak valid.', 'input' => 'Data tidak dapat di-decode.']);
                    break;
                }
            
                // Periksa apakah semua field yang diperlukan ada
                if (isset($input['id'], $input['Magnitude'], $input['Lokasi'], $input['Waktu'], $input['Shakemap'])) {
                    $id = (int)$input['id']; // Pastikan ini bertipe integer
                    $magnitude = (float)$input['Magnitude'];
                    $lokasi = $input['Lokasi'];
                    $waktu = $input['Waktu'];
                    $shakemap = $input['Shakemap'];
            
                    // Panggil metode untuk memperbarui data gempa
                    $gempaRepository->updateGempa($id, $magnitude, $lokasi, $waktu, $shakemap);
                    echo json_encode(['message' => 'Data gempa berhasil diperbarui.']);
                } else {
                    echo json_encode(['message' => 'Data tidak valid.', 'input' => $input]);
                }
                break;
   
                case 'DELETE':
                    // Ambil ID dari parameter URL atau body permintaan
                    $id = $_GET['id'] ?? null; // Misalnya, jika ID dikirim sebagai parameter URL
                
                    if ($id === null) {
                        echo json_encode(['message' => 'ID tidak diberikan.']);
                        break;
                    }
                
                    // Panggil metode untuk menghapus data gempa
                    if ($gempaRepository->deleteGempa((int)$id)) {
                        echo json_encode(['message' => 'Data gempa berhasil dihapus.']);
                    } else {
                        echo json_encode(['message' => 'Gagal menghapus data gempa.']);
                    }
                    break;
}
?>
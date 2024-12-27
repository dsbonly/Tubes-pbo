<?php
// Memuat file yang diperlukan
include_once 'koneksi.php'; // Koneksi ke database
include_once 'IBMKGService.php'; // Antarmuka untuk BMKGService
include_once 'BMKGApi.php'; // Kelas untuk mengambil data dari BMKG
include_once 'BMKGService.php'; // Kelas untuk mengelola data dari BMKG
include_once 'GempaRepository.php'; // Kelas untuk interaksi dengan database
include_once 'IGempaService.php'; // Antarmuka untuk GempaService
include_once 'IGempaRepository.php'; // Antarmuka untuk GempaRepository
include_once 'GempaService.php'; // Kelas untuk mengelola data gempa

// Inisialisasi objek
$bmkgApi = new BMKGApi();
$gempaRepository = new GempaRepository($conn); // $conn adalah koneksi database dari koneksi.php
$bmkgService = new BMKGService($bmkgApi, $gempaRepository);
$gempaService = new GempaService($bmkgService, $gempaRepository);

// Memperbarui data gempa
$gempaService->updateData();

// Mengambil semua data gempa
$dataGempa = $gempaService->getAllData();

// Cek jika ada permintaan penghapusan
if (isset($_GET['delete_id'])) {
    $deleteId = $_GET['delete_id'];
    $gempaRepository->deleteGempa($deleteId); // Panggil metode untuk menghapus data
    header("Location: index.php"); // Redirect kembali ke index.php setelah penghapusan
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Gempa BMKG</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Data Gempa BMKG</h1>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Magnitude</th>
                    <th>Lokasi</th>
                    <th>Waktu</th>
                    <th>Shakemap</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($dataGempa)): ?>
                    <?php foreach ($dataGempa as $index => $gempa): ?>
                        <tr>
                            <td><?php echo $index + 1; ?></td>
                            <td><?php echo htmlspecialchars($gempa['Magnitude']); ?></td>
                            <td><?php echo htmlspecialchars($gempa['Lokasi']); ?></td>
                            <td><?php echo htmlspecialchars($gempa['Waktu']); ?></td>
                            <td>
                                <?php 
                                // Asumsikan nama file shakemap sesuai dengan ID atau informasi lain dari data gempa
                                $shakemapFile = 'images/' . htmlspecialchars($gempa['Shakemap']); 
                                ?>
                                <img src="<?php echo $shakemapFile; ?>" alt="Shakemap" style="width: 100px; height: auto;">
                            </td>
                            <td>
                                <a href="?delete_id=<?php echo htmlspecialchars($gempa['id']); ?>" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center">Tidak ada data gempa yang tersedia.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
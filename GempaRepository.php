<?php

include_once 'IGempaRepository.php';

class GempaRepository implements IGempaRepository {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn; // Koneksi database
    }

    public function createGempa(float $magnitude, string $lokasi, string $waktu, ?string $shakemap): bool {
        // Validasi data
        if (!is_numeric($magnitude) || empty($lokasi) || empty($waktu)) {
            error_log("Data tidak valid: " . json_encode(compact('magnitude', 'lokasi', 'waktu', 'shakemap')));
            return false;
        }
    
        $stmt = $this->conn->prepare("INSERT INTO gempa (magnitude, lokasi, waktu, shakemap) VALUES (?, ?, ?, ?)");
        if ($stmt === false) {
            error_log("Prepare failed: " . $this->conn->error);
            return false;
        }
        // Ubah 'f' menjadi 'd' untuk double
        $stmt->bind_param("dsss", $magnitude, $lokasi, $waktu, $shakemap);
        if (!$stmt->execute()) {
            error_log("Execute failed: " . $stmt->error);
            return false;
        }
        $stmt->close(); // Menutup statement
        return true;
    }
    public function readGempa(): array {
        $result = $this->conn->query("SELECT * FROM gempa");
        if ($result === false) {
            error_log("Query failed: " . $this->conn->error);
            return []; // Kembalikan array kosong jika query gagal
        }
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function updateGempa(int $id, float $magnitude, string $lokasi, string $waktu, ?string $shakemap) {
        $stmt = $this->conn->prepare("UPDATE gempa SET magnitude = ?, lokasi = ?, waktu = ?, shakemap = ? WHERE id = ?");
        if ($stmt === false) {
            error_log("Prepare failed: " . $this->conn->error);
            return false;
        }
        // Ubah 'f' menjadi 'd' untuk double
        $stmt->bind_param("dsssi", $magnitude, $lokasi, $waktu, $shakemap, $id);
        if (!$stmt->execute()) {
            error_log("Execute failed: " . $stmt->error);
            return false;
        }
        $stmt->close(); // Menutup statement
        return true;
    }
    public function deleteGempa(int $id): bool {
        $stmt = $this->conn->prepare("DELETE FROM gempa WHERE id = ?");
        if ($stmt === false) {
            error_log("Prepare failed: " . $this->conn->error);
            return false;
        }
        $stmt->bind_param("i", $id);
        if (!$stmt->execute()) {
            error_log("Execute failed: " . $stmt->error);
            return false;
        }
        $stmt->close(); // Menutup statement
        return true;
    }
}
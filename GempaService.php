<?php

include_once 'IGempaService.php'; // Memuat antarmuka IGempaService
include_once 'IGempaRepository.php'; // Memuat antarmuka IGempaRepository
include_once 'IBMKGService.php'; // Memuat antarmuka IBMKGService

class GempaService implements IGempaService {
    private $bmkgService;
    private $repository;

    public function __construct(IBMKGService $bmkgService, IGempaRepository $repository) {
        $this->bmkgService = $bmkgService; // Bergantung pada IBMKGService
        $this->repository = $repository;   // Bergantung pada IGempaRepository
    }

    /**
     * Memperbarui data gempa dari BMKG dan menyimpannya ke database.
     *
     * @return void
     */
    public function updateData(): void {
        try {
            $dataGempa = $this->bmkgService->fetchData(); // Ambil data dari BMKGService
            foreach ($dataGempa as $gempa) {
                // Validasi data sebelum menyimpan
                if (!empty($gempa['magnitude']) && !empty($gempa['lokasi']) && !empty($gempa['waktu'])) {
                    if (!$this->repository->createGempa($gempa['magnitude'], $gempa['lokasi'], $gempa['waktu'], $gempa['shakemap'])) {
                        error_log("Gagal menyimpan data gempa: " . json_encode($gempa));
                    }
                } else {
                    error_log("Data gempa tidak valid: " . json_encode($gempa));
                }
            }
        } catch (Exception $e) {
            error_log("Error updating data: " . $e->getMessage());
        }
    }

    /**
     * Mengambil semua data gempa dari database.
     *
     * @return array
     */
    public function getAllData(): array {
        return $this->repository->readGempa(); // Ambil semua data gempa dari database
    }
}
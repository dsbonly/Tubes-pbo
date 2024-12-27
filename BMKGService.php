<?php

include_once 'IBMKGService.php'; // Memuat antarmuka IBMKGService
include_once 'IGempaRepository.php'; // Memuat antarmuka IGempaRepository

class BMKGService implements IBMKGService {
    private $bmkgApi;
    private $repository;

    public function __construct(IBMKGService $bmkgApi, IGempaRepository $repository) {
        $this->bmkgApi = $bmkgApi; // Bergantung pada IBMKGService
        $this->repository = $repository; // Bergantung pada IGempaRepository
    }

    public function fetchData(): array {
        return $this->bmkgApi->fetchData(); // Mengambil data dari API BMKG
    }
}
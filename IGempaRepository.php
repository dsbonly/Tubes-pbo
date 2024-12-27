<?php

interface IGempaRepository {
    /**
     * Menyimpan data gempa ke dalam database.
     *
     * @param float $magnitude Magnitudo gempa.
     * @param string $lokasi Lokasi gempa.
     * @param string $waktu Waktu terjadinya gempa.
     * @param string|null $shakemap Nama file shakemap (jika ada).
     * @return bool True jika penyimpanan berhasil, false jika gagal.
     */
    public function createGempa(float $magnitude, string $lokasi, string $waktu, ?string $shakemap): bool;

    /**
     * Mengambil semua data gempa dari database.
     *
     * @return array Array yang berisi data gempa.
     */
    public function readGempa(): array;

    /**
     * Menghapus data gempa berdasarkan ID.
     *
     * @param int $id ID gempa yang akan dihapus.
     * @return bool True jika penghapusan berhasil, false jika gagal.
     */
    public function deleteGempa(int $id): bool;
}
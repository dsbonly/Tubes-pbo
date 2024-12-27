<?php

interface IGempaService {
    /**
     * Memperbarui data gempa dari BMKG dan menyimpannya ke database.
     *
     * @return void
     */
    public function updateData(): void;

    /**
     * Mengambil semua data gempa dari database.
     *
     * @return array
     */
    public function getAllData(): array;
}
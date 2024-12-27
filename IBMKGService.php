<?php

interface IBMKGService {
    /**
     * Mengambil data gempa dari API BMKG.
     *
     * @return array Data gempa yang diambil dari API.
     */
    public function fetchData(): array;
}
<?php

include_once 'IBMKGService.php'; // Memuat antarmuka IBMKGService

class BMKGApi implements IBMKGService {
    public function fetchData(): array {
        $url = 'https://data.bmkg.go.id/DataMKG/TEWS/autogempa.xml';
        $xml = simplexml_load_file($url);

        if ($xml === false) {
            return []; // Kembalikan array kosong jika gagal mengambil data
        }

        $data = [];
        if (isset($xml->gempa)) {
            foreach ($xml->gempa as $gempa) {
                $data[] = [
                    'magnitude' => (float)$gempa->Magnitude,
                    'lokasi' => (string)$gempa->Wilayah,
                    'waktu' => (string)$gempa->DateTime,
                    'shakemap' => (string)$gempa->Shakemap,
                ];
            }
        }

        return $data; // Kembalikan data yang diambil
    }
}
<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Ambil IP address asli pengguna dengan aman.
 * - Mengutamakan IP dari proxy (Cloudflare, Nginx, dll)
 * - Mengubah "::1" jadi "127.0.0.1" agar konsisten
 * - Melindungi dari spoofing header
 *
 * @return string IP address
 */
if (!function_exists('get_real_ip')) {
    function get_real_ip()
    {
        $ip = '';

        // Urutan pengecekan IP berdasarkan prioritas
        $headers_to_check = [
            'HTTP_CF_CONNECTING_IP',   // Cloudflare
            'HTTP_X_REAL_IP',          // Nginx / Load Balancer
            'HTTP_X_FORWARDED_FOR',    // Proxy chain
            'REMOTE_ADDR'              // Default PHP
        ];

        foreach ($headers_to_check as $header) {
            if (!empty($_SERVER[$header])) {
                $ip = $_SERVER[$header];
                break;
            }
        }

        // Jika ada daftar IP (kadang di X_FORWARDED_FOR), ambil yang pertama
        if (strpos($ip, ',') !== false) {
            $ip = explode(',', $ip)[0];
        }

        // Ubah "::1" menjadi IPv4 untuk konsistensi lokal
        if ($ip === '::1' || $ip === '0:0:0:0:0:0:0:1') {
            $ip = '127.0.0.1';
        }

        // Validasi IP supaya tidak spoofing
        if (!filter_var($ip, FILTER_VALIDATE_IP)) {
            $ip = 'UNKNOWN';
        }

        return $ip;
    }
}

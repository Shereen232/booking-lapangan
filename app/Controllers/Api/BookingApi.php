<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
class BookingApi extends BaseController
{
    public function cekJamKosong($tanggal)
    {
        $bookingModel = new \App\Models\PemesananModel();

        // Ambil semua booking di tanggal tertentu
        $bookings = $bookingModel->getBookingByDate($tanggal);

        // Waktu operasional lapangan
        $jamBuka = '07:00:00';
        $jamTutup = '22:00:00';

        // Buat semua slot 1 jam
        $semuaSlot = [];
        $start = new \DateTime($jamBuka);
        $end = new \DateTime($jamTutup);

        while ($start < $end) {
            $mulai = $start->format('H:i:s');
            $start->modify('+1 hour'); // Ganti ke '+30 minutes' jika ingin slot 30 menit
            $selesai = $start->format('H:i:s');
            $semuaSlot[] = [
                'jam_mulai' => $mulai,
                'jam_selesai' => $selesai
            ];
        }

        // Format data booking jadi array untuk pengecekan bentrok
        $bookedSlot = [];
        foreach ($bookings as $b) {
            $bookedSlot[] = [
                'start' => $b['jam_mulai'],
                'end'   => $b['jam_selesai']
            ];
        }

        // Cek slot mana yang tidak bentrok
        $available = [];
        foreach ($semuaSlot as $slot) {
            $slotStart = $slot['jam_mulai'];
            $slotEnd   = $slot['jam_selesai'];

            $isAvailable = true;

            foreach ($bookedSlot as $booked) {
                // Cek overlap
                if (
                    ($slotStart < $booked['end']) &&
                    ($slotEnd > $booked['start'])
                ) {
                    $isAvailable = false;
                    break;
                }
            }

            if ($isAvailable) {
                $available[] = $slotStart . ' - ' . $slotEnd;
            }
        }

        return $this->response->setJSON([
            'tanggal' => $tanggal,
            'available_slots' => $available
        ]);
    }

}

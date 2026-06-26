<?php

namespace App\Traits;

use App\Models\Booking;

trait ExportWordReport
{
    public function generateWordReport(Booking $booking)
    {
        $booking->load(['customer', 'terapis', 'service', 'location', 'therapyReport']);

        $phpWord = new \PhpOffice\PhpWord\PhpWord();
        $section = $phpWord->addSection([
            'marginTop' => 600,
            'marginBottom' => 600,
            'marginLeft' => 800,
            'marginRight' => 800,
        ]);

        $report = $booking->therapyReport;
        $patientName = $booking->booking_for === 'other' ? ($booking->second_username ?? '-') : ($booking->customer->username ?? '-');
        $patientGender = $booking->booking_for === 'other' ? ($booking->gender_second ?? '-') : ($booking->customer->gender ?? '-');

        // Styles
        $headerStyle = ['bold' => true, 'size' => 11, 'color' => '105D33'];
        $labelStyle = ['color' => '666666', 'size' => 10];
        $valueStyle = ['color' => '000000', 'size' => 10, 'bold' => true];
        $textStyle = ['size' => 10];
        
        $boxStyle = ['borderSize' => 6, 'borderColor' => 'E5E7EB', 'cellMargin' => 150];
        $layoutTableStyle = ['cellMargin' => 0];

        $phpWord->addTableStyle('BoxTable', $boxStyle);
        $phpWord->addTableStyle('LayoutTable', $layoutTableStyle);

        // HEADER / TITLE (Logo on left)
        $headerTable = $section->addTable('LayoutTable');
        $headerTable->addRow();
        
        $logoPath = public_path('image/logo_salam_insani.png');
        if (file_exists($logoPath)) {
            $cellLogo = $headerTable->addCell(2000, ['valign' => 'center']);
            $cellLogo->addImage($logoPath, [
                'width' => 100,
                'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER
            ]);
            $cellTitle = $headerTable->addCell(8000, ['valign' => 'center']);
        } else {
            $cellTitle = $headerTable->addCell(10000, ['valign' => 'center']);
        }
        
        $cellTitle->addText('LAPORAN HASIL TERAPI', ['bold' => true, 'size' => 16, 'color' => '105D33'], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $cellTitle->addText('RUMAH SEHAT SALAM INSANI', ['bold' => true, 'size' => 14, 'color' => '105D33'], ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
        $section->addTextBreak(2);

        // 1. INFORMASI PASIEN
        $tableInfo = $section->addTable('BoxTable');
        $tableInfo->addRow();
        $tableInfo->addCell(10000, ['gridSpan' => 2])->addText('👤 INFORMASI PASIEN', $headerStyle);
        
        $tableInfo->addRow();
        $cellInfoLeft = $tableInfo->addCell(5000, ['borderRightSize' => 6, 'borderRightColor' => 'E5E7EB']);
        $innerLeft = $cellInfoLeft->addTable();
        $innerLeft->addRow();
        $innerLeft->addCell(1500)->addText('Nama Pasien', $labelStyle);
        $innerLeft->addCell(3500)->addText(': ' . $patientName, $valueStyle);
        $innerLeft->addRow();
        $innerLeft->addCell(1500)->addText('Jenis Kelamin', $labelStyle);
        $innerLeft->addCell(3500)->addText(': ' . ucfirst($patientGender), $valueStyle);
        $innerLeft->addRow();
        $innerLeft->addCell(1500)->addText('No. HP', $labelStyle);
        $innerLeft->addCell(3500)->addText(': ' . ($booking->customer->no_telepon ?? '-'), $valueStyle);

        $cellInfoRight = $tableInfo->addCell(5000);
        $innerRight = $cellInfoRight->addTable();
        $innerRight->addRow();
        $innerRight->addCell(1800)->addText('Tanggal Terapi', $labelStyle);
        $innerRight->addCell(3200)->addText(': ' . ($booking->date_booking ? $booking->date_booking->format('d F Y') : '-'), $valueStyle);
        $innerRight->addRow();
        $innerRight->addCell(1800)->addText('Terapis', $labelStyle);
        $innerRight->addCell(3200)->addText(': ' . ($booking->terapis->username ?? '-'), $valueStyle);
        $innerRight->addRow();
        $innerRight->addCell(1800)->addText('Jenis Layanan', $labelStyle);
        $innerRight->addCell(3200)->addText(': ' . ($booking->service->name_service ?? '-'), $valueStyle);

        $section->addTextBreak(1, ['size' => 5]);

        // Helper function for multiline text
        $addMultilineText = function($cell, $text, $style) {
            $lines = explode("\n", $text);
            foreach ($lines as $line) {
                if (trim($line) !== '') {
                    $cell->addText(trim($line), $style);
                }
            }
        };

        // 2. KELUHAN & TINDAKAN
        $grid1 = $section->addTable('LayoutTable');
        $grid1->addRow();
        
        $cellKeluhan = $grid1->addCell(4900);
        $boxKeluhan = $cellKeluhan->addTable('BoxTable');
        $boxKeluhan->addRow();
        $boxKeluhan->addCell(4900)->addText('💬 KELUHAN PASIEN SEBELUM TERAPI', $headerStyle);
        $boxKeluhan->addRow();
        $keluhanCell = $boxKeluhan->addCell(4900);
        $addMultilineText($keluhanCell, $report->keluhan_sebelum ?? ($booking->keluhan ?? '-'), $textStyle);

        $grid1->addCell(200);

        $cellTindakan = $grid1->addCell(4900);
        $boxTindakan = $cellTindakan->addTable('BoxTable');
        $boxTindakan->addRow();
        $boxTindakan->addCell(4900)->addText('📋 TINDAKAN TERAPI', $headerStyle);
        $boxTindakan->addRow();
        $tindakanCell = $boxTindakan->addCell(4900);
        $tindakanText = $report ? (str_replace('"', '', json_decode($report->tindakan_terapi) ?: $report->tindakan_terapi)) : '-';
        $addMultilineText($tindakanCell, $tindakanText, $textStyle);

        $section->addTextBreak(1, ['size' => 5]);

        // 3. HASIL PEMERIKSAAN AWAL & CATATAN TERAPIS
        $grid2 = $section->addTable('LayoutTable');
        $grid2->addRow();

        $cellAwal = $grid2->addCell(4900);
        $boxAwal = $cellAwal->addTable('BoxTable');
        $boxAwal->addRow();
        $boxAwal->addCell(4900)->addText('📈 HASIL PEMERIKSAAN AWAL', $headerStyle);
        $boxAwal->addRow();
        $awalTableCell = $boxAwal->addCell(4900);
        $awalTable = $awalTableCell->addTable(['cellMargin' => 50]);
        
        $addPemeriksaan = function($label, $val) use ($awalTable, $labelStyle, $valueStyle) {
            $awalTable->addRow();
            $awalTable->addCell(2000)->addText($label, $labelStyle);
            $awalTable->addCell(2900)->addText($val, $valueStyle);
        };
        $addPemeriksaan('Tekanan Darah', $report->tekanan_darah ?? '-');
        $addPemeriksaan('Suhu Tubuh', $report->suhu_tubuh ?? '-');
        $addPemeriksaan('Kondisi Umum', $report->kondisi_umum ?? '-');
        $addPemeriksaan('Area Keluhan', $report->area_keluhan ?? '-');

        $grid2->addCell(200);

        $cellCatatan = $grid2->addCell(4900);
        $boxCatatan = $cellCatatan->addTable('BoxTable');
        $boxCatatan->addRow();
        $boxCatatan->addCell(4900)->addText('📝 CATATAN TERAPIS', $headerStyle);
        $boxCatatan->addRow();
        $catatanCell = $boxCatatan->addCell(4900);
        $addMultilineText($catatanCell, $report->catatan_terapis ?? '-', $textStyle);

        $section->addTextBreak(1, ['size' => 5]);

        // 4. HASIL SETELAH TERAPI
        $boxHasil = $section->addTable('BoxTable');
        $boxHasil->addRow();
        $boxHasil->addCell(10000)->addText('📊 HASIL SETELAH TERAPI', $headerStyle);
        $boxHasil->addRow();
        $hasilCell = $boxHasil->addCell(10000);
        $hasilText = $report ? (str_replace('"', '', json_decode($report->hasil_setelah_terapi) ?: $report->hasil_setelah_terapi)) : '-';
        $addMultilineText($hasilCell, $hasilText, $textStyle);

        $section->addTextBreak(1, ['size' => 5]);

        // 5. SARAN TERAPIS & STATUS TERAPI
        $grid3 = $section->addTable('LayoutTable');
        $grid3->addRow();

        $cellSaran = $grid3->addCell(4900);
        $boxSaran = $cellSaran->addTable('BoxTable');
        $boxSaran->addRow();
        $boxSaran->addCell(4900)->addText('💡 SARAN TERAPIS', $headerStyle);
        $boxSaran->addRow();
        $saranCell = $boxSaran->addCell(4900);
        $addMultilineText($saranCell, $report->saran_terapis ?? '-', $textStyle);

        $grid3->addCell(200);

        $cellStatus = $grid3->addCell(4900);
        $boxStatus = $cellStatus->addTable('BoxTable');
        $boxStatus->addRow();
        $boxStatus->addCell(4900)->addText('✅ STATUS TERAPI', $headerStyle);
        $boxStatus->addRow();
        $statusCell = $boxStatus->addCell(4900);
        $statusCell->addText('TERAPI SELESAI', ['bold' => true, 'color' => '105D33', 'size' => 12], ['alignment' => 'center']);
        $statusCell->addTextBreak(1, ['size' => 5]);
        $statusInner = $statusCell->addTable(['cellMargin' => 0]);
        $statusInner->addRow();
        $statusInner->addCell(1500)->addText('Tanggal', $labelStyle);
        $statusInner->addCell(3400)->addText(': ' . ($booking->date_booking ? $booking->date_booking->format('d F Y') : '-'), $valueStyle);
        $statusInner->addRow();
        $statusInner->addCell(1500)->addText('Jam Selesai', $labelStyle);
        $statusInner->addCell(3400)->addText(': ' . ($booking->time_booking ? \Carbon\Carbon::parse($booking->time_booking)->format('H:i') . ' WIB' : '-'), $valueStyle);

        $section->addTextBreak(2);

        // 6. TANDA TANGAN
        $sigTable = $section->addTable('LayoutTable');
        $sigTable->addRow();
        
        $sigLeft = $sigTable->addCell(5000, ['borderRightSize' => 6, 'borderRightColor' => 'E5E7EB']);
        $sigLeft->addText('Terapis', $labelStyle, ['alignment' => 'center']);
        $sigLeft->addTextBreak(3);
        $sigLeft->addText($booking->terapis->username ?? '-', ['bold' => true, 'underline' => 'single', 'size' => 11], ['alignment' => 'center']);
        $sigLeft->addText('(Terapis)', $labelStyle, ['alignment' => 'center']);

        $sigRight = $sigTable->addCell(5000);
        $sigRight->addText('Pasien', $labelStyle, ['alignment' => 'center']);
        $sigRight->addTextBreak(3);
        $sigRight->addText($patientName, ['bold' => true, 'underline' => 'single', 'size' => 11], ['alignment' => 'center']);
        $sigRight->addText('(Pasien)', $labelStyle, ['alignment' => 'center']);

        $section->addTextBreak(2);

        // 7. FOOTER
        $section->addText('Terima kasih telah mempercayakan kesehatan Anda kepada kami.', ['italic' => true, 'size' => 9, 'color' => '666666'], ['alignment' => 'center']);
        $section->addText('Semoga Allah SWT memberikan kesembuhan dan kesehatan yang berkah.', ['italic' => true, 'size' => 9, 'color' => '666666'], ['alignment' => 'center']);

        $fileName = 'Laporan_Terapi_' . str_replace(' ', '_', $patientName) . '_' . $booking->id . '.docx';
        $tempFile = storage_path('app/public/' . $fileName);
        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save($tempFile);

        return response()->download($tempFile)->deleteFileAfterSend(true);
    }
}

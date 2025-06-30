<?php
namespace App\Http\Controllers\App\artiekeles;

use App\Helpers\AuthHelper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Artiekeles;

class FileController extends Controller
{
    public function uploadFile(Request $request)
    {
        if (!AuthHelper::check()) {
            return redirect()->route('artieses')->with('alert', 'Harus login dulu.');
        }
        function generateUniqueCodekeles($length = 20) {
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            do {
                $randomString = '';
                for ($i = 0; $i < $length; $i++) {
                    $randomString .= $characters[random_int(0, strlen($characters) - 1)];
                }
            } while (Artiekeles::where('codekeles', $randomString)->exists());
        
            return $randomString;
        }
        $randomString = generateUniqueCodekeles();
        
        $judul = $request->input('judul');
        $kseo = $request->input('kseo');
        $lseo = $request->input('lseo');
        $request->validate([
            'file' => 'required|file|mimes:txt,pdf,docx'
        ]);
        $file = $request->file('file');
        $path = $file->storeAs('uploads', $file->getClientOriginalName());
        $extension = $file->getClientOriginalExtension();
        $text = '';
        $filePath = storage_path('app/private/' . $path);
        if ($extension == 'docx') {
            $text = $this->convertDocxToText($filePath, $randomString);
        } elseif ($extension == 'pdf') {
            // $text = $this->convertPdfToText($filePath, $randomString);
        } elseif ($extension == 'txt') {
            $text = file_get_contents($filePath, $randomString);
        }
        if (file_exists($filePath)) {
            unlink($filePath);
        }
        
        
        Artiekeles::create([
            'userid' => session('userid'),
            'codekeles' => $randomString,
            'judul' => $judul,
            'lseo' => $lseo,
            'kseo' => $kseo,
            'konten' => $text,
        ]);
        
        return redirect()->route('artieses')->with(['alert' => 'Artiekeles mu sudah di publish!']);
    }

    protected function convertDocxToText($filePath, $randomString)
    {
        $username = session('username');
        $sofficePath = base_path('vendor/LibreOffice/program/soffice.exe');
        $outputDir = public_path("{$username}/artiekeles/{$randomString}");

        if (!file_exists($outputDir)) {
            mkdir($outputDir, 0755, true); // buat folder kalau belum ada
        }

        $fileName = pathinfo($filePath, PATHINFO_FILENAME);
        $outputHtmlPath = $outputDir . '/' . $fileName . '.html';

        $command = "$sofficePath --headless --convert-to html --outdir " . escapeshellarg($outputDir) . ' ' . escapeshellarg($filePath);
        shell_exec($command);

        $output = file_get_contents($outputHtmlPath);
        $output = preg_replace('/<p([^>]*)align="center"([^>]*)>/i', '<p$1style="text-align:center;"$2>', $output);

        $updatedOutput = preg_replace_callback('/<img\s+[^>]*src="([^"]+)"[^>]*>/i', function ($matches) use ($username, $randomString) {
            $src = $matches[1];

            if (strpos($src, "{$username}/artiekeles/{$randomString}") === false) {
                $newSrc = "{$username}/artiekeles/{$randomString}" . $src;
                return str_replace($src, $newSrc, $matches[0]);
            }
            return $matches[0];
        }, $output);

        return $updatedOutput; // hanya return teks biasa
    }

    
//     protected function convertPdfToText($filePath)
// {
//     $pdftotextPath = base_path('vendor/xpdf-tools-win-4.05/bin64/pdftotext.exe'); 
//     $escapedFilePath = escapeshellarg($filePath);
//     $command = "\"$pdftotextPath\" $escapedFilePath -"; 
//     $output = shell_exec($command);
//     return $output ?: 'Gagal mengekstrak teks.';
// }


}

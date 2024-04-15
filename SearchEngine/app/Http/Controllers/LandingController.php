<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class LandingController extends Controller
{

    public function getKecamatan(Request $request)
    {
        $kabupaten = $request->input('city');
        $jsonFile = public_path('jatim.json');
        if (!file_exists($jsonFile)) {
            return response()->json(['error' => 'File not found'], 404);
        }
        // kecamatan unik
        $kecamatans = [];
        
        if ($file = fopen($jsonFile, "r")) {
            while (!feof($file)) {
                $jsonLine = trim(fgets($file));
                // echo $jsonLine;
                if (!empty($jsonLine)) {
                    $data = json_decode($jsonLine, true);
                    // var_dump($data);
                    if ($data && isset($data['kabupaten_kota']) && $data['kabupaten_kota'] === $kabupaten && isset($data['kecamatan'])) {
                        if (!in_array($data['kecamatan'], $kecamatans)) {
                            $kecamatans[] = $data['kecamatan'];
                        }
                    }
                }
            }
            fclose($file);
        }
        sort($kecamatans);
        // var_dump($kecamatans);
        return response()->json($kecamatans);
    }
    
    
    public function search(Request $request)
    {
        $query = $request->input('q');
        $rank = $request->input('rank');
        $place = $request->input('place');
        $kecamatan = $request->input('kecamatan');
        // $bentuk = $request->input('bentuk');

        $process = new Process(['python',"query.py", "jatim_id", $rank, $query, $place, $kecamatan], null, ['SYSTEMROOT' => getenv('SYSTEMROOT'), 'PATH' => getenv("PATH")]);
        $process->run();
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }
        $list_data = array_filter(explode("\n",$process->getOutput()));
        $data = [];
        if (empty($list_data)) {
            $data = [
                'message' => 'Tidak ada data'
            ];
            return response()->json($data, JsonResponse::HTTP_NOT_FOUND);
        } else {
            foreach ($list_data as $sekolah) {
                $data_json =  json_decode($sekolah, true);
                $status = "";
                if ($data_json['status'] == "N") {
                    $status = "Negeri";
                } else {
                    $status = "Swasta";
                }
                $data[] = [
                    'sekolah' => $data_json['sekolah'],
                    'alamat_jalan' => $data_json['alamat_jalan'],
                    'kabupaten_kota' => $data_json['kabupaten_kota'],
                    'kecamatan' => $data_json['kecamatan'],
                    'npsn' => $data_json['npsn'],
                    'bentuk' => $data_json['bentuk'],
                    'status' => $status,
                    'lintang' => $data_json['lintang'],
                    'bujur' => $data_json['bujur']
                ];
            }
            return response()->json($data);
        }
    }
}

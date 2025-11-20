<?php
$nilai = [
    ["nama" => "Andi", "mapel" => "Matematika", "nilai" => 80],
    ["nama" => "Budi", "mapel" => "Matematika", "nilai" => 60],
    ["nama" => "Citra", "mapel" => "Matematika", "nilai" => 90],
    ["nama" => "Andi", "mapel" => "Bahasa", "nilai" => 70],
    ["nama" => "Budi", "mapel" => "Bahasa", "nilai" => 75],
    ["nama" => "Citra", "mapel" => "Bahasa", "nilai" => 85],
];

function huruf($nilai)
{
    if ($nilai >= 85) {
        return "A";
    } elseif ($nilai >= 70) {
        return "B";
    } elseif ($nilai >= 60) {
        return "C";
    } else {
        return "D";
    }
}

// Konversi nilai ke huruf: 
// 85–100 = A 
// 70–84 = B 
// 60–69 = C 
// <60 = D 
// Pertanyaan: 
// 1. Hitunglah rata-rata nilai setiap siswa, lalu tentukan nilai hurufnya masing-masing. 
$averages = [];
foreach ($nilai as $entry) {
    $averages[$entry['nama']]['total'] = ($averages[$entry['nama']]['total'] ?? 0) + $entry['nilai'];
    $averages[$entry['nama']]['count'] = ($averages[$entry['nama']]['count'] ?? 0) + 1;
}
foreach ($averages as $nama => $data) {
    $averages[$nama] = $data['total'] / $data['count'];
}
echo json_encode(array_map(fn($avg) => ['average' => $avg, 'grade' => huruf($avg)], $averages));
//  2. Ubah data nilai tersebut ke bentuk pivot seperti berikut: 
//

$pivot = [];

foreach ($nilai as $entry) {
    $pivot[$entry['nama']][$entry['mapel']] = $entry['nilai'];
}
echo "\n";
echo json_encode($pivot);


// 3. Dari nilai Matematika, sebutkan nama siswa yang nilainya bukan terbaik maupun 
// terburuk (nilai tengah). 
//  hitung mean nilai matematika
$mathScores = array_filter($nilai, fn($entry) => $entry['mapel'] === 'Matematika');
$mathValues = array_column($mathScores, 'nilai');
sort($mathValues);
$meanIndex = floor(count($mathValues) / 2);
$meanValue = $mathValues[$meanIndex];
$middleStudents = [];
$middleScores = [];
foreach ($mathScores as $entry) {
    if ($entry['nilai'] === $meanValue) {
        $middleStudents[] = $entry['nama'];
        $middleScores[] = $entry['nilai'];
    }
}
echo "\n";
echo implode(", ", $middleStudents) . " (Nilai: " . implode(", ", $middleScores) . ")";

// 4. Hitung jumlah siswa yang mendapatkan nilai A, B, C, dan D untuk setiap mapel. 
$gradeCounts = [];
foreach ($nilai as $entry) {
    $grade = huruf($entry['nilai']);
    $gradeCounts[$entry['mapel']][$grade] = ($gradeCounts[$entry['mapel']][$grade] ?? 0) + 1;
}
echo "\n";
echo json_encode($gradeCounts);
// 5. Hitung rata-rata nilai tiap mapel, lalu konversi hasil rata-rata tersebut ke dalam bentuk 
// huruf.
$subjectAverages = [];
$subjectCounts = [];
foreach ($nilai as $entry) {
    $subjectAverages[$entry['mapel']] = ($subjectAverages[$entry['mapel']] ?? 0) + $entry['nilai'];
    $subjectCounts[$entry['mapel']] = ($subjectCounts[$entry['mapel']] ?? 0) + 1;
}
foreach ($subjectAverages as $mapel => $total) {
    $avg = $total / $subjectCounts[$mapel];
    $subjectAverages[$mapel] = [
        'average' => $avg,
        'grade' => huruf($avg)
    ];
}
echo "\n";
echo json_encode($subjectAverages);
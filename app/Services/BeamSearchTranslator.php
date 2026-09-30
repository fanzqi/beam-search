<?php

namespace App\Services;

class BeamSearchTranslator
{
    /**
     * Kamus kandidat terjemahan.
     *
     * Setiap kata mempunyai beberapa kandidat
     * dengan probabilitas masing-masing.
     */
    private array $dictionary = [

        'saya' => [
            ['word' => 'i', 'probability' => 0.95],
            ['word' => 'me', 'probability' => 0.04],
            ['word' => 'myself', 'probability' => 0.01],
        ],

        'aku' => [
            ['word' => 'i', 'probability' => 0.96],
            ['word' => 'me', 'probability' => 0.03],
            ['word' => 'myself', 'probability' => 0.01],
        ],

        'ingin' => [
            ['word' => 'want', 'probability' => 0.90],
            ['word' => 'would', 'probability' => 0.06],
            ['word' => 'wish', 'probability' => 0.04],
        ],

        'mau' => [
            ['word' => 'want', 'probability' => 0.88],
            ['word' => 'would', 'probability' => 0.07],
            ['word' => 'wish', 'probability' => 0.05],
        ],

        'belajar' => [
            ['word' => 'learn', 'probability' => 0.80],
            ['word' => 'study', 'probability' => 0.17],
            ['word' => 'learning', 'probability' => 0.03],
        ],

        'pemrograman' => [
            ['word' => 'programming', 'probability' => 0.94],
            ['word' => 'coding', 'probability' => 0.05],
            ['word' => 'program', 'probability' => 0.01],
        ],

        'bahasa' => [
            ['word' => 'language', 'probability' => 0.95],
            ['word' => 'languages', 'probability' => 0.04],
            ['word' => 'tongue', 'probability' => 0.01],
        ],

        'inggris' => [
            ['word' => 'english', 'probability' => 0.98],
            ['word' => 'england', 'probability' => 0.02],
        ],

        'suka' => [
            ['word' => 'like', 'probability' => 0.90],
            ['word' => 'love', 'probability' => 0.08],
            ['word' => 'enjoy', 'probability' => 0.02],
        ],

        'makan' => [
            ['word' => 'eat', 'probability' => 0.90],
            ['word' => 'eating', 'probability' => 0.08],
            ['word' => 'consume', 'probability' => 0.02],
        ],

        'nasi' => [
            ['word' => 'rice', 'probability' => 0.98],
            ['word' => 'meal', 'probability' => 0.02],
        ],

        'setiap' => [
            ['word' => 'every', 'probability' => 0.80],
            ['word' => 'each', 'probability' => 0.20],
        ],

        'hari' => [
            ['word' => 'day', 'probability' => 0.95],
            ['word' => 'daily', 'probability' => 0.05],
        ],

        'di' => [
            ['word' => 'in', 'probability' => 0.50],
            ['word' => 'at', 'probability' => 0.30],
            ['word' => 'on', 'probability' => 0.20],
        ],

        'kampus' => [
            ['word' => 'campus', 'probability' => 0.95],
            ['word' => 'university', 'probability' => 0.05],
        ],

        'universitas' => [
            ['word' => 'university', 'probability' => 0.90],
            ['word' => 'college', 'probability' => 0.10],
        ],

        'mahasiswa' => [
            ['word' => 'student', 'probability' => 0.95],
            ['word' => 'students', 'probability' => 0.05],
        ],

        'adalah' => [
            ['word' => 'is', 'probability' => 0.80],
            ['word' => 'are', 'probability' => 0.20],
        ],

        'sebuah' => [
            ['word' => 'a', 'probability' => 0.90],
            ['word' => 'an', 'probability' => 0.10],
        ],

        'sistem' => [
            ['word' => 'system', 'probability' => 0.96],
            ['word' => 'systems', 'probability' => 0.04],
        ],

        'informasi' => [
            ['word' => 'information', 'probability' => 0.95],
            ['word' => 'data', 'probability' => 0.05],
        ],

        'teknologi' => [
            ['word' => 'technology', 'probability' => 0.97],
            ['word' => 'technologies', 'probability' => 0.03],
        ],

        'dan' => [
            ['word' => 'and', 'probability' => 0.99],
            ['word' => 'also', 'probability' => 0.01],
        ],

        'untuk' => [
            ['word' => 'to', 'probability' => 0.85],
            ['word' => 'for', 'probability' => 0.15],
        ],

        'membuat' => [
            ['word' => 'make', 'probability' => 0.70],
            ['word' => 'create', 'probability' => 0.25],
            ['word' => 'build', 'probability' => 0.05],
        ],

        'aplikasi' => [
            ['word' => 'application', 'probability' => 0.60],
            ['word' => 'app', 'probability' => 0.25],
            ['word' => 'software', 'probability' => 0.15],
        ],

        'web' => [
            ['word' => 'web', 'probability' => 0.90],
            ['word' => 'website', 'probability' => 0.10],
        ],

        'sangat' => [
            ['word' => 'very', 'probability' => 0.95],
            ['word' => 'highly', 'probability' => 0.05],
        ],

        'baik' => [
            ['word' => 'good', 'probability' => 0.85],
            ['word' => 'well', 'probability' => 0.15],
        ],

        'ini' => [
            ['word' => 'this', 'probability' => 0.95],
            ['word' => 'these', 'probability' => 0.05],
        ],

        'itu' => [
            ['word' => 'that', 'probability' => 0.95],
            ['word' => 'it', 'probability' => 0.05],
        ],

        'satu' => [
            ['word' => 'one', 'probability' => 0.95],
            ['word' => 'a', 'probability' => 0.05],
        ],

        'dua' => [
            ['word' => 'two', 'probability' => 0.98],
            ['word' => 'second', 'probability' => 0.02],
        ],

        'tiga' => [
            ['word' => 'three', 'probability' => 0.98],
            ['word' => 'third', 'probability' => 0.02],
        ],
    ];

    /**
     * Menerjemahkan kalimat menggunakan Beam Search.
     */
    public function translate(
        string $sentence,
        int $beamWidth = 3
    ): array {

        $tokens = $this->tokenize($sentence);

        if (empty($tokens)) {
            return [
                'result' => '',
                'candidates' => [],
                'steps' => [],
            ];
        }

        /*
         * Beam awal.
         *
         * Setiap beam mempunyai:
         * - sequence
         * - score
         */
        $beams = [
            [
                'sequence' => [],
                'score' => 1.0,
            ]
        ];

        $steps = [];

        /*
         * Proses setiap kata input.
         */
        foreach ($tokens as $index => $token) {

            $candidates = $this->dictionary[$token] ?? [
                [
                    'word' => $token,
                    'probability' => 0.10
                ]
            ];

            $newBeams = [];

            /*
             * Kembangkan setiap beam
             * dengan kandidat kata.
             */
            foreach ($beams as $beam) {

                foreach ($candidates as $candidate) {

                    $newSequence = $beam['sequence'];

                    $newSequence[] = $candidate['word'];

                    $newScore =
                        $beam['score']
                        *
                        $candidate['probability'];

                    $newBeams[] = [
                        'sequence' => $newSequence,
                        'score' => $newScore,
                    ];
                }
            }

            /*
             * Urutkan berdasarkan skor
             * terbesar.
             */
            usort(
                $newBeams,
                function ($a, $b) {
                    return $b['score'] <=> $a['score'];
                }
            );

            /*
             * Pertahankan hanya K beam terbaik.
             */
            $beams = array_slice(
                $newBeams,
                0,
                $beamWidth
            );

            /*
             * Simpan proses untuk ditampilkan
             * pada halaman web.
             */
            $steps[] = [
                'position' => $index + 1,
                'source_word' => $token,
                'beams' => $this->formatBeams($beams),
            ];
        }

        /*
         * Kandidat akhir.
         */
        $finalCandidates = [];

        foreach ($beams as $beam) {

            $finalCandidates[] = [
                'translation' => implode(
                    ' ',
                    $beam['sequence']
                ),

                'score' => $beam['score'],

                'percentage' =>
                    round(
                        $beam['score'] * 100,
                        4
                    ),
            ];
        }

        /*
         * Kandidat pertama adalah
         * kandidat dengan skor tertinggi.
         */
        $result =
            $finalCandidates[0]['translation']
            ?? '';

        return [
            'result' => $result,

            'candidates' => $finalCandidates,

            'steps' => $steps,
        ];
    }

    /**
     * Tokenisasi sederhana.
     */
    private function tokenize(string $sentence): array
    {
        $sentence = strtolower($sentence);

        /*
         * Hilangkan tanda baca.
         */
        $sentence = preg_replace(
            '/[^\p{L}\p{N}\s]/u',
            '',
            $sentence
        );

        /*
         * Pisahkan berdasarkan spasi.
         */
        $tokens = preg_split(
            '/\s+/u',
            trim($sentence)
        );

        return array_values(
            array_filter($tokens)
        );
    }

    /**
     * Format beam untuk ditampilkan.
     */
    private function formatBeams(array $beams): array
    {
        $result = [];

        foreach ($beams as $beam) {

            $result[] = [
                'sequence' => implode(
                    ' ',
                    $beam['sequence']
                ),

                'score' => $beam['score'],

                'percentage' =>
                    round(
                        $beam['score'] * 100,
                        4
                    ),
            ];
        }

        return $result;
    }
}

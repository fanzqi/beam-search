<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Machine Translation - Beam Search</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            background: #f1f5f9;
            color: #1e293b;
        }

        .container {
            width: 92%;
            max-width: 1100px;
            margin: 40px auto;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .header h1 {
            margin-bottom: 10px;
            color: #1d4ed8;
            font-size: 34px;
        }

        .header p {
            color: #64748b;
        }

        .card {
            background: white;
            border-radius: 16px;
            padding: 25px;
            margin-bottom: 25px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.06);
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 8px;
        }

        textarea {
            width: 100%;
            min-height: 140px;
            padding: 15px;
            border: 1px solid #cbd5e1;
            border-radius: 10px;
            font-size: 16px;
            resize: vertical;
        }

        textarea:focus {
            outline: none;
            border-color: #2563eb;
        }

        .form-row {
            display: flex;
            align-items: end;
            gap: 20px;
            margin-top: 20px;
        }

        .beam-control {
            width: 180px;
        }

        input[type="number"] {
            width: 100%;
            padding: 12px;
            border: 1px solid #cbd5e1;
            border-radius: 10px;
            font-size: 16px;
        }

        button {
            padding: 13px 25px;
            border: none;
            border-radius: 10px;
            background: #2563eb;
            color: white;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
        }

        button:hover {
            background: #1d4ed8;
        }

        .result {
            padding: 25px;
            border-radius: 12px;
            background: #eff6ff;
            border: 1px solid #bfdbfe;
        }

        .result h2 {
            color: #1d4ed8;
            margin-top: 0;
        }

        .translation {
            font-size: 28px;
            font-weight: bold;
            color: #111827;
            margin-top: 15px;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
            margin-top: 20px;
        }

        .info {
            padding: 20px;
            background: #f8fafc;
            border-radius: 12px;
            text-align: center;
        }

        .info strong {
            display: block;
            font-size: 26px;
            color: #2563eb;
            margin-bottom: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th,
        td {
            padding: 12px;
            border-bottom: 1px solid #e2e8f0;
            text-align: left;
        }

        th {
            background: #f8fafc;
        }

        .score {
            color: #2563eb;
            font-weight: bold;
        }

        .badge {
            display: inline-block;
            padding: 4px 9px;
            margin-left: 5px;
            border-radius: 20px;
            background: #dbeafe;
            color: #1d4ed8;
            font-size: 12px;
        }

        .step {
            margin-top: 20px;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            overflow: hidden;
        }

        .step-header {
            padding: 15px;
            background: #f8fafc;
            font-weight: bold;
        }

        .step-body {
            padding: 15px;
        }

        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 10px;
            background: #fee2e2;
            color: #991b1b;
        }

        .alert ul {
            margin-bottom: 0;
        }

        @media (max-width: 700px) {
            .form-row {
                flex-direction: column;
                align-items: stretch;
            }

            .beam-control {
                width: 100%;
            }

            .info-grid {
                grid-template-columns: 1fr;
            }

            .translation {
                font-size: 22px;
            }

            table {
                display: block;
                overflow-x: auto;
            }
        }
    </style>
</head>

<body>

<div class="container">

    <div class="header">

        <h1>
            Machine Translation
        </h1>

        <p>
            Penerjemahan Bahasa Indonesia ke Bahasa Inggris
            menggunakan Algoritma Beam Search
        </p>

    </div>


    {{-- ERROR VALIDASI --}}

    @if ($errors->any())

        <div class="alert">

            <strong>Terjadi kesalahan:</strong>

            <ul>

                @foreach ($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

    @endif


    {{-- FORM INPUT --}}

    <div class="card">

        <form
            method="POST"
            action="{{ route('translation.translate') }}"
        >

            @csrf

            <label for="text">
                Kalimat Bahasa Indonesia
            </label>

            <textarea
                id="text"
                name="text"
                placeholder="Contoh: saya ingin belajar pemrograman"
                required
            >{{ old('text', $input ?? '') }}</textarea>


            <div class="form-row">

                <div class="beam-control">

                    <label for="beam_width">
                        Beam Width
                    </label>

                    <input
                        id="beam_width"
                        type="number"
                        name="beam_width"
                        min="1"
                        max="10"
                        value="{{ old('beam_width', $beamWidth ?? 3) }}"
                        required
                    >

                </div>


                <button type="submit">
                    Terjemahkan
                </button>

            </div>

        </form>

    </div>


    {{-- HASIL TERJEMAHAN --}}

    @if (!empty($result))

        <div class="card">

            <div class="result">

                <h2>
                    Hasil Terjemahan
                </h2>

                <div class="translation">
                    {{ $result }}
                </div>

            </div>


            <div class="info-grid">

                <div class="info">

                    <strong>
                        {{ count($candidates ?? []) }}
                    </strong>

                    Kandidat Akhir

                </div>


                <div class="info">

                    <strong>
                        {{ $beamWidth ?? 3 }}
                    </strong>

                    Beam Width

                </div>


                <div class="info">

                    <strong>
                        {{ count($steps ?? []) }}
                    </strong>

                    Langkah

                </div>

            </div>

        </div>


        {{-- KANDIDAT AKHIR --}}

        <div class="card">

            <h2>
                Kandidat Hasil Beam Search
            </h2>

            <p>
                Kandidat diurutkan berdasarkan skor
                probabilitas terbesar.
            </p>


            <table>

                <thead>

                    <tr>

                        <th>
                            Peringkat
                        </th>

                        <th>
                            Terjemahan
                        </th>

                        <th>
                            Score
                        </th>

                        <th>
                            Probabilitas
                        </th>

                    </tr>

                </thead>

                <tbody>

                    @foreach (($candidates ?? []) as $index => $candidate)

                        <tr>

                            <td>

                                {{ $index + 1 }}

                                @if ($index === 0)

                                    <span class="badge">
                                        Terbaik
                                    </span>

                                @endif

                            </td>

                            <td>

                                <strong>
                                    {{ $candidate['translation'] }}
                                </strong>

                            </td>

                            <td class="score">

                                {{ $candidate['score'] }}

                            </td>

                            <td>

                                {{ $candidate['percentage'] }}%

                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        </div>


        {{-- PROSES BEAM SEARCH --}}

        <div class="card">

            <h2>
                Proses Beam Search
            </h2>

            @foreach (($steps ?? []) as $step)

                <div class="step">

                    <div class="step-header">

                        Langkah {{ $step['position'] }}

                        —

                        Kata:

                        <span class="badge">
                            {{ $step['source_word'] }}
                        </span>

                    </div>


                    <div class="step-body">

                        <table>

                            <thead>

                                <tr>

                                    <th>
                                        Kandidat
                                    </th>

                                    <th>
                                        Score
                                    </th>

                                    <th>
                                        Probabilitas
                                    </th>

                                </tr>

                            </thead>

                            <tbody>

                                @foreach (($step['beams'] ?? []) as $beam)

                                    <tr>

                                        <td>
                                            {{ $beam['sequence'] }}
                                        </td>

                                        <td class="score">
                                            {{ $beam['score'] }}
                                        </td>

                                        <td>
                                            {{ $beam['percentage'] }}%
                                        </td>

                                    </tr>

                                @endforeach

                            </tbody>

                        </table>

                    </div>

                </div>

            @endforeach

        </div>

    @endif


    {{-- INFORMASI METODE --}}

    <div class="card">

        <h2>
            Tentang Beam Search
        </h2>

        <p>
            Beam Search adalah algoritma pencarian yang
            mempertahankan sejumlah kandidat terbaik pada
            setiap tahap pembentukan kalimat.
        </p>

        <p>
            Nilai <strong>Beam Width</strong> menentukan
            jumlah kandidat yang dipertahankan pada setiap
            proses pencarian.
        </p>

        <p>
            Contoh: jika Beam Width = 3, maka hanya tiga
            kandidat dengan skor tertinggi yang diteruskan
            ke tahap berikutnya.
        </p>

    </div>

</div>

</body>

</html>

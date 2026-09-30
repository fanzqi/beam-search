<?php

namespace App\Http\Controllers;

use App\Services\BeamSearchTranslator;
use Illuminate\Http\Request;

class TranslationController extends Controller
{
    public function index()
    {
        return view('translation.index', [
            'result' => session('translation_result'),
            'candidates' => session('translation_candidates', []),
            'steps' => session('translation_steps', []),
            'input' => session('translation_input', ''),
            'beamWidth' => session('translation_beam_width', 3),
        ]);
    }

    public function translate(
        Request $request,
        BeamSearchTranslator $translator
    ) {
        $request->validate([
            'text' => [
                'required',
                'string',
                'max:500',
            ],
            'beam_width' => [
                'required',
                'integer',
                'min:1',
                'max:10',
            ],
        ]);

        $input = $request->input('text');
        $beamWidth = (int) $request->input('beam_width');

        // Jalankan proses Beam Search
        $translation = $translator->translate(
            $input,
            $beamWidth
        );

        // Simpan hasil sementara ke session
        session()->flash(
            'translation_result',
            $translation['result']
        );

        session()->flash(
            'translation_candidates',
            $translation['candidates']
        );

        session()->flash(
            'translation_steps',
            $translation['steps']
        );

        session()->flash(
            'translation_input',
            $input
        );

        session()->flash(
            'translation_beam_width',
            $beamWidth
        );

        // Redirect dari POST ke GET
        return redirect()->route('translation.index');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Episode;
use App\Models\Season;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class EpisodesController
{
    /**
     * Display the list of episodes for a given season.
     *
     * @param Season $season The season for which episodes are being retrieved.
     * @return View The episodes index view.
     */
    public function index(Season $season): View
    {
        return view('episodes.index', [
            'episodes' => $season->episodes,
            'mensagemSucesso' => session('mensagem.sucesso'),
        ]);
    }

    /**
     * Update the watched status of episodes for a given season.
     *
     * @param Request $request The HTTP request containing the watched episodes.
     * @param Season $season The season being updated.
     * @return RedirectResponse Redirect back to the episodes index with a success message.
     */
    public function update(Request $request, Season $season): RedirectResponse
    {
        $validated = $request->validate([
            'episodes' => ['array'],
            'episodes.*' => ['integer', 'exists:episodes,id'],
        ]);

        $watchedEpisodes = $validated['episodes'] ?? [];

        $season->episodes->each(function (Episode $episode) use ($watchedEpisodes) {
            $episode->watched = in_array($episode->id, $watchedEpisodes, true);
        });

        $season->push();

        return to_route('episodes.index', $season->id)
            ->with('mensagem.sucesso', 'Episódios marcados como assistidos');
    }
}

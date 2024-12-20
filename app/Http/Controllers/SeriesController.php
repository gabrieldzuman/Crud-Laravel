<?php

namespace App\Http\Controllers;

use App\Events\SeriesCreated;
use App\Http\Requests\SeriesFormRequest;
use App\Jobs\DeleteSeriesCover;
use App\Models\Series;
use App\Repositories\SeriesRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SeriesController extends Controller
{
    /**
     * Constructor with dependency injection and middleware setup.
     *
     * @param SeriesRepository $repository Repository for series management.
     */
    public function __construct(private SeriesRepository $repository)
    {
        $this->middleware('auth')->except('index');
    }

    /**
     * Display a list of series.
     *
     * @param Request $request HTTP request instance.
     * @return \Illuminate\View\View Series index view.
     */
    public function index(Request $request)
    {
        $series = Series::all();
        $mensagemSucesso = session('mensagem.sucesso');

        return view('series.index', [
            'series' => $series,
            'mensagemSucesso' => $mensagemSucesso,
        ]);
    }

    /**
     * Display the form for creating a new series.
     *
     * @return \Illuminate\View\View Series creation view.
     */
    public function create()
    {
        return view('series.create');
    }

    /**
     * Store a newly created series in the database.
     *
     * @param SeriesFormRequest $request Validated request data.
     * @return \Illuminate\Http\RedirectResponse Redirect to series index with success message.
     */
    public function store(SeriesFormRequest $request)
    {
        $coverPath = $request->file('cover')?->store('series_cover', 'public');
        $request->merge(['coverPath' => $coverPath]);

        $serie = $this->repository->add($request);

        SeriesCreated::dispatch(
            $serie->nome,
            $serie->id,
            $request->seasonsQty,
            $request->episodesPerSeason
        );

        return to_route('series.index')
            ->with('mensagem.sucesso', "Série '{$serie->nome}' adicionada com sucesso.");
    }

    /**
     * Remove the specified series from the database.
     *
     * @param Series $series Series to be deleted.
     * @return \Illuminate\Http\RedirectResponse Redirect to series index with success message.
     */
    public function destroy(Series $series)
    {
        if ($series->cover) {
            Storage::disk('public')->delete($series->cover);
        }

        $series->delete();
        DeleteSeriesCover::dispatch($series->cover);

        return to_route('series.index')
            ->with('mensagem.sucesso', "Série '{$series->nome}' removida com sucesso.");
    }

    /**
     * Show the form for editing a series.
     *
     * @param Series $series Series to be edited.
     * @return \Illuminate\View\View Series edit view.
     */
    public function edit(Series $series)
    {
        return view('series.edit', ['serie' => $series]);
    }

    /**
     * Update the specified series in the database.
     *
     * @param Series $series Series to be updated.
     * @param SeriesFormRequest $request Validated request data.
     * @return \Illuminate\Http\RedirectResponse Redirect to series index with success message.
     */
    public function update(Series $series, SeriesFormRequest $request)
    {
        if ($request->hasFile('cover')) {
            if ($series->cover) {
                Storage::disk('public')->delete($series->cover);
            }
            $series->cover = $request->file('cover')->store('series_cover', 'public');
        }

        $series->fill($request->validated());
        $series->save();

        return to_route('series.index')
            ->with('mensagem.sucesso', "Série '{$series->nome}' atualizada com sucesso.");
    }
}

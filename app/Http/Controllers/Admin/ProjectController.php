<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
#use App\Models\User;
use App\Models\Project;
use App\Models\Technology;
use App\Models\Type;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

use function PHPUnit\Framework\isNull;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = Project::orderByDesc('id')->paginate(10);
        return view('admin.projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $types = Type::all();

        $technologies = Technology::all();

        return view('admin.projects.create', compact('types', 'technologies'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProjectRequest $request)
    {

        // dd($request->validated());
        $valData = $request->validated();

        $valData['slug'] = Str::slug($request->title, '-');

        if ($request->has('thumb')) {
            $file_path = Storage::put('thumbs', $request->thumb);
            $valData['thumb'] = $file_path;
        }

        $newProject = Project::create($valData);

        //dd($newProject);

        $newProject->technologies()->attach($request->technologies);

        return to_route('admin.projects.index')->with('status', 'Progetto aggiunto con successo ✅');
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        $technologies = Technology::all();

        return view('admin.projects.show', compact('project', 'technologies'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        $types = Type::all();
        $technologies = Technology::all();

        return view('admin.projects.edit', compact('project', 'types', 'technologies'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {
        $valData = $request->validated();

        $valData['slug'] = Str::slug($request->title, '-');

        if ($request->has('thumb')) {

            // SALVA L'IMMAGINE NEL FILESYSTEM
            $newThumb = $request->thumb;
            $path = Storage::put('thumbs', $newThumb);

            // SE IL FUMETTO HA GIA' UNA COVER NEL DB  NEL FILE SYSTEM, DEVE ESSERE ELIMINATA DATO CHE LA STIAMO SOSTITUENDO
            if (!isNull($project->thumb) && Storage::fileExists($project->thumb)) {
                // ELIMINA LA VECCHIA PREVIEW
                Storage::delete($project->thumb);
            }

            // ASSEGNA AL VALORE DI $valData IL PERCORSO DELL'IMMAGINE NELLO STORAGE
            $valData['thumb'] = $path;
        }


        // eseguo un detach per rimuovere tutti i vecchi collegamenti con le tecnologie
        $project->technologies()->detach();


        // dd($valData);
        // AGGIORNA L'ENTITA' CON I VALORI DI $valData
        $project->update($valData);


        // prendo i dati della richiesta e lo passo nel model Technology e tramite attach, creo il collegamento nella tabella condivisa tra project e tecnology
        $project->technologies()->attach($request->technologies);


        return to_route('admin.projects.index')->with('status', 'Progetto modificato con successo 🥳');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        if (!isNull($project->thumb)) {
            Storage::delete($project->thumb);
        }

        $project->technologies()->detach();

        $project->delete();
        return to_route('admin.projects.index')->with('status', 'Progetto eliminato correttamente 🚮');
    }

    public function recycle()
    {

        $trashed_projects = Project::onlyTrashed()->orderByDesc('id')->paginate(5);

        return view('admin.projects.recycle', compact('trashed_projects'));
    }

    public function restore($id)
    {

        $project = Project::onlyTrashed()->find($id);
        //dd($project);
        $project->restore();


        return to_route('admin.projects.recycle')->with('status', 'Elemento riciclato con successo ♻️');
    }
}

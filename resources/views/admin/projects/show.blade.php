@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <h2 class="text-secondary my-4">
            {{ __('Projects') }}
            <strong>
                {{ $project->id }}
            </strong>{{-- sintassi x traduzione --}}
        </h2>

        <hr>
        <div class="container">

            <div class="row">
                <div class="col text-center">
                    @if (str_contains($project->thumb, 'http'))
                        <img src="{{ $project->thumb }}" alt="{{ $project->title }}">
                    @else
                        <img src="{{ asset('storage/' . $project->thumb) }}">
                    @endif
                </div>


                <div class="col">
                    <h1>{{ $project->title }}</h1>

                    @forelse ($project->technologies as $technology)
                        <li class="badge bg-secondary">
                            <i class="fas fa-tag fa-xs fa-fw"></i>
                            {{ $technology->tech }}
                        </li>
                    @empty
                        {{-- {{ vard_dump($technology->tech) }} --}}
                        <li class="badge bg-secondary">Untagged</li>
                    @endforelse


                    <p>Description:
                        {{ $project->description }}
                    </p>

                    <div class="d-flex flex-column gap-2">
                        {{-- EDIT --}}
                        <a class="w-100 btn btn-warning" href="{{ route('admin.projects.edit', $project->slug) }}">
                            <i class="fa-solid fa-pen-to-square fa-xl"></i>
                        </a>
                        {{-- DELETE --}}
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                            data-bs-target="#modalId-{{ $project->id }}">
                            <i class="fa-solid fa-trash fa-xl"></i>
                        </button>


                        {{-- MODALE PER ELIMINARE ELEMENTO --}}
                        <div class="modal fade" id="modalId-{{ $project->id }}" data-backdrop="static"
                            data-keyboard="false" tabindex="-1" aria-labelledby="modalId-{{ $project->id }}"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header bg-danger text-white justify-content-center">
                                        <h5 class="modal-title text-uppercase" id="modalTitleId-{{ $project->id }}">
                                            Attenzione!</h5>
                                    </div>
                                    <div class="modal-body fs-5">
                                        Il progetto <strong>{{ $project->id }}</strong> -
                                        <strong>{{ $project->title }}</strong> sta per essere eliminato!
                                    </div>
                                    <div class="modal-footer justify-content-between">
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal">
                                            <i class="fa-solid fa-angle-left"></i> Back
                                        </button>
                                        {{-- non confondere destroy con delete --}}
                                        <form action="{{ route('admin.projects.destroy', $project->slug) }}"
                                            method="POST">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="btn btn-danger">Delete <i
                                                    class="fa-solid fa-trash"></i></button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <a class="w-100 btn btn-dark" href="{{ $project->link_github }}">
                            <i class="fa-brands fa-github fa-xl"></i>
                        </a>
                        <a class="w-100 btn btn-secondary" href="{{ $project->link_project_online }}">
                            <i class="fa-solid fa-link fa-xl"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

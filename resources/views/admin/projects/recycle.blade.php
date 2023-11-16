@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <h2 class="text-uppercase text-dark my-4">
            {{ __('Soft Deleted Projects') }} {{-- sintassi x traduzione --}}
        </h2>

        <hr>

        {{ $trashed_projects->links('pagination::bootstrap-5') }}



        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif



        <div class="table-responsive">
            <table class="table table-success table-hover table-bordered border-white">
                <thead>
                    <tr class="fs-6">
                        {{-- <th scope="col">ID</th> --}}
                        <th scope="col">Preview</th>
                        <th scope="col">Title</th>
                        <th scope="col">Deleted at</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($trashed_projects as $project)
                        <tr>

                            {{-- IMG --}}
                            <td class="text-center align-middle">

                                @if ($project->thumb)
                                    <img width="100" src="{{ asset('storage/' . $project->thumb) }}"
                                        alt="{{ $project->title }}">
                                @else
                                    <i class="fa-solid fa-image fa-2xl"></i>
                                @endif
                            </td>

                            {{-- TITLE --}}
                            <td class="align-middle">{{ $project->title }}</td>

                            {{-- DELETED_AT --}}
                            <td class="align-middle">{{ $project->deleted_at }}</td>


                            {{-- RESTORE --}}
                            <td class="align-middle text-center">
                                <a class="btn btn-primary" href="{{ route('admin.projects.restore', $project->id) }}"><i
                                        class="fa-solid fa-recycle"></i></a>

                                {{-- EDIT --}}
                                {{-- <a class="btn btn-warning" href="{{ route('admin.projects.edit', $project->slug) }}"><i
                                        class="fa-solid fa-pen-to-square"></i></a>
 --}}

                                {{-- DELETE --}}
                                {{-- <a class="btn btn-danger" href="{{ route('admin.projects.destroy', $project) }}">Delete</a> --}}

                                {{--  <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                    data-bs-target="#modalId-{{ $project->id }}">
                                    <i class="fa-solid fa-trash"></i>
                                </button> --}}

                                {{-- MODALE PER ELIMINARE ELEMENTO --}}
                                <div class="modal fade" id="modalId-{{ $project->id }}" data-backdrop="static"
                                    data-keyboard="false" tabindex="-1" aria-labelledby="modalId-{{ $project->id }}"
                                    aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header bg-danger text-white justify-content-center">
                                                <h5 class="modal-title text-uppercase"
                                                    id="modalTitleId-{{ $project->id }}">Attenzione!</h5>
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
                            </td>
                        </tr>


                    @empty
                        <td class="align-middle">Bin is empty</td>
                    @endforelse



                </tbody>
            </table>
        </div>

    </div>
@endsection

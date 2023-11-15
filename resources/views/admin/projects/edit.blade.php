@extends('layouts.admin')

@section('content')
    <div class="container">
        <h2 class="fs-4 text-secondary my-4">
            {{ __('Edit Project') }} {{ Auth::user()->name }}
        </h2>

        <div class="row justify-content-center my-3">
            <div class="col">

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.projects.update', $project) }}" method="POST" enctype="multipart/form-data">

                    @csrf

                    @method('put')

                    <div class="mb-3">

                        <label for="title" class="form-label"><strong>Title</strong></label>

                        <input type="text" class="form-control" name="title" id="title"
                            aria-describedby="helpTitle" placeholder="New project Title"
                            value="{{ old('title') ? old('title') : $project->title }}" required>

                        @error('title')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror

                    </div>

                    <div class="mb-3">

                        <label for="description" class="form-label"><strong>Description</strong></label>

                        <input type="text" class="form-control" name="description" id="description"
                            aria-describedby="helpTitle" placeholder="New project Description" required
                            value="{{ old('description') ? old('description') : $project->description }}">

                        @error('description')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror

                    </div>

                    {{-- <div class="mb-3">

                        <label for="tech" class="form-label"><strong>Technologies Used</strong></label>

                        <input type="text" class="form-control" name="tech" id="tech"
                            aria-describedby="helpTitle" placeholder="Tech used creating the New Project">

                        @error('tech')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div> --}}

                    <div class="mb-3">

                        <label for="thumb" class="form-label"><strong>Choose a Thumbnail image file</strong></label>

                        <input type="file" class="form-control" name="thumb" id="thumb"
                            placeholder="Upload a new image file..." aria-describedby="fileHelpThumb">

                        @error('thumb')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror

                    </div>
                    <div class="mb-3">

                        <label for="link_github" class="form-label"><strong>Link GitHub</strong></label>

                        <input type="url" class="form-control" name="link_github" id="link_github"
                            aria-describedby="helpGithubLink" placeholder="GitHub link to the New Project"
                            value="{{ old('link_github') }}">

                        @error('link_github')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror

                    </div>

                    <div class="mb-3">

                        <label for="link_project_online" class="form-label"><strong>Link WEB</strong></label>

                        <input type="url" class="form-control" name="link_project_online" id="link_project_online"
                            aria-describedby="helpWebLink" placeholder="Web link to the New Project"
                            value="{{ old('link_project_online') }}">

                        @error('link_project_online')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror

                    </div>

                    <div class="mb-3">
                        <label for="type_id" class="form-label">Types</label>
                        <select class="form-select @error('type_id') is-invalid  @enderror" name="type_id" id="type_id">
                            <option selected disabled>Select a type</option>

                            @forelse ($types as $type)
                                <option value="{{ $type->id }}" {{ $type->id == old('type_id') ? 'selected' : '' }}>
                                    {{ $type->type }}</option>
                            @empty
                            @endforelse


                        </select>
                    </div>
                    @error('type_id')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror

                    <div class="mb-3">
                        <label for="technologies" class="form-label">Technologies</label>
                        <select multiple class="form-select" name="technologies[]" id="technologies">
                            <option disabled>Select one</option>

                            <!-- TODO: Improve validation outputs -->
                            @foreach ($technologies as $technology)
                                <option value="{{ $technology->id }}"
                                    {{ in_array($technology->id, old('technologies', [])) ? 'selected' : '' }}>
                                    {{ $technology->tech }}
                                </option>
                            @endforeach


                        </select>
                    </div>
                    @error('technologies')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror

                    <button type="submit" class="btn btn-success my-3">SAVE</button>
                    <a class="btn btn-primary" href="{{ route('admin.projects.index') }}">CANCEL</a>


                </form>
            </div>
        </div>

    </div>
@endsection

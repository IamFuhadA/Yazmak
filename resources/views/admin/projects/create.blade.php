@extends('layouts.app')

@section('content')

<div class="max-w-4xl mx-auto py-8 px-4 sm:px-6 lg:px-8 space-y-6">

    <div class="flex justify-between items-center pb-4 border-b animate-fade-in" style="border-color:var(--line);">
        <div>
            <p class="font-mono text-[.68rem] uppercase tracking-[.14em]" style="color:var(--brass);">New asset draft</p>
            <h1 class="font-display text-3xl" style="color:var(--paper);">Add Project</h1>
        </div>

        <a href="{{ route('admin.projects.index') }}" class="ghost-button rounded px-4 py-2 text-xs">
            &larr; Back to Index
        </a>
    </div>

    <form action="{{ route('admin.projects.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @include('admin.projects.partials.form')
    </form>

</div>

@endsection
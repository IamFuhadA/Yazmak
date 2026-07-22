@extends('layouts.app')

@section('content')

<div class="max-w-5xl mx-auto py-8">

    <h1 class="text-3xl font-bold mb-6">

        Edit About

    </h1>

    <form
        action="{{ route('admin.about.update',$about) }}"
        method="POST"
        enctype="multipart/form-data">

        @csrf
        @method('PUT')

        @include('admin.about.partials.form')

    </form>

</div>

@endsection
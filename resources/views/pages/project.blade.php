@extends('layouts.app')
@section('title', $project->title.' — MR Portfolio')
@section('content')
<main class="project-detail-page"><a class="admin-back" href="{{ route('home') }}#projects">← Semua projects</a><p class="admin-eyebrow">PROJECT CASE STUDY</p><h1>{{ $project->title }}</h1>@include('components.project-detail')</main>
@endsection

@extends('layouts.app')

@section('title', 'Admin Dashboard - Mochamad Miftah Rachmatullah')

@section('content')
<div class="flex flex-col gap-6 p-6 lg:p-8">
    <div class="p-8 bg-white border-2 border-[#1a1a1a] shadow-[8px_8px_0_0_#1a1a1a] dark:bg-[#161615] dark:border-[#3E3E3A] dark:shadow-[8px_8px_0_0_#3E3E3A]">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-3xl font-bold uppercase">Dashboard</h1>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="px-6 py-2 font-bold uppercase bg-[#f53003] text-white border-2 border-[#1a1a1a] shadow-[4px_4px_0_0_#1a1a1a] hover:-translate-y-1 hover:shadow-[6px_6px_0_0_#1a1a1a] active:translate-y-1 active:shadow-[0_0_0_0_#1a1a1a] transition-all dark:bg-[#FF4433]">
                    Logout
                </button>
            </form>
        </div>
        
        <p class="text-[#706f6c] dark:text-[#A1A09A]">
            Welcome to your admin dashboard, {{ Auth::user()->name }}! 
        </p>

        <div class="mt-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <div class="p-6 bg-[#fff2f2] border-2 border-[#1a1a1a] shadow-[4px_4px_0_0_#1a1a1a] dark:bg-[#1D0002] dark:border-[#3E3E3A]">
                <h2 class="text-xl font-bold uppercase">Manage Projects</h2>
                <p class="mt-2 text-sm">Create, edit, or delete your portfolio projects.</p>
                <button class="mt-4 px-4 py-2 bg-[#ffe44d] border-2 border-[#1a1a1a] shadow-[2px_2px_0_0_#1a1a1a] font-bold text-sm uppercase transition-transform hover:-translate-y-1">View Projects</button>
            </div>
            
            <div class="p-6 bg-[#dbdbd7] border-2 border-[#1a1a1a] shadow-[4px_4px_0_0_#1a1a1a] dark:bg-[#3E3E3A] dark:border-[#1a1a1a]">
                <h2 class="text-xl font-bold uppercase">Manage Categories</h2>
                <p class="mt-2 text-sm">Organize your projects with taxonomies.</p>
                <button class="mt-4 px-4 py-2 bg-white border-2 border-[#1a1a1a] shadow-[2px_2px_0_0_#1a1a1a] font-bold text-sm uppercase transition-transform hover:-translate-y-1 dark:text-[#1a1a1a]">View Categories</button>
            </div>
        </div>
    </div>
</div>
@endsection

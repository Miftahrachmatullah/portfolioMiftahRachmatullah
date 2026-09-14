@extends('layouts.app')

@section('title', 'Login - Mochamad Miftah Rachmatullah')

@section('content')
<div class="flex items-center justify-center w-full min-h-[70vh] p-6 lg:p-8">
    <div class="w-full max-w-md p-8 bg-white border-2 border-[#1a1a1a] shadow-[8px_8px_0_0_#1a1a1a] dark:bg-[#161615] dark:border-[#3E3E3A] dark:shadow-[8px_8px_0_0_#3E3E3A]">
        <h1 class="mb-2 text-2xl font-bold uppercase">Admin Login</h1>
        <p class="mb-6 text-sm text-[#706f6c] dark:text-[#A1A09A]">Welcome back! Please login to your account.</p>

        @if ($errors->any())
            <div class="p-3 mb-4 text-sm bg-[#fff2f2] border-2 border-[#f53003] text-[#f53003] dark:bg-[#1D0002] dark:border-[#FF4433] dark:text-[#FF4433]">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('login.post') }}" method="POST" class="flex flex-col gap-4">
            @csrf
            
            <div class="flex flex-col gap-2">
                <label for="email" class="text-sm font-bold">EMAIL ADDRESS</label>
                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    value="{{ old('email') }}"
                    required 
                    autofocus
                    class="p-3 border-2 border-[#1a1a1a] bg-[#FDFDFC] dark:bg-[#0a0a0a] dark:border-[#3E3E3A] dark:text-[#EDEDEC] focus:outline-none focus:ring-0 focus:border-[#f8b803] transition-colors"
                />
            </div>

            <div class="flex flex-col gap-2">
                <label for="password" class="text-sm font-bold">PASSWORD</label>
                <input 
                    type="password" 
                    id="password" 
                    name="password" 
                    required 
                    class="p-3 border-2 border-[#1a1a1a] bg-[#FDFDFC] dark:bg-[#0a0a0a] dark:border-[#3E3E3A] dark:text-[#EDEDEC] focus:outline-none focus:ring-0 focus:border-[#f8b803] transition-colors"
                />
            </div>

            <button 
                type="submit" 
                class="mt-4 w-full p-4 font-bold text-center uppercase bg-[#ffe44d] border-2 border-[#1a1a1a] text-[#1a1a1a] transition-all hover:-translate-y-1 shadow-[4px_4px_0_0_#1a1a1a] hover:shadow-[6px_6px_0_0_#1a1a1a] active:translate-y-1 active:shadow-[0_0_0_0_#1a1a1a]"
            >
                Login to Dashboard
            </button>
        </form>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('title', 'Sign In - CEMS')

@section('content')
<div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full">
        <div class="text-center mb-8">
            <div class="w-16 h-16 bg-gradient-to-br from-primary-500 to-primary-700 rounded-xl flex items-center justify-center mx-auto mb-4">
                <span class="text-white font-bold text-2xl">C</span>
            </div>
            <h2 class="text-3xl font-bold text-gray-900">Welcome back</h2>
            <p class="mt-2 text-gray-600">Sign in to your CEMS account</p>
        </div>

        <div class="card p-8">
            <form method="POST" action="/login" class="space-y-6">
                @csrf

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email address</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus
                        class="input-field w-full" placeholder="you@example.com">
                    @error('email')
                        <p class="mt-2 text-sm text-danger">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                    <input type="password" id="password" name="password" required
                        class="input-field w-full" placeholder="••••••••">
                    @error('password')
                        <p class="mt-2 text-sm text-danger">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input type="checkbox" id="remember" name="remember" class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded">
                        <label for="remember" class="ml-2 text-sm text-gray-700">Remember me</label>
                    </div>
                </div>

                <button type="submit" class="btn-primary w-full">
                    Sign in
                </button>
            </form>

            <div class="mt-6 text-center">
                <p class="text-sm text-gray-600">
                    Don't have an account?
                    <a href="/register" class="font-medium text-primary-600 hover:text-primary-500">Sign up</a>
                </p>
            </div>
        </div>

        <div class="mt-8 card p-6 bg-blue-50 border border-blue-100">
            <div class="flex items-start">
                <svg class="w-5 h-5 text-blue-600 mt-0.5 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                </svg>
                <div>
                    <p class="text-sm font-semibold text-blue-900 mb-2">Test Accounts</p>
                    <div class="space-y-2 text-sm text-blue-800">
                        <div>
                            <p class="font-medium">Admin:</p>
                            <p class="font-mono text-xs">admin@cems.local / password</p>
                        </div>
                        <div>
                            <p class="font-medium">Student:</p>
                            <p class="font-mono text-xs">student@cems.local / password</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

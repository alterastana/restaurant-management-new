<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="referrer" content="always">

        <title>Login Page</title>

        @vite('resources/css/app.css')
    </head>
    <body>
        <div class="flex justify-center items-center h-screen bg-gray-200 px-6">
            <div class="p-6 max-w-sm w-full bg-white shadow-md rounded-md">

                @if(@session()->has('login-error'))
                    {{-- <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('login-error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div> --}}
                    <div id="alert-2" class="flex items-center p-4 mb-4 text-red-800 rounded-lg bg-red-50 dark:text-red-400" role="alert">
                        {{ session('login-error') }}
                        <button type="button" class="ms-auto -mx-1.5 -my-1.5 bg-red-50 text-red-500 rounded-lg focus:ring-2 focus:ring-red-400 p-1.5 hover:bg-red-200 inline-flex items-center justify-center h-8 w-8 dark:text-red-400 dark:hover:bg-gray-700" data-dismiss-target="#alert-2" aria-label="Close">
                            <span class="sr-only">Close</span>
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                            </svg>
                        </button>
                    </div>
                @endif

                <div class="flex justify-center items-center">
                    <span class="text-gray-700 font-semibold text-2xl">Dashboard</span>
                </div>

                <form class="mt-4" action="/login" method="POST">
                    @csrf
                    <label class="block">
                        <span class="text-gray-700 text-sm">Email</span>
                        <input type="email" name="email" autofocus required value="{{ old('email') }}"
                            @error('email')
                                is-invalid
                            @enderror
                            class="form-control mt-1 block w-full rounded-lg border border-gray-300 focus:border-indigo-600 focus:ring-indigo-600 
                            shadow-sm transition duration-200 ease-in-out focus:outline-none focus:shadow-outline px-4 py-2">
                        @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </label>

                    <label class="block mt-3">
                        <span class="text-gray-700 text-sm">Password</span>
                        <input type="password" name="password" required class="form-control mt-1 block w-full rounded-lg border border-gray-300 focus:border-indigo-600
                            focus:ring-indigo-600 shadow-sm transition duration-200 ease-in-out focus:outline-none focus:shadow-outline px-4 py-2">
                    </label>

                    <div class="flex justify-between items-center mt-4">
                        <div>
                            <label class="inline-flex items-center">
                                <input type="checkbox" class="form-checkbox text-indigo-600">
                                <span class="mx-2 text-gray-600 text-sm">Remember me</span>
                            </label>
                        </div>

                        <div>
                            <a class="block text-sm fontme text-indigo-700 hover:underline" href="#">Forgot your password?</a>
                        </div>
                    </div>

                    <div class="mt-6">
                        <button class="py-2 px-4 text-center bg-indigo-600 rounded-md w-full text-white text-sm hover:bg-indigo-500">
                            Sign in
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </body>
</html>

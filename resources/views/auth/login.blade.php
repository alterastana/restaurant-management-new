<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Login Page</title>
        @vite('resources/css/app.css')
    </head>
    <body>
        <div class="flex justify-center items-center h-screen bg-gray-200 px-6">
            <div class="p-6 max-w-sm w-full bg-white shadow-md rounded-md">

                {{-- (Kode error handling Anda di sini) --}}

                <div class="flex justify-center items-center">
                    <span class="text-gray-700 font-semibold text-2xl">Dashboard</span>
                </div>

                <form class="mt-4" action="{{ route('login') }}" method="POST">
                    @csrf
                    {{-- (Input email dan password Anda di sini) --}}
                    <label class="block">
                        <span class="text-gray-700 text-sm">Email</span>
                        <input type="email" name="email" autofocus required value="{{ old('email') }}" class="form-input form-control mt-1 block w-full px-4 py-2 rounded-lg shadow-sm">
                    </label>
                    <label class="block mt-3">
                        <span class="text-gray-700 text-sm">Password</span>
                        <input type="password" name="password" required class="form-input form-control mt-1 block w-full px-4 py-2 rounded-lg shadow-sm">
                    </label>
                    
                    {{-- (Kode "Remember me" dan "Forgot password" Anda di sini) --}}

                    <div class="mt-6">
                        <button class="py-2 px-4 text-center btn-secondary rounded-md w-full text-white text-sm focus-brand">
                            Sign in
                        </button>
                    </div>

                    {{-- ============================================= --}}
                    {{--    TAMBAHKAN BLOK INI UNTUK LINK REGISTER     --}}
                    {{-- ============================================= --}}
                    <div class="text-center mt-6">
                        <p class="text-sm text-gray-600">
                            Belum punya akun?
                            <a class="underline text-brand-primary hover:underline font-semibold" href="{{ route('register') }}">
                                Daftar sekarang
                            </a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </body>
</html>
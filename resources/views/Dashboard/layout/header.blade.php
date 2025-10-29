<header class="py-4 text-white bg-brand-primary shadow-md">
    <div class="container flex items-center justify-between px-6 lg:px-10">
        <div>
            <h1 class="font-bold text-2xl sm:text-3xl">
                @if (auth()->user()->role == 'admin')
                    Dashboard Admin
                @endif
            </h1>
        </div>
        
        <nav class="ml-auto">
            <form action="/logout" method="POST">
                @csrf
                <button type="submit" 
                    class="px-4 py-2 text-lg font-medium rounded btn-secondary focus-brand">
                    Logout
                </button>
            </form>
        </nav>
    </div>
</header>

@php
    use Illuminate\Support\Facades\Auth;
    use App\Models\Buku;
@endphp

<nav class="fixed top-0 left-0 w-full bg-white shadow p-3 flex items-center justify-between z-50">
    <a href="{{ url('/') }}" class="text-xl font-bold text-blue-600 ml-10">IRSYAD</a>
    <div class="hidden md:flex space-x-4 text-sm font-medium">
        <div class="relative group">
            <a href="/category" class="hover:text-blue-600">My Books ▼</a>
            <div
                class="absolute left-0 mt-1 w-40 bg-white shadow rounded-md opacity-0 invisible transition-all duration-200 group-hover:opacity-100 group-hover:visible z-50">
                @foreach ($categories as $category)
                    <a href="{{ url('category/' . $category->id) }}" class="block px-3 py-2 hover:bg-blue-100">
                        {{ $category->nama }}
                    </a>
                @endforeach
            </div>
        </div>
        <a href="#" class="hover:text-blue-600">Browse</a>
    </div>

    <!-- Search Bar -->
    <div class="relative w-48">
        <input type="text" id="searchInput"
            class="p-1 pl-3 pr-8 border rounded w-full text-sm focus:ring-1 focus:ring-blue-400" placeholder="Search">
        <button
            class="absolute right-2 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-blue-600"></button>

        <div id="searchResults"
            class="absolute left-0 right-0 bg-white shadow max-h-0 overflow-hidden transition-all duration-200 border border-gray-300 border-t-0 z-10">
            @foreach (Buku::all() as $book)
                <div class="px-3 py-2 text-sm hover:bg-blue-100 hidden" data-title="{{ strtolower($book->judul) }}">
                    {{ $book->judul }}
                </div>
            @endforeach
        </div>
    </div>

    <div class="relative">
        @if (Auth::check())
            <button id="userMenuButton" class="focus:outline-none flex items-center space-x-2">
                <img src="{{ asset(Auth::user()->profile) }}" class="w-8 h-8 rounded-full border shadow">
                <span class="text-sm font-medium">{{ Auth::user()->nama }}</span>
            </button>
            <div id="userMenu" class="hidden absolute right-0 mt-1 w-40 bg-white shadow rounded">
                <a href="#" class="block px-3 py-2 hover:bg-blue-100">My Profile</a>
                <div class="border-t"></div>
                <a href="{{ route('auth.logoutAction') }}" class="block px-3 py-2 hover:bg-blue-100">Log Out</a>
            </div>
        @else
            <a href="auth/login" class="bg-blue-600 text-white px-4 py-1.5 rounded text-sm shadow hover:bg-blue-700 mr-12">
                Log In
            </a>
        @endif
    </div>
</nav>

<style>
    body {
        padding-top: 40px;
    }
</style>

<script>
    document.getElementById("searchInput").addEventListener("input", function() {
        let filter = this.value.toLowerCase();
        let results = document.getElementById("searchResults");
        let items = results.getElementsByTagName("div");
        let hasResults = false;

        for (let i = 0; i < items.length; i++) {
            let title = items[i].getAttribute("data-title");
            if (title.includes(filter)) {
                items[i].classList.remove("hidden");
                hasResults = true;
            } else {
                items[i].classList.add("hidden");
            }
        }

        results.style.maxHeight = hasResults && filter !== "" ? "150px" : "0px";
    });
</script>
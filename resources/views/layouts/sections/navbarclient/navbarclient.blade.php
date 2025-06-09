@php
    use Illuminate\Support\Facades\Auth;
    use App\Models\Buku;
@endphp

<nav class="fixed top-0 left-0 w-full bg-white shadow-md z-40 border-b border-gray-100">
    <div class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <a href="{{ url('/') }}" class="text-xl font-bold text-[#696cff] hover:text-[#5a5cff] transition-colors">
                {{ $setting->brand ?? 'PUSKITA' }}
            </a>
            <div class="hidden md:flex items-center space-x-8">
                <div class="flex items-center space-x-6">
                    <div class="relative group">
                        <a href="/category"
                            class="text-gray-700 hover:text-[#696cff] transition-colors font-medium text-sm flex">
                            Genre
                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </a>
                        <div
                            class="absolute left-0 mt-2 w-48 bg-white shadow-lg rounded-md py-1 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50 border border-gray-100">
                            @foreach ($categories as $category)
                                <a href="{{ url('category?genre=' . urlencode($category->nama)) }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-[#696cff] transition-colors">
                                    {{ $category->nama }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                    <div class="relative group">
                        <a href="/category"
                            class="inline-flex items-center gap-1 text-gray-700 hover:text-[#696cff] transition-colors font-medium text-sm">
                            Sub Genre
                            <svg class="h-4 w-4 text-gray-400 group-hover:text-[#696cff] transition"
                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </a>
                        <div
                            class="absolute left-0 mt-2 w-80 bg-white shadow-lg rounded-lg p-2 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50 border border-gray-100">
                            @if ($subcategories->count())
                                <div class="grid grid-cols-2 gap-1">
                                    @foreach ($subcategories as $sub)
                                        <a href="{{ url('category?sub_category=' . $sub->id_sub_kelompok) }}"
                                            class="block px-3 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-[#696cff] rounded transition">
                                            {{ $sub->nama }}
                                        </a>
                                    @endforeach
                                </div>
                            @else
                                <span class="block px-4 py-2 text-sm text-gray-400">Tidak ada sub genre</span>
                            @endif
                        </div>
                    </div>

                    <a href="/instansi"
                        class="text-gray-700 hover:text-[#696cff] transition-colors font-medium text-sm">
                        Instansi
                    </a>
                </div>
            </div>
            <div class="flex items-center space-x-4">
                <button id="openSearch"
                    class="hidden md:flex items-start text-gray-500 hover:text-[#696cff] px-16 py-1.5 border rounded-full text-sm focus:outline-none focus:ring-2 focus:ring-blue-200 focus:ring-opacity-50 transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    Search
                </button>

                <div class="relative ">
                    @if (Auth::check())
                        <button id="userMenuButton" class="focus:outline-none flex items-center space-x-1 group">
                            <img src="{{ asset('/storage/' . Auth::user()->profile) }}"
                                class="w-8 h-8 rounded-full border-2 border-transparent group-hover:border-blue-200 transition-all shadow-sm">
                            <span
                                class="text-sm font-medium text-gray-700 hidden lg:inline-block">{{ Auth::user()->nama }}</span>
                        </button>
                        <div id="userMenu"
                            class="hidden absolute mt-2 w-56 bg-white shadow-lg rounded-md py-1 z-50 border border-gray-100">
                            <a href="{{ route('profile', ['id' => Auth::user()]) }}"
                                class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 transition-colors">
                                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                My Profile
                            </a>
                            @if (Auth::user()->id_instansi)
                                <a href="{{ route('dashboard.user.instansi.profile', ['id' => Auth::user()->id_instansi]) }}"
                                    class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-500"
                                        fill="currentColor" viewBox="0 0 16 16">
                                        <path
                                            d="M5 2a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2h3.5A1.5 1.5 0 0 1 16 3.5v9a1.5 1.5 0 0 1-1.5 1.5H14a.5.5 0 0 1-1 0H3a.5.5 0 0 1-1 0h-.5A1.5 1.5 0 0 1 0 12.5v-9A1.5 1.5 0 0 1 1.5 2zm1 0h4a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1M1.5 3a.5.5 0 0 0-.5.5v9a.5.5 0 0 0 .5.5H3V3zM15 12.5v-9a.5.5 0 0 0-.5-.5H13v10h1.5a.5.5 0 0 0 .5-.5m-3 .5V3H4v10z" />
                                    </svg>
                                    Profile Instansi
                                </a>
                            @endif
                            <a href="{{ route('dashboard.bookmarks.index') }}"
                                class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-gray-500">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M17.593 3.322c1.1.128 1.907 1.077 1.907 2.185V21L12 17.25 4.5 21V5.507c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0 1 11.186 0Z" />
                                </svg>
                                Bookmarks
                            </a>

                            <div class="border-t border-gray-100 my-1"></div>

                            <a href="{{ route('auth.logoutAction') }}"
                                class="flex items-center gap-2 px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors">
                                <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                                Logout
                            </a>
                        </div>
                    @else
                        <a href="/auth/login"
                            class="bg-[#696cff] hover:bg-[#5a5cff] text-white px-4 py-1.5 rounded-full text-sm shadow-md hover:shadow-lg transition-all flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                            </svg>
                            Log In
                        </a>
                    @endif
                </div>


                <button id="hamburger" class="md:hidden text-gray-600 hover:text-gray-900 focus:outline-none">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div id="mobileMenu" class="md:hidden hidden px-6 py-3 space-y-4 bg-white border-t border-gray-100 shadow-sm">
        <div class="flex flex-col space-y-3">
            <a href="/category" class="text-gray-700 hover:text-[#696cff] transition-colors font-medium">Genre</a>
            <a href="/category" class="text-gray-700 hover:text-[#696cff] transition-colors font-medium">Jenis</a>
            <a href="/instansi" class="text-gray-700 hover:text-[#696cff] transition-colors font-medium">Instansi</a>
        </div>

        <button
            class="w-full flex items-center justify-between px-3 py-2 border rounded-lg text-gray-500 hover:text-[#696cff] focus:outline-none focus:ring-1 focus:ring-blue-200">
            <span>Search</span>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
        </button>

        @if (Auth::check())
            <div class="pt-4 border-t border-gray-100">
                <div class="flex items-center space-x-3">
                    <img src="{{ asset(Auth::user()->profile) }}" class="w-8 h-8 rounded-full border shadow-sm">
                    <div>
                        <p class="text-sm font-medium text-gray-900">{{ Auth::user()->nama }}</p>
                        <a href="{{ route('auth.logoutAction') }}"
                            class="text-xs text-red-600 hover:text-red-800">Logout</a>
                    </div>
                </div>
            </div>
        @else
            <a href="/auth/login"
                class="block w-full text-center bg-[#696cff] hover:bg-[#5a5cff] text-white px-4 py-2 rounded-lg text-sm shadow-md hover:shadow-lg transition-all">
                Log In
            </a>
        @endif
    </div>
</nav>
<div id="searchPopup"
    class="fixed left-1/2 transform -translate-x-1/2 bg-white rounded-xl shadow-xl w-full max-w-2xl z-50 hidden border border-gray-200">
    <div class="p-4">
        {{-- Search Input --}}
        <div class="flex items-center mb-4">
            <div class="relative flex-grow">
                <svg xmlns="http://www.w3.org/2000/svg"
                    class="h-5 w-5 absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                <input type="text" id="popupSearchInput"
                    class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    placeholder="Search books, genres, authors..." autocomplete="off" />
            </div>
            <button id="closeSearchPopup"
                class="ml-2 text-gray-400 hover:text-gray-600 p-1 rounded-full hover:bg-gray-100 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        {{-- Result List --}}
        <div class="max-h-96 overflow-y-auto">
            <h3 id="trendingHeader" class="text-sm font-semibold text-gray-700 mb-2 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-red-500" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                </svg>
                Trending Now
            </h3>

            <ul id="trendingList" class="space-y-2">
                @if (isset($trendingNavbar) && count($trendingNavbar))
                    @foreach ($trendingNavbar as $book)
                        <li>
                            <a href="{{ route('dashboard.buku.create', $book->id) }}"
                                class="flex items-center px-3 py-2 hover:bg-blue-50 rounded-lg transition-colors">
                                <span class="text-red-500 mr-2">🔥</span>
                                <span class="text-gray-800">{{ $book->judul }}</span>
                            </a>
                        </li>
                    @endforeach
                @else
                    <li class="px-3 py-2 text-gray-500 text-sm">No trending books available</li>
                @endif
            </ul>

            <ul id="searchResultList" class="space-y-2 mt-4"></ul>
        </div>

        <p class="mt-3 text-xs text-gray-500 text-center">Press Enter to see all results</p>
    </div>
</div>

<script>
    const hamburger = document.getElementById('hamburger');
    const mobileMenu = document.getElementById('mobileMenu');

    hamburger.addEventListener('click', () => {
        mobileMenu.classList.toggle('hidden');
        hamburger.innerHTML = mobileMenu.classList.contains('hidden') ?
            '<svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" /></svg>' :
            '<svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>';
    });

    const openSearch = document.getElementById("openSearch");
    const closeSearchPopup = document.getElementById("closeSearchPopup");
    const searchPopup = document.getElementById("searchPopup");
    const searchInput = document.getElementById("popupSearchInput");

    openSearch.addEventListener("click", () => {
        searchPopup.classList.remove("hidden");
        setTimeout(() => searchInput.focus(), 100);
    });

    closeSearchPopup.addEventListener("click", () => {
        searchPopup.classList.add("hidden");
    });

    document.addEventListener("keydown", (e) => {
        if (e.key === "Escape") {
            searchPopup.classList.add("hidden");
        }
    });

    const userMenuButton = document.getElementById("userMenuButton");
    const userMenu = document.getElementById("userMenu");

    if (userMenuButton) {
        userMenuButton.addEventListener("click", function(e) {
            e.stopPropagation();
            userMenu.classList.toggle("hidden");
        });

        document.addEventListener("click", function(e) {
            if (!userMenu.contains(e.target) && !userMenuButton.contains(e.target)) {
                userMenu.classList.add("hidden");
            }
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        const input = document.getElementById('popupSearchInput');
        const searchResultList = document.getElementById('searchResultList');
        const trendingList = document.getElementById('trendingList');
        let timeout = null;

        input.addEventListener('input', function() {
            const keyword = this.value.trim();

            clearTimeout(timeout);
            timeout = setTimeout(() => {
                if (keyword.length === 0) {
                    searchResultList.innerHTML = '';
                    return;
                }

                fetch(`/search?q=${encodeURIComponent(keyword)}`)
                    .then(response => response.json())
                    .then(books => {
                        if (books.length) {
                            searchResultList.innerHTML = books.map(books => `
                            <li>
                                <a href="/buku/${books.id_buku}"
                                    class="flex items-center px-3 py-2 hover:bg-blue-50 rounded-lg transition-colors">
                                    <span class="text-blue-500 mr-2">🔍</span>
                                    <span class="text-gray-800">${books.judul}</span>
                                </a>
                            </li>
                        `).join('');
                        } else {
                            searchResultList.innerHTML =
                                `<li class="px-3 py-2 text-gray-500 text-sm">No books found</li>`;
                        }
                    });
            }, 300);
        });
    });
</script>

<style>
    #searchPopup {
        animation: fadeInDown 0.2s ease-out;
    }

    @keyframes fadeInDown {
        from {
            opacity: 0;
            transform: translate(-50%, -10px);
        }

        to {
            opacity: 1;
            transform: translate(-50%, 0);
        }
    }

    .dropdown-enter {
        opacity: 0;
        transform: translateY(-10px);
    }

    .dropdown-enter-active {
        opacity: 1;
        transform: translateY(0);
        transition: opacity 200ms, transform 200ms;
    }

    .dropdown-exit {
        opacity: 1;
    }

    .dropdown-exit-active {
        opacity: 0;
        transform: translateY(-10px);
        transition: opacity 200ms, transform 200ms;
    }
</style>

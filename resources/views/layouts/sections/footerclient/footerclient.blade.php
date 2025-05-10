<footer class="bg-[#111827] text-white pt-12 pb-6">
    <div class="container mx-auto max-w-screen-xl sm:px-6 lg:px-8 px-4">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-8">
            <!-- Logo and About -->
            <div class="space-y-4">
                <a href="/" class="text-2xl font-bold text-[#696cff]">{{ $setting->brand ?? 'PUSKITA' }}</a>
                <p class="text-gray-400 text-sm">
                    {{ $setting->deskripsi }}
                </p>
            </div>
        </div>

        <div class="border-t border-gray-800 pt-6 flex flex-col md:flex-row justify-between items-center">
            <p class="text-gray-400 text-sm">
                © 2025 {{ $setting->brand ?? 'PUSKITA' }} Perpustakaan Digital. All rights reserved.
            </p>
        </div>
    </div>
</footer>
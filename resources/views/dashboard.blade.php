<x-app-layout>
    <x-slot name="header">
        Dashboard Admin
    </x-slot>

    <div class="space-y-6">
        <!-- Welcome Card -->
        <div class="bg-gradient-to-r from-navy-card to-navy-light border border-navy-border rounded-2xl p-6 sm:p-8">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between">
                <div>
                    <h2 class="text-2xl sm:text-3xl font-bold text-white mb-2">
                        Selamat datang, <span class="text-cyan">{{ auth()->user()->name }}</span>
                    </h2>
                    <p class="text-slate-text text-sm sm:text-base">Anda login sebagai Administrator System</p>
                </div>
                <div class="mt-4 sm:mt-0 w-12 h-12 rounded-full bg-gradient-to-br from-cyan to-cyan-dark flex items-center justify-center text-white font-bold text-lg">
                    {{ substr(auth()->user()->name, 0, 1) }}
                </div>
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
            <div class="bg-navy-card border border-navy-border rounded-xl p-4 sm:p-6 hover:border-cyan/30 transition-all">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-slate-text text-xs sm:text-sm">Total Events</p>
                        <p class="text-2xl sm:text-3xl font-bold text-white mt-2">0</p>
                    </div>
                    <svg class="w-8 sm:w-10 h-8 sm:h-10 text-cyan/30" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
            </div>

            <div class="bg-navy-card border border-navy-border rounded-xl p-4 sm:p-6 hover:border-cyan/30 transition-all">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-slate-text text-xs sm:text-sm">Portfolios</p>
                        <p class="text-2xl sm:text-3xl font-bold text-white mt-2">0</p>
                    </div>
                    <svg class="w-8 sm:w-10 h-8 sm:h-10 text-cyan/30" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
            </div>

            <div class="bg-navy-card border border-navy-border rounded-xl p-4 sm:p-6 hover:border-cyan/30 transition-all">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-slate-text text-xs sm:text-sm">Testimonials</p>
                        <p class="text-2xl sm:text-3xl font-bold text-white mt-2">0</p>
                    </div>
                    <svg class="w-8 sm:w-10 h-8 sm:h-10 text-cyan/30" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h12a2 2 0 012 2v10a2 2 0 01-2 2h-3l-4 4z" />
                    </svg>
                </div>
            </div>

            <div class="bg-navy-card border border-navy-border rounded-xl p-4 sm:p-6 hover:border-cyan/30 transition-all">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-slate-text text-xs sm:text-sm">Users</p>
                        <p class="text-2xl sm:text-3xl font-bold text-white mt-2">0</p>
                    </div>
                    <svg class="w-8 sm:w-10 h-8 sm:h-10 text-cyan/30" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path d="M12 4.354a4 4 0 110 8 4 4 0 010-8zM19 8a6 6 0 11-12 0 6 6 0 0112 0z" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-navy-card border border-navy-border rounded-2xl p-6 sm:p-8">
            <h3 class="text-lg sm:text-xl font-bold text-white mb-4 sm:mb-6">Quick Actions</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-4">
                <a href="#" class="flex items-center gap-3 p-4 rounded-xl bg-navy/50 border border-navy-border hover:border-cyan/30 transition-all group">
                    <div class="flex-1">
                        <p class="text-white font-medium text-sm sm:text-base group-hover:text-cyan transition-colors">Manage Portfolios</p>
                        <p class="text-slate-text text-xs mt-1">View and edit portfolio items</p>
                    </div>
                    <svg class="w-5 h-5 text-cyan/30 group-hover:text-cyan transition-colors" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M9 5l7 7-7 7" />
                    </svg>
                </a>

                <a href="#" class="flex items-center gap-3 p-4 rounded-xl bg-navy/50 border border-navy-border hover:border-cyan/30 transition-all group">
                    <div class="flex-1">
                        <p class="text-white font-medium text-sm sm:text-base group-hover:text-cyan transition-colors">Manage Testimonials</p>
                        <p class="text-slate-text text-xs mt-1">View and moderate testimonials</p>
                    </div>
                    <svg class="w-5 h-5 text-cyan/30 group-hover:text-cyan transition-colors" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M9 5l7 7-7 7" />
                    </svg>
                </a>

                <a href="#" class="flex items-center gap-3 p-4 rounded-xl bg-navy/50 border border-navy-border hover:border-cyan/30 transition-all group">
                    <div class="flex-1">
                        <p class="text-white font-medium text-sm sm:text-base group-hover:text-cyan transition-colors">Manage Users</p>
                        <p class="text-slate-text text-xs mt-1">View and manage user accounts</p>
                    </div>
                    <svg class="w-5 h-5 text-cyan/30 group-hover:text-cyan transition-colors" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>
        </div>

        <!-- Recent Activity (placeholder) -->
        <div class="bg-navy-card border border-navy-border rounded-2xl p-6 sm:p-8">
            <h3 class="text-lg sm:text-xl font-bold text-white mb-4 sm:mb-6">Recent Activity</h3>
            <div class="text-center py-8 sm:py-12">
                <svg class="w-12 sm:w-16 h-12 sm:h-16 text-slate-text/30 mx-auto mb-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path d="M12 8v4m0 4v.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <p class="text-slate-text text-sm sm:text-base">No recent activity yet</p>
            </div>
        </div>
    </div>
</x-app-layout>

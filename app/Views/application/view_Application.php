<?php $session = session(); ?>
<!DOCTYPE html>
<html lang="en" class="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Applications Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <meta name="csrf-token" content="<?= csrf_hash() ?>">
    <meta name="csrf-name" content="<?= csrf_token() ?>">
    <style>
        /* Custom CSS for animations and dark mode */
        * {
            transition: background-color 0.3s ease, color 0.3s ease, border-color 0.3s ease;
        }
        
        body {
            font-family: 'Inter', sans-serif;
        }
        
        .dark {
            --tw-bg-opacity: 1;
            background-color: rgb(17 24 39 / var(--tw-bg-opacity));
            color: rgb(248 250 252 / var(--tw-text-opacity));
        }
        
        @keyframes slideInFromTop {
            0% { transform: translateY(-100%); opacity: 0; }
            100% { transform: translateY(0); opacity: 1; }
        }
        
        @keyframes slideInFromBottom {
            0% { transform: translateY(100%); opacity: 0; }
            100% { transform: translateY(0); opacity: 1; }
        }
        
        @keyframes slideInFromLeft {
            0% { transform: translateX(-100%); opacity: 0; }
            100% { transform: translateX(0); opacity: 1; }
        }
        
        @keyframes fadeIn {
            0% { opacity: 0; }
            100% { opacity: 1; }
        }
        
        .animate-slide-in-from-top {
            animation: slideInFromTop 0.5s ease-out;
        }
        
        .animate-slide-in-from-bottom {
            animation: slideInFromBottom 0.5s ease-out;
        }
        
        .animate-slide-in-from-left {
            animation: slideInFromLeft 0.5s ease-out;
        }
        
        .animate-fade-in {
            animation: fadeIn 0.3s ease-out;
        }
        
        /* Dark mode icon transitions */
        .dark #sun-icon {
            transform: rotate(-90deg) scale(0);
        }
        
        .dark #moon-icon {
            transform: rotate(0deg) scale(1);
        }
        
        #sun-icon {
            transform: rotate(0deg) scale(1);
        }
        
        #moon-icon {
            transform: rotate(90deg) scale(0);
        }
        
        /* Status badge styles */
        .status-badge {
            display: inline-flex;
            align-items: center;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 500;
            animation: fadeIn 0.3s ease-out;
        }
    </style>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                    colors: {
                        primary: {
                            50: '#eff6ff',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="min-h-screen bg-gradient-to-br from-blue-50 to-white dark:from-gray-900 dark:to-gray-800 transition-colors duration-300">
    <!-- Header -->
    <header class="border-b border-blue-200 dark:border-gray-700 bg-white/80 dark:bg-gray-900/80 backdrop-blur-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-6 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div class="h-8 w-8 bg-gradient-to-r from-blue-600 to-blue-700 rounded-lg flex items-center justify-center">
                        <span class="text-white font-bold text-sm">HR</span>
                    </div>
                    <div>
                        <h1 class="text-xl font-semibold text-gray-900 dark:text-white">Human Resources Portal</h1>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Application Management System</p>
                    </div>
                </div>

                <div class="flex items-center space-x-4">
                    <!-- Theme Toggle -->
                    <button id="theme-toggle" class="h-9 w-9 hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-colors duration-200 rounded-md flex items-center justify-center">
                        <svg id="sun-icon" class="h-4 w-4 rotate-0 scale-100 transition-all dark:-rotate-90 dark:scale-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="5"></circle>
                            <line x1="12" y1="1" x2="12" y2="3"></line>
                            <line x1="12" y1="21" x2="12" y2="23"></line>
                            <line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line>
                            <line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line>
                            <line x1="1" y1="12" x2="3" y2="12"></line>
                            <line x1="21" y1="12" x2="23" y2="12"></line>
                            <line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line>
                            <line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line>
                        </svg>
                        <svg id="moon-icon" class="absolute h-4 w-4 rotate-90 scale-0 transition-all dark:rotate-0 dark:scale-100" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path>
                        </svg>
                    </button>

                    <!-- Notifications -->
                    <button class="h-9 w-9 hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded-md flex items-center justify-center">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                            <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                        </svg>
                    </button>

                    <!-- User Profile Dropdown -->
                    <div class="relative">
                        <button id="profile-dropdown" class="flex items-center space-x-2 hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-colors duration-200 rounded-md px-2 py-1">
                            <div class="h-8 w-8 bg-blue-600 rounded-full flex items-center justify-center">
                                <span class="text-white text-sm font-medium">HR</span>
                            </div>
                            <div class="text-left">
                                <p class="text-sm font-medium text-gray-900 dark:text-white">Kedar Nath Behera</p>
                                <p class="text-xs text-gray-600 dark:text-gray-400">HR Manager</p>
                            </div>
                            <svg class="h-4 w-4 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <polyline points="6,9 12,15 18,9"></polyline>
                            </svg>
                        </button>
                        <div id="profile-menu" class="absolute right-0 mt-2 w-56 bg-white dark:bg-gray-800 rounded-md shadow-lg border border-gray-200 dark:border-gray-700 hidden">
                            <?php if ($session->get('role') === 'admin'): ?>
                            <a href="<?= site_url('admin/settings') ?>" class="flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <circle cx="12" cy="12" r="3"></circle>
                                    <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1 1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path>
                                </svg>
                                Settings
                            </a>
                            <?php endif; ?>
                            <hr class="border-gray-200 dark:border-gray-700">
                            <a href="<?= site_url('auth/logout') ?>" class="flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                    <polyline points="16,17 21,12 16,7"></polyline>
                                    <line x1="21" y1="12" x2="9" y2="12"></line>
                                </svg>
                                Sign out
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-6 py-8">
        <!-- Page Title -->
        <div class="mb-8">
            <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">Job Applications</h2>
            <p class="text-gray-600 dark:text-gray-400">Manage and review all job application submissions</p>
        </div>

        <!-- Status Cards -->
        <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-8">
            <div class="bg-yellow-50 dark:bg-yellow-900/20 border-0 rounded-lg p-4 hover:scale-105 transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Pending</p>
                        <p id="pending-value" class="text-2xl font-bold text-yellow-600"><?= $stats['pending'] ?></p>
                    </div>
                    <svg class="h-8 w-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="10"></circle>
                        <polyline points="12,6 12,12 16,14"></polyline>
                    </svg>
                </div>
            </div>

            <div class="bg-blue-50 dark:bg-blue-900/20 border-0 rounded-lg p-4 hover:scale-105 transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Under Review</p>
                        <p id="under-review-value" class="text-2xl font-bold text-blue-600"><?= $stats['under_review'] ?></p>
                    </div>
                    <svg class="h-8 w-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                        <circle cx="12" cy="12" r="3"></circle>
                    </svg>
                </div>
            </div>

            <div class="bg-purple-50 dark:bg-purple-900/20 border-0 rounded-lg p-4 hover:scale-105 transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Interviews</p>
                        <p id="interview-value" class="text-2xl font-bold text-purple-600"><?= $stats['interview'] ?></p>
                    </div>
                    <svg class="h-8 w-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                        <line x1="16" y1="2" x2="16" y2="6"></line>
                        <line x1="8" y1="2" x2="8" y2="6"></line>
                        <line x1="3" y1="10" x2="21" y2="10"></line>
                    </svg>
                </div>
            </div>

            <div class="bg-green-50 dark:bg-green-900/20 border-0 rounded-lg p-4 hover:scale-105 transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Accepted</p>
                        <p id="accepted-value" class="text-2xl font-bold text-green-600"><?= $stats['accepted'] ?></p>
                    </div>
                    <svg class="h-8 w-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                        <polyline points="22,4 12,14.01 9,11.01"></polyline>
                    </svg>
                </div>
            </div>

            <div class="bg-red-50 dark:bg-red-900/20 border-0 rounded-lg p-4 hover:scale-105 transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Rejected</p>
                        <p id="rejected-value" class="text-2xl font-bold text-red-600"><?= $stats['rejected'] ?></p>
                    </div>
                    <svg class="h-8 w-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="15" y1="9" x2="9" y2="15"></line>
                        <line x1="9" y1="9" x2="15" y2="15"></line>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Filters and Search -->
        <div class="bg-white dark:bg-gray-800 border border-blue-200 dark:border-gray-700 shadow-sm rounded-lg mb-6">
            <div class="p-6">
                <div class="flex flex-col lg:flex-row gap-4">
                    <form method="GET" class="flex-1" id="search-form" autocomplete="on">
                        <div class="relative">
                            <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <circle cx="11" cy="11" r="8"></circle>
                                <path d="M21 21l-4.35-4.35"></path>
                            </svg>
                            <input
                                id="search-input"
                                type="text"
                                name="search"
                                value="<?= esc($search ?? '') ?>"
                                placeholder="Search by name or email..."
                                class="pl-10 w-full px-3 py-2 border border-blue-200 dark:border-gray-600 rounded-md focus:border-blue-500 dark:focus:border-blue-400 transition-colors duration-200 bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                            />
                        </div>
                    </form>
                    <form method="GET" class="flex gap-3 items-center" id="filters-form">
                        <input type="hidden" name="search" value="<?= esc($search ?? '') ?>" />
                        <select name="status" onchange="this.form.submit()" class="w-44 px-3 py-2 border border-blue-200 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                            <option value="All">All Statuses</option>
                            <option value="Pending" <?= ($selectedStatus == 'Pending') ? 'selected' : '' ?>>Pending</option>
                            <option value="Accepted" <?= ($selectedStatus == 'Accepted') ? 'selected' : '' ?>>Accepted</option>
                            <option value="Rejected" <?= ($selectedStatus == 'Rejected') ? 'selected' : '' ?>>Rejected</option>
                            <option value="Under Review" <?= ($selectedStatus == 'Under Review') ? 'selected' : '' ?>>Under Review</option>
                            <option value="Interview Scheduled" <?= ($selectedStatus == 'Interview Scheduled') ? 'selected' : '' ?>>Interview Scheduled</option>
                        </select>
                        <select name="experience" onchange="this.form.submit()" class="w-44 px-3 py-2 border border-blue-200 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                            <option value="All">All Experience</option>
                            <option value="fresher" <?= ($selectedExperience == 'fresher') ? 'selected' : '' ?>>Fresher</option>
                            <option value="junior" <?= ($selectedExperience == 'junior') ? 'selected' : '' ?>>Junior</option>
                            <option value="mid-level" <?= ($selectedExperience == 'mid-level') ? 'selected' : '' ?>>Mid-level</option>
                            <option value="senior" <?= ($selectedExperience == 'senior') ? 'selected' : '' ?>>Senior</option>
                        </select>
                        <select name="position" onchange="this.form.submit()" class="w-44 px-3 py-2 border border-blue-200 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                            <option value="All">All Positions</option>
                            <option value="Tech">Tech</option>
                            <option value="Non-Tech">Non-Tech</option>
                        </select>
                    </form>
                </div>
            </div>
        </div>

        <!-- Applications Table -->
        <div id="applications-table-wrapper">
            <?php include(APPPATH . 'Views/application/_applications_table.php'); ?>
        </div>
    </main>

    <!-- Loading Spinner -->
    <div id="loading-spinner" style="display:none;position:fixed;top:0;left:0;width:100vw;height:100vh;z-index:9999;background:rgba(255,255,255,0.5);backdrop-filter:blur(2px);align-items:center;justify-content:center;">
        <div class="flex flex-col items-center justify-center h-full">
            <svg class="animate-spin h-12 w-12 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
            </svg>
            <span class="mt-4 text-blue-700 font-semibold">Loading...</span>
        </div>
    </div>

    <script>
        // Theme Management
        function initTheme() {
            const savedTheme = localStorage.getItem('theme') || 'light';
            document.documentElement.className = savedTheme;
        }

        function toggleTheme() {
            const currentTheme = document.documentElement.className;
            const newTheme = currentTheme === 'light' ? 'dark' : 'light';
            document.documentElement.className = newTheme;
            localStorage.setItem('theme', newTheme);
        }

        // Profile Dropdown
        function toggleProfileMenu() {
            const menu = document.getElementById('profile-menu');
            menu.classList.toggle('hidden');
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', (e) => {
            const dropdown = document.getElementById('profile-dropdown');
            const menu = document.getElementById('profile-menu');
            if (!dropdown.contains(e.target)) {
                menu.classList.add('hidden');
            }
        });

        // Event Listeners
        document.getElementById('theme-toggle').addEventListener('click', toggleTheme);
        document.getElementById('profile-dropdown').addEventListener('click', toggleProfileMenu);

        // Initialize
        document.addEventListener('DOMContentLoaded', () => {
            initTheme();
        });

        // Your existing AJAX functions
        function updateStatsUI(stats) {
            document.getElementById('pending-value').textContent = stats.pending;
            document.getElementById('under-review-value').textContent = stats.under_review;
            document.getElementById('interview-value').textContent = stats.interview;
            document.getElementById('accepted-value').textContent = stats.accepted;
            document.getElementById('rejected-value').textContent = stats.rejected;
        }

        function fetchAndUpdateStats() {
            showSpinner();
            fetch("<?= site_url('applications/get-stats') ?>")
                .then(res => res.json())
                .then(stats => {
                    updateStatsUI(stats);
                    hideSpinner();
                })
                .catch(() => hideSpinner());
        }

        function updateStatus(id, status) {
            showSpinner();
            const csrfName = document.querySelector('meta[name="csrf-name"]').getAttribute("content");
            const csrfHash = document.querySelector('meta[name="csrf-token"]').getAttribute("content");
            const formData = new FormData();
            formData.append('id', id);
            formData.append('status', status);
            formData.append(csrfName, csrfHash);

            fetch("<?= site_url('applications/update-status') ?>", {
                method: "POST",
                headers: {
                    "X-Requested-With": "XMLHttpRequest"
                },
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    if (status !== "Accepted") {
                        alert("Status updated");
                    }
                    fetchAndUpdateStats();
                    if (status === "Accepted") {
                        const dropdown = document.getElementById(`status_dropdown_${id}`);
                        if (dropdown && dropdown.parentNode) {
                            dropdown.parentNode.innerHTML = '<span class="status-badge bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-400">Accepted</span>';
                        }
                    }
                } else {
                    alert("Update failed: " + (data.message || "Server error"));
                }
            })
            .catch(err => {
                console.error(err);
                alert("AJAX request failed");
            });
        }

        function updatePosition(id, position) {
            showSpinner(); 
            const csrfName = document.querySelector('meta[name="csrf-name"]').getAttribute("content");
            const csrfHash = document.querySelector('meta[name="csrf-token"]').getAttribute("content");
            const formData = new FormData();
            formData.append('id', id);
            formData.append('position', position);
            formData.append(csrfName, csrfHash);

            fetch("<?= site_url('applications/update-position') ?>", {
                method: "POST",
                headers: {
                    "X-Requested-With": "XMLHttpRequest"
                },
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    alert("Position updated");
                    fetchAndUpdateStats();
                } else {
                    alert("Update failed: " + (data.message || "Server error"));
                }
            })
            .catch(err => {
                console.error(err);
                alert("AJAX request failed");
            });
        }

        // Spinner helpers
        function showSpinner() {
            document.getElementById('loading-spinner').style.display = 'flex';
        }
        function hideSpinner() {
            document.getElementById('loading-spinner').style.display = 'none';
        }

        // AJAX Table Update Helper
        function fetchApplicationsTable(params) {
            //it will showSpinner beforre every call
            showSpinner();
            fetch('<?= site_url('applications/ajax-applications') ?>?' + params.toString(), {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(res => res.text())
            .then(html => {
                document.getElementById('applications-table-wrapper').innerHTML = html;
                hideSpinner();
                bindPaginationLinks();
            })
            .catch(() => hideSpinner());
        }

        // Live search with debounce (already present, but now uses spinner)
        (function() {
            const searchInput = document.getElementById('search-input');
            const searchForm = document.getElementById('search-form');
            if (searchInput && searchForm) {
                let debounceTimeout;
                searchInput.addEventListener('input', function() {
                    clearTimeout(debounceTimeout);
                    debounceTimeout = setTimeout(function() {
                        const filtersForm = document.getElementById('filters-form');
                        const params = new URLSearchParams(new FormData(filtersForm));
                        params.set('search', searchInput.value);
                        fetchApplicationsTable(params);
                    }, 300);
                });
                searchForm.addEventListener('submit', function(e) { e.preventDefault(); });
            }
        })();

        // Live filtering via dropdowns (AJAX, no reload)
        (function() {
            const filtersForm = document.getElementById('filters-form');
            if (filtersForm) {
                filtersForm.querySelectorAll('select').forEach(function(select) {
                    select.addEventListener('change', function() {
                        const searchInput = document.getElementById('search-input');
                        const params = new URLSearchParams(new FormData(filtersForm));
                        if (searchInput) params.set('search', searchInput.value);
                        fetchApplicationsTable(params);
                    });
                });
                filtersForm.addEventListener('submit', function(e) { e.preventDefault(); });
            }
        })();

        // AJAX-based pagination
        function bindPaginationLinks() {
            document.querySelectorAll('#applications-table-wrapper .pagination a').forEach(function(link) {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    const url = new URL(link.href);
                    const params = new URLSearchParams(url.search);
                    fetchApplicationsTable(params);
                });
            });
            // Rows per page dropdown
            const perPageForm = document.querySelector('#applications-table-wrapper #perPageForm');
            if (perPageForm) {
                perPageForm.addEventListener('change', function(e) {
                    e.preventDefault();
                    const params = new URLSearchParams(new FormData(perPageForm));
                    fetchApplicationsTable(params);
                });
            }
        }
        // Initial bind for first load
        document.addEventListener('DOMContentLoaded', bindPaginationLinks);
    </script>
</body>
</html>

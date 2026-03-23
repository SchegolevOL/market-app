<script>
import {Link, usePage} from "@inertiajs/vue3";
import {ref, computed, onMounted, onUnmounted} from "vue";

export default {
    name: "AdminLayout",
    components: {
        Link
    },

    setup() {
        const page = usePage();
        const isSidebarOpen = ref(true);
        const isUserMenuOpen = ref(false);
        const isNotificationOpen = ref(false);
        const dropdownRef = ref(null);

        const toggleSidebar = () => {
            isSidebarOpen.value = !isSidebarOpen.value;
        };

        const toggleUserMenu = () => {
            isUserMenuOpen.value = !isUserMenuOpen.value;
        };

        const toggleNotification = () => {
            isNotificationOpen.value = !isNotificationOpen.value;
        };

        const closeAllDropdowns = () => {
            isUserMenuOpen.value = false;
            isNotificationOpen.value = false;
        };

        const handleClickOutside = (event) => {
            if (dropdownRef.value && !dropdownRef.value.contains(event.target)) {
                closeAllDropdowns();
            }
        };

        onMounted(() => {
            document.addEventListener('click', handleClickOutside);
        });

        onUnmounted(() => {
            document.removeEventListener('click', handleClickOutside);
        });

        const navigation = [
            {
                name: 'Dashboard',
                href: route('dashboard'),
                icon: 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6',
                match: ['Dashboard/Index'],
            },
            {
                name: 'Категории',
                href: route('admin.categories.index'),
                icon: 'M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z',
                match: ['Category'],
            },
            {
                name: 'Товары',
                href: route('admin.products.index'),
                icon: 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4',
                match: ['Product/Index', 'Product/Create', 'Product/Edit', 'Product/Show', 'Product/CreateChild', 'Product/Replicate'],
            },
            {
                name: 'Параметры',
                href: route('admin.params.index'),
                icon: 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2',
                match: ['Param'],
            },
            {
                name: 'Группы товаров',
                href: route('admin.product-groups.index'),
                icon: 'M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10',
                match: ['ProductGroup'],
            },
        ];

        const isActive = (item) => {
            const currentComponent = page.component.value || page.component;
            // Для Товаров проверяем точное совпадение, чтобы не совпадало с ProductGroup
            if (item.name === 'Товары') {
                return item.match.some(pattern => currentComponent.includes(pattern));
            }
            // Для Групп товаров исключаем совпадение с просто Product
            if (item.name === 'Группы товаров') {
                return item.match.some(pattern => currentComponent.includes(pattern)) && !currentComponent.includes('Product/Index') && !currentComponent.includes('Product/Create') && !currentComponent.includes('Product/Edit') && !currentComponent.includes('Product/Show');
            }
            return item.match.some(pattern => currentComponent.includes(pattern));
        };

        return {
            isSidebarOpen,
            isUserMenuOpen,
            isNotificationOpen,
            toggleSidebar,
            toggleUserMenu,
            toggleNotification,
            navigation,
            isActive,
            dropdownRef,
        };
    },
}
</script>

<template>
    <div class="flex h-screen bg-gray-100 dark:bg-gray-900 overflow-hidden">
        <!-- Sidebar Backdrop (Mobile) -->
        <transition
            enter-active-class="transition-opacity ease-linear duration-300"
            enter-from-class="opacity-0"
            enter-to-class="opacity-100"
            leave-active-class="transition-opacity ease-linear duration-300"
            leave-from-class="opacity-100"
            leave-to-class="opacity-0"
        >
            <div
                v-if="isSidebarOpen"
                @click="isSidebarOpen = false"
                class="fixed inset-0 bg-gray-600 bg-opacity-75 z-20 md:hidden"
            ></div>
        </transition>

        <!-- Sidebar -->
        <aside
            :class="isSidebarOpen ? 'translate-x-0' : '-translate-x-full'"
            class="fixed inset-y-0 left-0 z-30 w-72 bg-gradient-to-b from-slate-900 via-slate-800 to-slate-900 text-white transition-transform duration-300 ease-in-out md:translate-x-0 md:static md:inset-0 shadow-2xl"
        >
            <!-- Logo -->
            <div class="flex items-center justify-between h-20 px-6 border-b border-slate-700/50">
                <Link :href="route('dashboard')" class="flex items-center gap-3 group">
                    <div class="flex items-center justify-center w-10 h-10 bg-gradient-to-br from-emerald-400 to-cyan-500 rounded-xl shadow-lg group-hover:shadow-emerald-500/50 transition-shadow duration-200">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                    <span class="text-xl font-bold bg-gradient-to-r from-emerald-400 to-cyan-400 bg-clip-text text-transparent">
                        Market App
                    </span>
                </Link>
                <button @click="isSidebarOpen = false" class="md:hidden text-gray-400 hover:text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
                <div class="mb-6">
                    <p class="px-4 text-xs font-semibold text-slate-400 uppercase tracking-wider mb-3">
                        Основное меню
                    </p>
                    <div class="space-y-1">
                        <Link
                            v-for="item in navigation"
                            :key="item.name"
                            :href="item.href"
                            :class="[
                                isActive(item)
                                    ? 'bg-gradient-to-r from-emerald-500 to-cyan-500 text-white border-l-4 border-emerald-300 shadow-lg shadow-emerald-500/30'
                                    : 'text-slate-300 hover:bg-slate-700/50 hover:text-white border-l-4 border-transparent',
                                'group flex items-center px-4 py-3 text-sm font-medium rounded-r-xl transition-all duration-200'
                            ]"
                        >
                            <svg
                                :class="[
                                    isActive(item) ? 'text-white' : 'text-slate-400 group-hover:text-white',
                                    'mr-3 h-5 w-5 flex-shrink-0 transition-colors duration-200'
                                ]"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" :d="item.icon"/>
                            </svg>
                            {{ item.name }}
                        </Link>
                    </div>
                </div>

                <!-- Additional Links -->
                <div>
                    <p class="px-4 text-xs font-semibold text-slate-400 uppercase tracking-wider mb-3">
                        Дополнительно
                    </p>
                    <div class="space-y-1">
                        <a href="#" class="group flex items-center px-4 py-3 text-sm font-medium text-slate-300 hover:bg-slate-700/50 hover:text-white rounded-r-xl transition-all duration-200 border-l-4 border-transparent">
                            <svg class="mr-3 h-5 w-5 text-slate-400 group-hover:text-white transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                            </svg>
                            Сообщения
                            <span class="ml-auto inline-flex items-center justify-center px-2 py-0.5 text-xs font-bold leading-none text-white bg-red-500 rounded-full">3</span>
                        </a>
                        <a href="#" class="group flex items-center px-4 py-3 text-sm font-medium text-slate-300 hover:bg-slate-700/50 hover:text-white rounded-r-xl transition-all duration-200 border-l-4 border-transparent">
                            <svg class="mr-3 h-5 w-5 text-slate-400 group-hover:text-white transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                            Аналитика
                        </a>
                        <a href="#" class="group flex items-center px-4 py-3 text-sm font-medium text-slate-300 hover:bg-slate-700/50 hover:text-white rounded-r-xl transition-all duration-200 border-l-4 border-transparent">
                            <svg class="mr-3 h-5 w-5 text-slate-400 group-hover:text-white transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            Настройки
                        </a>
                    </div>
                </div>
            </nav>

            <!-- User Info (Bottom Sidebar) -->
            <div class="p-4 border-t border-slate-700/50">
                <div class="flex items-center gap-3 px-4 py-3 bg-slate-700/30 rounded-xl">
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 bg-gradient-to-br from-emerald-400 to-cyan-500 rounded-full flex items-center justify-center text-white font-bold shadow-lg">
                            A
                        </div>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-white truncate">{{$attrs.auth.user.name}}</p>
                        <p class="text-xs text-slate-400 truncate">{{$attrs.auth.user.email}}</p>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main Content Wrapper -->
        <div class="flex flex-col flex-1 overflow-hidden">
            <!-- Top Navigation Bar -->
            <header class="bg-white dark:bg-slate-800 border-b border-gray-200 dark:border-slate-700 shadow-sm">
                <div class="flex items-center justify-between h-16 px-4 sm:px-6 lg:px-8">
                    <!-- Left Side: Menu Toggle & Search -->
                    <div class="flex items-center gap-4 flex-1">
                        <button @click="isSidebarOpen = true" class="md:hidden text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                            </svg>
                        </button>

                        <!-- Search Bar -->
                        <div class="relative max-w-md w-full lg:max-w-xs">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </div>
                            <input
                                type="text"
                                placeholder="Поиск..."
                                class="block w-full pl-10 pr-3 py-2 border border-gray-300 dark:border-slate-600 rounded-xl leading-5 bg-gray-50 dark:bg-slate-700 text-gray-900 dark:text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 sm:text-sm transition-all duration-200"
                            >
                        </div>
                    </div>

                    <!-- Right Side: Actions -->
                    <div ref="dropdownRef" class="flex items-center gap-2 sm:gap-4">
                        <!-- Notifications -->
                        <div class="relative">
                            <button
                                @click.stop="toggleNotification"
                                class="relative p-2 text-gray-400 hover:text-gray-500 dark:hover:text-gray-300 focus:outline-none"
                            >
                                <span class="absolute top-1.5 right-1.5 w-2.5 h-2.5 bg-red-500 rounded-full border-2 border-white dark:border-slate-800"></span>
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                                </svg>
                            </button>

                            <!-- Notification Dropdown -->
                            <transition
                                enter-active-class="transition ease-out duration-200"
                                enter-from-class="opacity-0 scale-95"
                                enter-to-class="opacity-100 scale-100"
                                leave-active-class="transition ease-in duration-150"
                                leave-from-class="opacity-100 scale-100"
                                leave-to-class="opacity-0 scale-95"
                            >
                                <div
                                    v-if="isNotificationOpen"
                                    @click.stop
                                    class="absolute right-0 mt-2 w-80 bg-white dark:bg-slate-800 rounded-2xl shadow-2xl border border-gray-200 dark:border-slate-700 overflow-hidden z-50"
                                >
                                    <div class="px-4 py-3 border-b border-gray-200 dark:border-slate-700 flex items-center justify-between">
                                        <h3 class="text-sm font-semibold text-gray-900 dark:text-white">Уведомления</h3>
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400">
                                            3 новых
                                        </span>
                                    </div>
                                    <div class="max-h-96 overflow-y-auto">
                                        <a href="#" class="block px-4 py-3 hover:bg-gray-50 dark:hover:bg-slate-700/50 transition-colors duration-150 border-b border-gray-100 dark:border-slate-700">
                                            <div class="flex items-start gap-3">
                                                <div class="flex-shrink-0 w-10 h-10 bg-emerald-100 dark:bg-emerald-900/30 rounded-full flex items-center justify-center">
                                                    <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                                    </svg>
                                                </div>
                                                <div class="flex-1 min-w-0">
                                                    <p class="text-sm font-medium text-gray-900 dark:text-white">Новый заказ #1234</p>
                                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Клиент оформил заказ на сумму 5000₽</p>
                                                    <p class="text-xs text-gray-400 dark:text-gray-500 mt-2">5 минут назад</p>
                                                </div>
                                            </div>
                                        </a>
                                        <a href="#" class="block px-4 py-3 hover:bg-gray-50 dark:hover:bg-slate-700/50 transition-colors duration-150 border-b border-gray-100 dark:border-slate-700">
                                            <div class="flex items-start gap-3">
                                                <div class="flex-shrink-0 w-10 h-10 bg-blue-100 dark:bg-blue-900/30 rounded-full flex items-center justify-center">
                                                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                                    </svg>
                                                </div>
                                                <div class="flex-1 min-w-0">
                                                    <p class="text-sm font-medium text-gray-900 dark:text-white">Новый пользователь</p>
                                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Зарегистрировался новый клиент</p>
                                                    <p class="text-xs text-gray-400 dark:text-gray-500 mt-2">15 минут назад</p>
                                                </div>
                                            </div>
                                        </a>
                                        <a href="#" class="block px-4 py-3 hover:bg-gray-50 dark:hover:bg-slate-700/50 transition-colors duration-150">
                                            <div class="flex items-start gap-3">
                                                <div class="flex-shrink-0 w-10 h-10 bg-amber-100 dark:bg-amber-900/30 rounded-full flex items-center justify-center">
                                                    <svg class="w-5 h-5 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                                    </svg>
                                                </div>
                                                <div class="flex-1 min-w-0">
                                                    <p class="text-sm font-medium text-gray-900 dark:text-white">Заканчивается товар</p>
                                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Товар "iPhone 15" заканчивается</p>
                                                    <p class="text-xs text-gray-400 dark:text-gray-500 mt-2">1 час назад</p>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="px-4 py-3 bg-gray-50 dark:bg-slate-700/50 border-t border-gray-200 dark:border-slate-700">
                                        <a href="#" class="text-center text-sm font-medium text-emerald-600 dark:text-emerald-400 hover:text-emerald-500">
                                            Показать все уведомления →
                                        </a>
                                    </div>
                                </div>
                            </transition>
                        </div>

                        <!-- Messages -->
                        <a href="#" class="relative p-2 text-gray-400 hover:text-gray-500 dark:hover:text-gray-300">
                            <span class="absolute top-1.5 right-1.5 w-2.5 h-2.5 bg-emerald-500 rounded-full border-2 border-white dark:border-slate-800"></span>
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                            </svg>
                        </a>

                        <!-- Divider -->
                        <div class="hidden sm:block w-px h-6 bg-gray-300 dark:bg-slate-600"></div>

                        <!-- User Menu -->
                        <div class="relative">
                            <button
                                @click.stop="toggleUserMenu"
                                class="flex items-center gap-3 focus:outline-none"
                            >
                                <div class="flex-shrink-0 w-9 h-9 bg-gradient-to-br from-emerald-400 to-cyan-500 rounded-full flex items-center justify-center text-white font-bold shadow-md ring-2 ring-white dark:ring-slate-700">
                                    A
                                </div>
                                <div class="hidden md:block text-left">
                                    <p class="text-sm font-semibold text-gray-700 dark:text-gray-200">{{$attrs.auth.user.name}}</p>

                                    <p v-for="role in $attrs.auth.user.roles" class="text-xs text-gray-500 dark:text-gray-400">{{role.title}}</p>
                                </div>
                                <svg class="hidden md:block w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>

                            <!-- User Dropdown Menu -->
                            <transition
                                enter-active-class="transition ease-out duration-200"
                                enter-from-class="opacity-0 scale-95"
                                enter-to-class="opacity-100 scale-100"
                                leave-active-class="transition ease-in duration-150"
                                leave-from-class="opacity-100 scale-100"
                                leave-to-class="opacity-0 scale-95"
                            >
                                <div
                                    v-if="isUserMenuOpen"
                                    @click.stop
                                    class="absolute right-0 mt-2 w-56 bg-white dark:bg-slate-800 rounded-2xl shadow-2xl border border-gray-200 dark:border-slate-700 overflow-hidden z-50"
                                >
                                    <div class="px-4 py-3 border-b border-gray-200 dark:border-slate-700">
                                        <p class="text-sm font-semibold text-gray-900 dark:text-white">{{$attrs.auth.user.name}}</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 truncate">{{$attrs.auth.user.email}}</p>
                                    </div>
                                    <div class="py-2">
                                        <a href="#" class="flex items-center px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-slate-700/50 transition-colors duration-150">
                                            <svg class="mr-3 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                            </svg>
                                            Профиль
                                        </a>
                                        <a href="#" class="flex items-center px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-slate-700/50 transition-colors duration-150">
                                            <svg class="mr-3 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            </svg>
                                            Настройки
                                        </a>
                                    </div>
                                    <div class="border-t border-gray-200 dark:border-slate-700 py-2">
                                        <a href="#" class="flex items-center px-4 py-2.5 text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors duration-150">
                                            <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                            </svg>
                                            Выйти
                                        </a>
                                    </div>
                                </div>
                            </transition>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main Content Area -->
            <main class="flex-1 overflow-y-auto bg-gray-50 dark:bg-gray-900 p-4 sm:p-6 lg:p-8">
                <slot/>
            </main>
        </div>
    </div>
</template>

<style scoped>
/* Custom scrollbar for sidebar */
aside ::-webkit-scrollbar {
    width: 6px;
}

aside ::-webkit-scrollbar-track {
    background: rgba(255, 255, 255, 0.05);
}

aside ::-webkit-scrollbar-thumb {
    background: rgba(255, 255, 255, 0.2);
    border-radius: 3px;
}

aside ::-webkit-scrollbar-thumb:hover {
    background: rgba(255, 255, 255, 0.3);
}
</style>

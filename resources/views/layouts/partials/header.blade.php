<header class="flex items-center justify-between px-6 py-4 bg-white border-b-4 border-indigo-600">
    <div class="flex items-center justify-center gap-5">
        <img src="https://randomuser.me/api/portraits/men/1.jpg"
            class="w-12 h-12 border-2 border-indigo-600 rounded-full " alt="user photo">
        <div class="flex flex-col gap-1">
            <p class="font-bold">John Doe</p>
            <small class="inline-block -mt-2 font-semibold text-indigo-500">Owner</small>
        </div>
    </div>

    <a href="{{ route('auth.logout') }}">
        <x-button.primary>Logout</x-button.primary>
    </a>
</header>

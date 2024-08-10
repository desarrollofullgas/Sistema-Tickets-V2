<div class="hidden md:flex items-center justify-center">
    <x-dropdown align="right" width="80">
        <x-slot name="trigger">
            @if (Auth::user()->unreadNotifications->count() == 0)
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-6 h-6 cursor-pointer text-gray-600 dark:text-gray-400">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                </svg>
            @else
                <div class="top-0 absolute left-3">
                    <p class="flex h-2 w-2 items-center justify-center rounded-full bg-red-500 p-1">
                        
                    </p>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-6 h-6 cursor-pointer text-gray-600 dark:text-gray-400">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                </svg>
            @endif
        </x-slot>

        <x-slot name="content">
            <div class="block px-4 py-2 text-xs text-center text-gray-900 dark:text-white">
                @if (Auth::user()->unreadNotifications->count() == 1)
                    {{ __(Auth::user()->unreadNotifications->count() . ' ' . 'Notificación nueva.') }}
                @else
                    {{ __(Auth::user()->unreadNotifications->count() . ' ' . 'Notificaciones nuevas.') }}
                @endif
            </div>
            <div class="max-h-[320px] overflow-y-auto">
                @if ($this->notifications->count())
                    <ul class="divide-y divide-gray-100">
                        @foreach ($this->notifications as $notification)
                            <li wire:click="readNotification('{{ $notification->id }}')" @class(['bg-blue-200' => !$notification->read_at])>
                                <x-dropdown-link href="{{ $notification->data['url'] }}">
                                    <div class="flex">
                                       @if (isset($notification->data['userid']))
                                            @if (isset($notification->data['userid']['profile_photo_path']))
                                                <!-- Verifica si la propiedad "profile_photo_path" existe -->
                                                <figure class="flex-shrink-0 justify-center items-center">
                                                    <img class="h-10 w-10 rounded-full object-cover"
                                                        src="/storage/{{ $notification->data['userid']['profile_photo_path'] }}"
                                                        alt="{{ $notification->data['user'] }}">
                                                </figure>
                                            @else
                                                <figure class="flex-shrink-0 justify-center items-center">
                                                    <img class="h-10 w-10 rounded-full object-cover"
                                                        src="{{ $notification->data['userid']['profile_photo_url'] }}"
                                                        alt="{{ $notification->data['user'] }}">
                                                </figure>
                                            @endif
                                        @endif
                                        <div class="flex-1 ml-4">
                                            @if (isset($notification->data['user']))
                                                <!-- Verifica si la propiedad "user" existe -->
                                                <b>{{ $notification->data['user'] }}</b>
                                            @endif
                                            {{ $notification->data['message'] }}
                                            <div class="flex gap-20">
                                                <span class="block text-sm text-blue-600">
                                                    {{ $notification->created_at->diffForHumans() }}
                                                </span>
                                                @if ($notification->read_at != null)
                                                    <div style="display: flex; justify-content: flex-end;">
                                                        <div class="text-sm">
                                                            {{ __('Leído') }}
                                                        </div>
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                            fill="currentColor" class="w-5 h-5 text-blue-600">
                                                            <path fill-rule="evenodd"
                                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                                                                clip-rule="evenodd" />
                                                        </svg>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </x-dropdown-link>
                            </li>
                            <div class="border-t border-gray-100 dark:border-gray-700"></div>
                        @endforeach
                    </ul>
                    <div class="px-4 pt-2 pb-1 flex justify-center">
                        <button onclick="window.location.href = '{{ route('notificaciones') }}'" class="text-sm text-blue-500 font-semibold">
                            Ver más
                        </button>
                    </div>
                @else
                    <div>
                        <p align="center"><img src="{{ asset('img/logo/emptystate.svg') }}" style="max-width: 200px"
                                alt="Sin notificaciones nuevas"></p>
                    </div>
                @endif
            </div>
            @if (Auth::user()->unreadNotifications->count() >= 1)
                <div class="block px-4 py-2 text-xs text-center text-gray-400">
                    @if (Auth::user()->unreadNotifications->count() == 1)
                        <button wire:click="readAllNotification({{ $notification->notifiable_id }})"
                            class="text-xs justify-items-center content-center items-center text-gray-900 dark:text-white">Marcar
                            Como Leida</button>
                    @else
                        <button wire:click="readAllNotification({{ $notification->notifiable_id }})"
                            class="text-xs justify-items-center content-center items-center text-gray-900 dark:text-white">Marcar
                            Como Leidas</button>
                    @endif
                </div>
            @endif
        </x-slot>
    </x-dropdown>
</div>

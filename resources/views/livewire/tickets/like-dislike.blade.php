<div class="flex space-x-4">
    <button wire:click="toggleLike('like')" class="flex items-center justify-center space-x-2">
        <x-icons.like class="w-6 h-6 {{ $comentario->isLikeByLoggedInUser() ? 'text-blue-500' : 'text-gray-500' }}" />
        <span>
            {{ $comentario->likes->where('type', 'like')->count() }}
        </span>
    </button>
    
    <button wire:click="toggleLike('dislike')" class="flex items-center justify-center space-x-2">
        <x-icons.dislike class="w-6 h-6 {{ $comentario->isDislikeByLoggedInUser() ? 'text-red-500' : 'text-gray-500' }}" />
        <span>
            {{ $comentario->likes->where('type', 'dislike')->count() }}
        </span>
    </button>
</div>

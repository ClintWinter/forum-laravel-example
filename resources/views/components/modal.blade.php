<div {{$attributes}} x-data="{ open: false }">
    {{$trigger}}

    <div 
        class="fixed inset-0 px-4 pb-4 sm:flex sm:justify-center sm:items-center"
        x-show="open"
        x-cloak
    >
        <div
            class="fixed inset-0 transition-opacity"
            @click="open = false"
            x-show="open"
            x-cloak
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
        >
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>
        
        <div 
            x-show="open"
            x-cloak
            class="bg-white shadow-xl rounded-lg transform transition-all sm:max-w-lg sm:w-full" 
            role="dialog"
            aria-modal="true"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 transform origin-top scale-90 -translate-y-4"
            x-transition:enter-end="opacity-100 transform origin-top scale-100 translate-y-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 transform origin-top scale-100 translate-y-0"
            x-transition:leave-end="opacity-0 transform origin-top scale-90 -translate-y-4"
        >
            <div class="bg-white rounded-lg shadow px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                {{$slot}}
            </div>
        </div>
    </div>
</div>
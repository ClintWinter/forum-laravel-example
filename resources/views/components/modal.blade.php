<div {{$attributes}} x-data="{ open: false }">
    {{$trigger}}

    <div class="fixed inset-0 px-4 pb-4 sm:flex sm:justify-center sm:items-center" x-show="open">
        <div class="fixed inset-0 transition-opacity" @click="open = false">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>
        
        <div 
            class="bg-white shadow-xl rounded-lg transform transition-all sm:max-w-lg sm:w-full" 
            role="dialog"
            aria-modal="true"
        >
            <div class="bg-white rounded-lg shadow px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                {{$slot}}
            </div>
        </div>
    </div>
</div>
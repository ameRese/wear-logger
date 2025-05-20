@props(['message'])

@if ($message)
    <div {{ $attributes->merge(['class' => "fixed z-50 w-[calc(100%-32px)] max-w-xl mx-auto left-0 right-0 rounded-xl shadow-lg transition-opacity duration-300"]) }} role="alert" tabindex="-1" aria-labelledby="hs-toast-success-example-label" id="js-message-toast">
        <div class="flex justify-between items-center px-4 py-2">
            <p class="text-sm text-white font-semibold">
                {{ $message }}
            </p>
            <button type="button" id="js-close-toast" class="text-white focus:outline-none">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
    </div>

    @vite('resources/js/modules/toast.js')
@endif

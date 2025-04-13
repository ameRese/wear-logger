@props(['pages' => []])

<nav aria-label="Breadcrumb">
    <div class="overflow-x-auto">
        <ol class="flex items-center gap-1 text-sm text-gray-700 whitespace-nowrap">
            @foreach ($pages as $index => $page)
                <li class="max-w-[160px] md:max-w-[200px]">
                    <a href="{{ $page['url'] }}" title="{{ $page['name'] }}" class="block transition-colors hover:text-gray-900 truncate">
                        {{ $page['name'] }}
                    </a>
                </li>

                @if ($index < count($pages) - 1)
                    <li class="rtl:rotate-180 flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m9 20.247 6-16.5" />
                        </svg>
                    </li>
                @endif
            @endforeach
        </ol>
    </div>
</nav>

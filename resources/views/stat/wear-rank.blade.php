<x-app-layout>
    <x-slot name="header">
        <x-breadcrumb :pages="[
            ['name' => '統計情報', 'url' => route('stat.index')],
            ['name' => '着用回数ランキング', 'url' => route('stat.wear-rank')],
        ]" />
    </x-slot>
    <div class="flex items-center gap-2">
        <form method="GET" action="{{ route('stat.wear-rank') }}" class="inline-block">
            <select name="year" onchange="this.form.submit()" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                <option value="all" {{ $selectedYear == 'all' ? 'selected' : '' }}>全期間</option>
                @foreach($availableYears as $year)
                    <option value="{{ $year }}" {{ $selectedYear == $year ? 'selected' : '' }}>
                        {{ $year }}年
                    </option>
                @endforeach
            </select>
        </form>
        <span>の着用回数ランキング</span>
    </div>
    <x-item-list :items="$wearCountSortedItems" :showModal="false" :selectedYear="$selectedYear" />
</x-app-layout>

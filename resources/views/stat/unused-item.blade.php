<x-app-layout>
    <x-slot name="header">
        <x-breadcrumb :pages="[
            ['name' => '統計情報', 'url' => route('stat.index')],
            ['name' => '未使用アイテムリスト', 'url' => route('stat.unused-item')],
        ]" />
    </x-slot>
    <div class="container mx-auto flex items-center gap-2 mt-2 px-2">
        <form method="GET" action="{{ route('stat.unused-item') }}" class="inline-block">
            <select name="year" onchange="this.form.submit()" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                <option value="all" {{ $selectedYear == 'all' ? 'selected' : '' }}>全期間</option>
                @foreach($availableYears as $year)
                    <option value="{{ $year }}" {{ $selectedYear == $year ? 'selected' : '' }}>
                        {{ $year }}年
                    </option>
                @endforeach
            </select>
        </form>
        <span>に着用していないアイテム一覧</span>
    </div>
    <x-item-list :items="$unusedItems" :showModal="false" />
</x-app-layout>

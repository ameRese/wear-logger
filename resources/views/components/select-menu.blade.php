@props(['options', 'selected' => null, 'placeholder' => '選択してください'])

<select {{ $attributes->merge(['class' => 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm']) }}>
    <option value="">{{ $placeholder }}</option>

    @foreach ($options as $option)
        <option value="{{ $option->id }}" {{ $selected === $option->id ? 'selected' : '' }}>
            {{ $option->name }}
        </option>
    @endforeach
</select>

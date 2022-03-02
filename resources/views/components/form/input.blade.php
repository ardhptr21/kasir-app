@if ($isEdit)
    <div class="space-y-2">
        <input type="{{ $type }}" @if ($name) name="{{ $name }}" @endif
            placeholder="{{ $placeholder }}"
            class="w-full p-3 text-base border rounded-md outline-none focus-visible:shadow-none focus:border-indigo-600 disabled:cursor-not-allowed disabled:bg-gray-200 disabled:text-gray-500"
            {{ $attributes }} value="{{ $value }}" />
        @if ($error)
            <small class="inline-block text-red-500">* {{ $error }}</small>
        @endif
    </div>
@else
    <div class="flex justify-between gap-5">
        <div class="flex items-center justify-between font-bold" style="flex: 0.5">
            <h3>{{ $placeholder }}</h3>
            <span>:</span>
        </div>
        <p style="flex: 2">{{ $value }}</p>
    </div>
@endif

<div class="mb-5">
    @if ($isEdit)
        <input type="{{ $type }}" name="{{ $name }}" placeholder="{{ $placeholder }}"
            class="w-full p-3 text-base border rounded outline-none focus-visible:shadow-none focus:border-indigo-600"
            {{ $attributes }} value="{{ $value }}" />
    @else
        <div class="flex justify-between gap-5">
            <div class="flex items-center justify-between font-bold" style="flex: 0.5">
                <h3>{{ $placeholder }}</h3>
                <span>:</span>
            </div>
            <p style="flex: 2">{{ $value }}</p>
        </div>
    @endif
</div>

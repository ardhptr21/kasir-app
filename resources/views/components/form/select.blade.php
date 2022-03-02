@if ($isEdit)
    <select @if ($name) name="{{ $name }}" @endif
        class="w-full p-3 text-base border rounded-md outline-none focus-visible:shadow-none disabled:cursor-not-allowed disabled:bg-gray-200 disabled:text-gray-500"
        {{ $attributes }}>
        <option value="" hidden disabled selected>-- {{ $placeholder }} --</option>

        {{ $slot }}

    </select>
@else
    <div class="flex justify-between gap-5">
        <div class="flex items-center justify-between font-bold" style="flex: 0.5">
            <h3>{{ $placeholder }}</h3>
            <span>:</span>
        </div>
        <p style="flex: 2">{{ $value }}</p>
    </div>
@endif

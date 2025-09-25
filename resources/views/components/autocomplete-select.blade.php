<div>
    <label for="{{ $name }}">{{ $label }}</label>
    <div class="relative">
        @if($searchable)
            <!-- Searchable Input -->
            <input
                type="text"
                id="{{ $name }}"
                wire:model.live="{{ $wireModel }}"
                @if($wireFocus) wire:focus="{{ $wireFocus }}" @endif
                @if($wireClick && $clearOnClick) wire:click="{{ $wireClick }}" @endif
                placeholder="{{ $placeholder }}"
                autocomplete="off"
                wire:key="{{ $name }}-input-{{ md5($value ?? '') }}"
                class="input-control !pr-12">
        @else
            <!-- Non-searchable (readonly input) -->
            <input
                type="text"
                id="{{ $name }}"
                @if($wireClick) wire:click="{{ $wireClick }}" @endif
                value="@if($value && isset($options[$value])){{ $options[$value] }}@else{{ $value ?: $placeholder }}@endif"
                placeholder="{{ $placeholder }}"
                readonly
                class="input-control !pr-12 cursor-pointer">
        @endif
        
        <!-- Dropdown Arrow -->
        <button 
            type="button"
            @if($wireClick) wire:click="{{ $wireClick }}" @endif
            class="absolute flex items-center justify-center rounded-md inset-y-0 right-1.5 top-1.5 bottom-1.5 aspect-square bg-gray-100 hover:text-primary-600 transition-colors">
            <svg class="w-3 h-3 text-primary transition-transform {{ $attributes->get('dropdown-open') ? 'rotate-180' : '' }}" 
                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7" />
            </svg>
        </button>

        <!-- Dropdown -->
        @if($attributes->get('dropdown-open') && count($options) > 0)
            <div class="absolute z-10 w-full mt-1 bg-white border border-gray-300 rounded-lg shadow-lg max-h-60 overflow-auto"
                 x-data
                 x-on:click.outside="{{ $attributes->get('close-dropdown') }}">
                @foreach($options as $optionValue => $optionLabel)
                    <div 
                        wire:click="{{ $attributes->get('select-method') }}('{{ $optionValue }}')"
                        class="px-4 py-2 hover:bg-primary-50 cursor-pointer text-text-default hover:text-primary-600 transition-colors">
                        {{ $optionLabel }}
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
 {{-- <x-searchable-select
                        label="Cabang Kompetisi"
                        placeholder="Cari cabang..."
                        :options="$eventBranchOptions"
                        model="name"
                    />

______________________-
@props([
    'label' => 'Select Option',
    'placeholder' => 'Search...',
    'options' => [],
    'model' => '',
])

<div x-data="{
    search: '',
    showOptions: false,
    options: @js($options),
    select(option) {
        this.search = option;
        this.showOptions = false;
        $wire.set('{{ $model }}', option);
    }
}" class="relative w-full">
    <label class="block text-sm font-medium mb-1">{{ $label }}</label>

    <input
        type="text"
        x-model="search"
        @focus="showOptions = true"
        @input="showOptions = true"
        @click.away="showOptions = false"
        placeholder="{{ $placeholder }}"
        class="w-full border rounded-lg block disabled:shadow-none dark:shadow-none appearance-none text-base sm:text-sm py-2 h-10 leading-[1.375rem] ps-3 pe-3 bg-white dark:bg-white/10 dark:disabled:bg-white/[7%] text-zinc-700 disabled:text-zinc-500 placeholder-zinc-400 disabled:placeholder-zinc-400/70 dark:text-zinc-300 dark:disabled:text-zinc-400 dark:placeholder-zinc-400 dark:disabled:placeholder-zinc-500 shadow-xs border-zinc-200 border-b-zinc-300/80 disabled:border-b-zinc-200 dark:border-white/10 dark:disabled:border-white/5"
    />

    <ul
    x-show="showOptions && options.filter(o => o.toLowerCase().includes(search.toLowerCase())).length > 0"
    class="absolute z-10 w-full bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-white/10 mt-1 rounded-md max-h-48 overflow-y-auto shadow-lg"
    x-transition
>
    <template
        x-for="option in options.filter(o => o.toLowerCase().includes(search.toLowerCase()))"
        :key="option"
    >
        <li
            @click="select(option)"
            class="cursor-pointer px-4 py-2 hover:bg-blue-100 dark:hover:bg-zinc-700 text-zinc-800 dark:text-zinc-100"
            x-text="option"
        ></li>
    </template>
</ul>
</div>


                    --}}

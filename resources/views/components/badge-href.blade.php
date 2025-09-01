@if ($href=="#")
    <a class="inline-flex items-center">
@else
    <a href="{{ $href }}" class="inline-flex items-center">
@endif
        <flux:button  class="text-xs font-medium
        rounded-lg cursor-pointer bg-{{ $color }}-600"
        size="xs"
         variant="primary" type="button"  id="ini" >{{ $slot }}</flux:button>
    </a>

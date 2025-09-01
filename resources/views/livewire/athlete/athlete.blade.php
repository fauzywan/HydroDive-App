<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>



    <div class="flex flex-end justify-end gap-2">
        <flux:modal.trigger name="athlete-modal">
            <flux:button icon="plus-circle">Add Athlete</flux:button>
        </flux:modal.trigger>
    </div>

    <flux:modal name="athlete-modal" class="md:w-96" wire:submit="save">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">{{$modalText}} Athlete</flux:heading>
                <flux:text class="mt-2">{{ $modalSubText }}</flux:text>
            </div>
            <flux:input label="Name" placeholder="Your name" />
            <flux:input label="Date of birth" type="date" />
            <div class="flex">
                <flux:spacer />
                <flux:button type="submit" variant="primary">Save changes</flux:button>
            </div>
        </div>
    </flux:modal>
</div>

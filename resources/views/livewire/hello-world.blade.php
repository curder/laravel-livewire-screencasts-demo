<div>
    <select wire:model="greeting" multiple>
        <option>Hello</option>
        <option>Goodbye</option>
        <option>Adios</option>
    </select>

    <input wire:model="name" type="text"/>

    <input wire:model="loud" type="checkbox"/>

    <hr>
    {{ implode(', ', $greeting) }} {{ $name }} @if($loud) ! @endif

    <form action="#" wire:submit.prevent="$set('name', 'Bingo')">
        <button >Reset Name</button>
    </form>
</div>

<div>
    @foreach($contacts as $contact)
        @livewire('say-hi', ['contact' => $contact], key($contact->name))
    @endforeach

    <hr>
    {{ now() }}
    <button wire:click="$emit('refreshChildren')">Refresh Children</button>
</div>

<form action="#" method="POST" wire:submit.prevent="register">
    {{ $email }}
    <div>
        <label for="email">Email</label>
        <input wire:model="email" type="text" id="email" name="email">
    </div>
    <div>
        <label for="password">Password</label>
        <input wire:model="password" type="text" id="password" name="password">
    </div>
    <div>
        <label for="passwordConformation">Password Conformation</label>
        <input wire:model="passwordConformation" type="text" id="passwordConformation" name="passwordConformation">
    </div>

    <input type="submit" value="Register">
</form>

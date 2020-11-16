<form action="#" method="POST" wire:submit.prevent="register">
    <div>
        <label for="name">Name</label>
        <input wire:model="name" type="text" id="name" name="name">
        @error('name') {{ $message }} @enderror
    </div>
    <div>
        <label for="email">Email</label>
        <input wire:model="email" type="text" id="email" name="email">
        @error('email') {{ $message }} @enderror
    </div>
    <div>
        <label for="password">Password</label>
        <input wire:model="password" type="text" id="password" name="password">
        @error('password') {{ $message }} @enderror
    </div>
    <div>
        <label for="passwordConformation">Password Conformation</label>
        <input wire:model="passwordConformation" type="text" id="passwordConformation" name="passwordConformation">
        @error('passwordConformation') {{ $message }} @enderror
    </div>

    <input type="submit" value="Register">
</form>

<div>
    <input wire:model="search" type="text" placeholder="Search users..." class="form-control"/>
 
    <ul>
        @foreach($users as $user)
            <li>{{ $user->name }}</li>
        @endforeach
    </ul>
</div>

<div>
    <div class="card">
        <div class="card-header">
            <div class="input-group mb-3" >
                <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-magnifying-glass"></i></span>
                <input wire:model="search" type="text" class="form-control"  
                    placeholder="Ingrese una palabra para empezar a filtrar" aria-label="Username"
                    aria-describedby="basic-addon1">
                @livewire('create-products')
            </div>
        </div>
        <div class="card-body">
            <table class="table">
                <thead class="">
                    <tr>
                        <th scope="col" role="button" wire:click="order('id')">ID <i class="fa-solid fa-sort float-right text-secondary"></i></th>
                        <th scope="col" role="button" wire:click="order('nombre')">Nombre <i class="fa-solid fa-sort float-right text-secondary"></i></th>
                        <th scope="col" role="button" wire:click="order('valor')">Valor <i class="fa-solid fa-sort float-right text-secondary"></i></th>
                        <th scope="col" >Porcentaje</th>
                        <th scope="col">Acciones</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($datos as $item)
                        <tr data-id="$item->id">
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->nombre }}</td>
                            <td>{{ $item->valor }}</td>
                            <td>{{ $item->porcentaje }}</td>
                            <td>
                                <a href="">edit</a>
                            </td>
                        </tr>
                    @endforeach

                </tbody>

            </table>
        </div>
    </div>

</div>

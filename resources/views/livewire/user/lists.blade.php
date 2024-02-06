<div>
    <br />
    <div class="row">
        <div class="col">
            <!-- Large modal -->
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal"
                data-whatever="@mdo" wire:click="$dispatch('reset-file', { name: 'create' })">create user</button>
            <div wire:ignore.self class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Create user</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <livewire:user.create />
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <table class="table table-dark text-center">
                <thead>
                    <tr>
                        <th scope="col">name</th>
                        <th scope="col">email</th>
                        <th scope="col">image</th>
                        <th scope="col">edit</th>
                        <th scope="col">delete</th>
                        <th scope="col"><button wire:click="deleteAll" wire:confirm="{{ $sureMessage }}"
                                class="btn btn-sm btn-danger">delete</button> <input type="checkbox"
                                wire:model.change="stateSelectAll" /></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @if ($user->image)
                                    <img src="{{ asset($user->image->image) }}" width="40" alt="">
                                @else
                                    ندارد
                                @endif
                            </td>
                            <td>
                                <button data-toggle="modal" data-target="#exampleModal" class="btn btn-info btn-sm"
                                    wire:click="$dispatch('user-edit', {user: {{ $user }}})">Edit</button>
                            </td>
                            <td>
                                <button class="btn btn-danger btn-sm" wire:click="delete({{ $user->id }})"
                                    wire:confirm="مطمعنی میخوای حذف کنی ؟">delete</button>
                            </td>
                            <td>
                                <input type="checkbox" wire:model.change="fields" value="{{ $user->id }}" />
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

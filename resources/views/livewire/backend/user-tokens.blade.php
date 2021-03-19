<div>
    @can($this->authKey)

    @foreach($tokens as $token)
    <div class="row my-1 py-2">
        <div class="col-12 col-md-4 mb-1">
            {{ $token->name }}
        </div>
        <div class="col-md-4 mb-1">
            @can("backend.{$this->authKey}.delete")
            <button
                wire:click="deleteRelation({{$token->id}})"
                class="mr-0 btn btn-sm btn-icon btn-danger"
                type="button"
                title="{{ __('basic.actions.trash', ['name' => 'Token']) }}">
                <i class="fa fa-trash"></i>
            </button>
            @endif
        </div>
    </div>
    @endforeach

    <div class="row my-1 py-2">
        <div class="col-12 col-md-4 mb-1">
            <input type="text" name="token" wire:model="addedToken">
        </div>
        <div class="col-md-4">
            {{$plainTextToken}}
        </div>
        <div class="col-md-4 mb-1">
            @can("backend.{$this->authKey}.update")
                <button {{ ($saved) ? 'disabled' : '' }}
                wire:click="save"
                class="mr-0 btn btn-sm btn-icon{{ ($saved) ? ' d-none' : ' btn-info' }}"
                type="button"
                title="{{ __('basic.actions.save', ['name' => 'Token ']) }}">
                <i class="fa fa-save"></i>
            </button>
            @endif
        </div>
    </div>

    @else
    <div class="row pl-lg-4 my-4 d-none d-md-flex">
        {{ __('basic.access') }}
    </div>
    @endif
</div>

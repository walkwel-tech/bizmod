<form wire:submit.prevent="save" class="my-4 my-md-0">
    <div class="row pl-lg-4">
        <div class="col-12 col-md-5">
            <div class="form-group{{ $errors->has('model.code') ? ' has-error' : '' }}">
                @can("backend.{$this->authKey}.update")
                <input {{ ($trashed) ? 'disabled' : '' }} name="code" type="text" class="form-control{{ $errors->has('model.code') ? ' is-invalid' : '' }}" placeholder="{{ __('Code') }}" name="title" wire:model="model.code" required>
                @error('model.code') <span class="error text-sm text-danger">{{ $message }}</span> @enderror
                @else
                {{ $model['code'] }}
                @endif
            </div>
        </div>
        <div class="col-12 col-md-5">
            <div class="form-group{{ $errors->has('model.title') ? ' has-error' : '' }}">
                @can("backend.{$this->authKey}.update")
                <input {{ ($trashed) ? 'disabled' : '' }}  name="title" type="text" class="form-control{{ $errors->has('model.title') ? ' is-invalid' : '' }}" placeholder="{{ __('Title') }}" name="title" wire:model="model.title" required>
                @error('model.title') <span class="error text-sm text-danger">{{ $message }}</span> @enderror
                @else
                {{ $model['title'] }}
                @endif
            </div>
        </div>
        <div class="col-12 col-md-2 text-right">
            @can("backend.{$this->authKey}.update")
            <button
                {{ ($saved) ? 'disabled' : '' }}
                class="mr-0 btn btn-icon{{ ($saved) ? ' d-none' : ' btn-info' }}"
                title="{{ __('basic.actions.save', ['name' => $this->itemName]) }}"
            >
                <i class="fa fa-save"></i>
            </button>
            @endif

            @can("backend.{$this->authKey}.read")
                @if(!$trashed)
                    <a
                        href="{{ route($this->showRoute, $model['slug']) }}"
                        class="mr-0 btn btn-icon font-white{{ (!$saved) ? ' d-none' : ' btn-primary' }}"
                        title="{{ __('basic.actions.view', ['name' => $this->itemName]) }}"
                    >
                        <i class="fa fa-eye"></i>
                    </a>
                @endif
            @endif

            @can("backend.{$this->authKey}.delete")
            <button
                type="button"
                class="mr-0 btn btn-icon{{ ($trashed) ? ' btn-info' : ' btn-danger' }}"
                wire:click="toggleTrash"
                title="{{ ($trashed) ? __('basic.actions.restore', ['name' => $this->itemName]) : __('basic.actions.trash', ['name' => $this->itemName]) }}"
            >
                @if($trashed)
                <i class="fa fa-recycle"></i>
                @else
                <i class="fa fa-trash"></i>
                @endif
            </button>
            @endif
        </div>
    </div>
</form>

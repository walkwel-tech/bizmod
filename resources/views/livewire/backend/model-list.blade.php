<div>
    @can("backend.{$this->authKey}.read")
    <div class="row pl-lg-4 my-4 d-none d-md-flex">
        <div class="col-12 col-md-5"><span class="text-sm text-gray">Code</span></div>
        <div class="col-12 col-md-5"><span class="text-sm text-gray">Title</span></div>
    </div>

    @foreach ($children as $childModel)
        @livewire($this->childView, ['model' => $childModel], key($childModel->getKey()))
    @endforeach

    @can("backend.{$this->authKey}.create")
    <form wire:submit.prevent="addItem" class="my-4 my-md-0">
        <div class="row pl-lg-4">
            <div class="col-12 col-md-5">
                <div class="form-group{{ $errors->has('item.code') ? ' has-error' : '' }}">
                    <input name="code" type="text" class="form-control{{ $errors->has('item.code') ? ' is-invalid' : '' }}" placeholder="{{ __('Code') }}" name="title" wire:model="item.code" required>
                    @error('item.code') <span class="error text-sm text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="col-12 col-md-5">
                <div class="form-group{{ $errors->has('item.title') ? ' has-error' : '' }}">
                    <input  name="title" type="text" class="form-control{{ $errors->has('item.title') ? ' is-invalid' : '' }}" placeholder="{{ __('Title') }}" name="title" wire:model="item.title" required>
                    @error('item.title') <span class="error text-sm text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="col-12 col-md-2 text-right">
                <button {{ ($created) ? 'disabled' : '' }} class="mr-0 btn btn-icon{{ ($created) ? ' d-none' : ' btn-info' }}"><i class="fa fa-plus"></i></button>
            </div>
        </div>
    </form>
    @endif
    @else
    <div class="row pl-lg-4 my-4 d-none d-md-flex">
        {{ __('basic.access') }}
    </div>
    @endif
</div>

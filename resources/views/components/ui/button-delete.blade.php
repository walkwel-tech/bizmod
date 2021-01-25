<div class="d-flex justify-content-center">
    @if($trashed)
        <form class="form--model-recovery confirm-submission"
            action="{{ $routes['restore'] }}" method="post"
            data-alert-type="info" data-alert-title="{{ __('basic.actions.restore', ['name' => $modelName]) }}"
            data-alert-message="{{ __('basic.actions.confirm.restore', ['name' => $modelName]) }}">
            @csrf
            @method('post')
            <input type="hidden" name="{{ Str::snake($modelName) }}" value="{{ $identifier }}">
            <button type="submit" class="btn btn-block btn-info btn-icon btn-icon-md rounded-0"  data-toggle="tooltip" data-placement="top" title="{{ __('basic.actions.restore', ['name' => $modelName]) }}">
                <i class="fa fa-recycle"></i>
            </button>
        </form>

        <form class="form--model-deletion confirm-submission"
            action="{{ $routes['delete'] }}" method="post"
            data-alert-type="error" data-alert-title="{{ __('basic.actions.permanent_delete', ['name' => $modelName]) }}"
            data-alert-message="{{ __('basic.actions.confirm.permanent_delete', ['name' => $modelName]) }}">
            @csrf
            @method('delete')
            <input type="hidden" name="{{ Str::snake($modelName) }}" value="{{ $identifier }}">

            <button type="submit" class="btn btn-block btn-danger btn-icon btn-icon-md rounded-0"  data-toggle="tooltip" data-placement="top" title="{{ __('basic.actions.permanent_delete', ['name' => $modelName]) }}">
                <i class="fa fa-trash"></i>
            </button>
        </form>
        @else
        <form class="form--model-deletion confirm-submission"
            action="{{ $routes['destroy'] }}" method="post"
            data-alert-type="error" data-alert-title="{{ __('basic.actions.delete', ['name' => $modelName]) }}"
            data-alert-message="{{ __('basic.actions.confirm.delete', ['name' => $modelName]) }}">
            @csrf
            @method('delete')
            <input type="hidden" name="{{ Str::snake($modelName) }}" value="{{ $identifier }}">

            <button type="submit" class="btn btn-block btn-danger btn-icon btn-icon-md rounded-0"  data-toggle="tooltip" data-placement="top" title="{{ __('basic.actions.delete', ['name' => $modelName]) }}">
                <i class="fa fa-trash"></i>
            </button>
        </form>
        @endif
</div>

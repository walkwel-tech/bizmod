<div class="dropdown">
    <a {{ $attributes->merge(['class' => "btn btn-block btn-icon btn-icon-md btn-link rounded-0"]) }} href="#" role="button"
        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fas fa-ellipsis-v"></i>
    </a>
    <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
        {{ $slot }}
    </div>
</div>

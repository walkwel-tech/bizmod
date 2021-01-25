<div>
    @can($this->authKey)
        @foreach($users as $user)
            @livewire('backend.project-user', ['user' => $user], key($user->getKey()))
        @endforeach

        @livewire('backend.project-new-user', ['project' => $project], key($project->getKey()))
    @else
    <div class="row pl-lg-4 my-4 d-none d-md-flex">
        {{ __('basic.access') }}
    </div>
    @endif
</div>

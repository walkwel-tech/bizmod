<div>
    @can($this->authKey)
        @foreach($users as $user)
            @livewire('backend.business-user', ['user' => $user, 'business' => $business], key($user->getKey()))
        @endforeach

        @livewire('backend.business-new-user', ['business' => $business], key($business->getKey()))
    @else
    <div class="row pl-lg-4 my-4 d-none d-md-flex">
        {{ __('basic.access') }}
    </div>
    @endif
</div>

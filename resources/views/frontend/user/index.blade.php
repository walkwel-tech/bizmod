@extends('layouts.app')

@section('content')
<div class="page-header">
    <form action="{{ route('thread.index') }}" method="get">
        <button class="back-button"><img src="{{ asset('images/reply.png') }}" alt="" />Back to Topics</button>
    </form>
</div>
<div class="d-flex">
    <div class="user-profile">
        <div class="user-profile-details">
            <div class="d-flex flex-wrap user-profile-user">
                <div class="user-image">
                    <img src="{{ asset('images/user-default.jpg') }}" alt="" />
                </div>
                <div class="user-details d-flex justify-content-center flex-column">
                    <h2>SeizureAdvocate</h2>
                    <p>amazyell190@gmail.com</p>
                </div>
                    <div class="user-edit mr-4 ml-auto">
                        <img src="{{ asset('images/edit.png') }}" alt="" />
                    </div>
                <div class="user-cat-stats d-flex justify-content-center align-items-center">
                    <div class="user-stats">
                        <ul class="d-flex">
                            <li>
                               04<span>Best Answers</span>
                            </li>
                            <li>
                                19<span>Replies</span>
                            </li>
                            <li>
                                03<span>Questions</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="timeline-wrapper">
            <h4 class="mt-4 pt-4">Your Activitiy</h4>
            <ul class="timeline timeline-vertical">
                <li class="timeline-recent">
                    <div class="timeline--circle">        
                        <i></i>
                    </div>
                    <div class="timeline--description">
                    <small>1 minute ago</small>
                    <h6><img src="{{ asset('images/reply.png') }}" alt="" />Replied to <a href="">Is a ejection fraction of 67% on a heart echo okay?</a></h6>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. </p>
                    </div>
                </li>
                <li>
                    <div class="timeline--circle">        
                        <i></i>
                    </div>
                    <div class="timeline--description">
                    <small>1 minute ago</small>
                    <h6><img src="{{ asset('images/reply.png') }}" alt="" />Replied to <a href="">Is a ejection fraction of 67% on a heart echo okay?</a></h6>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. </p>
                    </div>
                </li>
                <li>
                    <div class="timeline--circle">        
                        <i></i>
                    </div>
                    <div class="timeline--description">
                    <small>1 minute ago</small>
                    <h6><img src="{{ asset('images/reply.png') }}" alt="" />Replied to <a href="">Is a ejection fraction of 67% on a heart echo okay?</a></h6>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. </p>
                    </div>
                </li> 
            </ul>
        </div>
    </div>
</div>
<a href="#" class="float-button">
    <img src="{{ asset('images/reply-white.png') }}" alt="" />
</a>
@endsection
<div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
    <div class="container-fluid">
        <div class="header-body">
            <!-- Card stats -->
            <div class="row">
                <div class="col-xl-3 col-lg-6">
                    <x-stats-card title="Business" stats="{{$businessThisMonth}}" value="{{ $businessLastMonthAvg }}%" text="Since last month" icon="fas fa-chart-bar" icon-bg="gradient-danger"></x-stats-card>
                </div>
                <div class="col-xl-3 col-lg-6">
                    <x-stats-card title="New Clients" stats="{{ $clientThisMonth }}" value="{{ $clientLastMonthAvg }}%" text="Since last month" icon="fas fa-chart-pie" icon-bg="warning"></x-stats-card>
                </div>
                <div class="col-xl-3 col-lg-6">
                    <x-stats-card title="New Codes" stats="{{ $codeThisMonth }}" value="{{ $codeLastMonthAvg }}%" text="Since last month" icon="fas fa-users" icon-bg="yellow"></x-stats-card>
                </div>
                <div class="col-xl-3 col-lg-6">
                    <x-stats-card title="Code Claimed" stats="{{ $codeThisMonthClaimed }}" value="{{ $codeLastMonthClaimedAvg }}%" text="Since last month" icon="fas fa-percent" icon-bg="info"></x-stats-card>
                </div>
            </div>
        </div>
    </div>
</div>

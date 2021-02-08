<div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
    <div class="container-fluid">
        <div class="header-body">
            <!-- Card stats -->
            <div class="row">
                <div class="col-xl-3 col-lg-6">
                    <x-stats-card title="Business" stats="{{$businessThisMonth  ?? '1'}}" value="{{ $businessLastMonthAvg ?? '2'}}%" text="Since last month" icon="fas fa-industry" icon-bg="gradient-danger"></x-stats-card>
                </div>
                <div class="col-xl-3 col-lg-6">
                    <x-stats-card title="New Clients" stats="{{ $clientThisMonth ?? '3' }}" value="{{ $clientLastMonthAvg ?? '10' }}%" text="Since last month" icon="fas fa-users" icon-bg="warning"></x-stats-card>
                </div>
                <div class="col-xl-3 col-lg-6">
                    <x-stats-card title="New Codes" stats="{{ $codeThisMonth ?? '8' }}" value="{{ $codeLastMonthAvg ?? '2.3' }}%" text="Since last month" icon="fas fa-barcode" icon-bg="yellow"></x-stats-card>
                </div>
                <div class="col-xl-3 col-lg-6">
                    <x-stats-card title="Code Claimed" stats="{{ $codeThisMonthClaimed ?? '5'}}" value="{{ $codeLastMonthClaimedAvg ?? '6'}}%" text="Since last month" icon="fas fa-barcode" icon-bg="info"></x-stats-card>
                </div>
            </div>
        </div>
    </div>
</div>

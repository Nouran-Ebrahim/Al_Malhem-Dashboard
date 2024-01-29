@extends('common::layouts.master')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('') }}admin/vendors/css/charts/apexcharts.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('') }}admin/css-rtl/plugins/charts/chart-apex.css">
@endsection

@section('content')
    <!-- Dashboard Ecommerce Starts -->
    <section id="dashboard-ecommerce">
        <div class="row match-height">
            <!-- Greetings Card starts -->
            <div class="col-lg-6 col-md-12 col-sm-12">
                <div class="card card-congratulations">
                    <div class="card-body text-center">
                        <img src="{{ asset('') }}admin/images/elements/decore-left.png" class="congratulations-img-left"
                            alt="card-img-left" />
                        <img src="{{ asset('') }}admin/images/elements/decore-right.png"
                            class="congratulations-img-right" alt="card-img-right" />
                        <div class="avatar avatar-xl bg-primary shadow">
                            <div class="avatar-content">
                                <i data-feather="award" class="font-large-1"></i>
                            </div>
                        </div>
                        <div class="text-center">
                            <h1 class="mb-1 text-white">اهلا بـك، {{ auth()->user()->name }}</h1>
                            <p class="card-text m-auto w-75">
                                {{-- You have done <strong>57.6%</strong> more sales today. Check your new badge in your profile. --}}
                                يمكنك ادارة قبيلتك بسهوله من خلال ال <strong>dashboard</strong> و <strong>mobile
                                    aplication</strong>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Greetings Card ends -->

            <!-- Subscribers Chart Card starts -->
            <div class="col-lg-3 col-sm-6 col-12">
                <div class="card">
                    <div class="card-header flex-column align-items-start pb-0">
                        <div class="avatar bg-light-primary p-50 m-0">
                            <div class="avatar-content">
                                <i data-feather="users" class="font-medium-5"></i>
                            </div>
                        </div>
                        <h2 class="fw-bolder mt-1">{{ $activeClients->count() }} فرد</h2>
                        <p class="card-text">الاعضاء المفعلين</p>
                    </div>
                    <div id="gained-chart"></div>
                </div>
            </div>
            <!-- Subscribers Chart Card ends -->

            <!-- Orders Chart Card starts -->
            <div class="col-lg-3 col-sm-6 col-12">
                <div class="card">
                    <div class="card-header flex-column align-items-start pb-0">
                        <div class="avatar bg-light-warning p-50 m-0">
                            <div class="avatar-content">
                                {{-- <i data-feather="package" class="font-medium-5"></i> --}}
                                <i data-feather="users" class="font-medium-5"></i>
                            </div>
                        </div>
                        <h2 class="fw-bolder mt-1">{{ $notActiveClients }} فرد</h2>
                        <p class="card-text">الاعضاء الغير مفعلين </p>
                    </div>
                    <div id="order-chart"></div>
                </div>
            </div>
            <!-- Orders Chart Card ends -->
        </div>
        <div class="row match-height mt-2">
            <!-- Avg Sessions Chart Card starts -->

            <div class="col-lg-6 col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row pb-50 justify-content-center">
                            {{-- <div
                                class="col-sm-6 col-12 d-flex justify-content-between flex-column order-sm-1 order-2 mt-1 mt-sm-0">
                                <div class="mb-1 mb-sm-0">
                                    <h2 class="fw-bolder mb-25">2.7K</h2>
                                    <p class="card-text fw-bold mb-2">Avg Sessions</p>
                                    <div class="font-medium-2">
                                        <span class="text-success me-25">+5.2%</span>
                                        <span>vs last 7 days</span>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-primary">View Details</button>
                            </div> --}}
                            <div
                                class="col-sm-6 col-12 d-flex justify-content-between  flex-column text-end order-sm-2 order-1">
                                <div class="align-self-start">
                                    <h4>
                                        اخر {{ $lastDaysCount }} يوم
                                    </h4>
                                    {{-- <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownItem5">
                                        <a class="dropdown-item" href="#">Last 28 Days</a>
                                        <a class="dropdown-item" href="#">Last Month</a>
                                        <a class="dropdown-item" href="#">Last Year</a>
                                    </div> --}}
                                </div>
                                <div class="" id="avg-sessions-chart"></div>
                            </div>
                        </div>
                        <hr />
                        <div class="row avg-sessions pt-50">
                            <div class="col-6 mb-2">
                                <p class="mb-50">المجالس الغير مفعلة :{{ $NotActivemeeting }}</p>
                                <div class="progress progress-bar-primary" style="height: 6px">
                                    <div class="progress-bar" role="progressbar"
                                        aria-valuenow="{{ $notActivemeetingPersentage }}" aria-valuemin="0"
                                        aria-valuemax="100" style="width: {{ $notActivemeetingPersentage }}%"></div>
                                </div>
                            </div>
                            <div class="col-6 mb-2">
                                <p class="mb-50">المجالس المفعلة : {{ $Activemeeting }}</p>
                                <div class="progress progress-bar-warning" style="height: 6px">
                                    <div class="progress-bar" role="progressbar"
                                        aria-valuenow="{{ $activemeetingPersentage }}" aria-valuemin="0"
                                        aria-valuemax="100" style="width: {{ $activemeetingPersentage }}%"></div>
                                </div>
                            </div>
                            <div class="col-6">
                                <p class="mb-50">الحفلات الغير مفعلة : {{ $notActiveParty }}</p>
                                <div class="progress progress-bar-danger" style="height: 6px">
                                    <div class="progress-bar" role="progressbar"
                                        aria-valuenow="{{ $notActivePartyPersentage }}" aria-valuemin="0"
                                        aria-valuemax="100" style="width: {{ $notActivePartyPersentage }}%"></div>
                                </div>
                            </div>
                            <div class="col-6">
                                <p class="mb-50">الحفلات المفعلة : {{ $activeParty }}</p>
                                <div class="progress progress-bar-success" style="height: 6px">
                                    <div class="progress-bar" role="progressbar"
                                        aria-valuenow="{{ $activePartyPersentage }}" aria-valuemin="0" aria-valuemax="100"
                                        style="width: {{ $activePartyPersentage }}%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Avg Sessions Chart Card ends -->

            <!-- Support Tracker Chart Card starts -->
            <div class="col-lg-6 col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between pb-0">
                        <h4 class="card-title">المناسبات </h4>
                        <div class="dropdown chart-dropdown">
                            <h4>
                                اخر {{ $lastDaysCount }} يوم
                            </h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-2 col-12 d-flex flex-column flex-wrap text-center">
                                <h1 class="font-large-2 fw-bolder mt-2 mb-0">{{ $occasions }}</h1>
                                <p class="card-text">مناسبة</p>
                            </div>
                            <div class="col-sm-10 col-12 d-flex justify-content-center">
                                <div id="support-trackers-chart"></div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between mt-1">
                            <div class="text-center">
                                <p class="card-text mb-50">الاخبار المفعلة</p>
                                <span class="font-large-1 fw-bold">{{ $Activenews }}</span>
                            </div>
                            <div class="text-center">
                                <p class="card-text mb-50">الاخبار الغير مفعلة</p>
                                <span class="font-large-1 fw-bold">{{ $NotActiveenews }}</span>
                            </div>
                            <div class="text-center">
                                <p class="card-text mb-50">المتفوقين المفعلين</p>
                                <span class="font-large-1 fw-bold">{{ $superiorActive }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Support Tracker Chart Card ends -->
        </div>


        </div>




    </section>
    <!-- Dashboard Ecommerce ends -->
@endsection

@section('js')
    <script src="{{ asset('') }}admin/vendors/js/charts/apexcharts.min.js"></script>
    {{-- <script src="{{ asset('') }}admin/vendors/js/charts/dashboard-analytics.js"></script> --}}
    <script type="text/javascript">
        var occasionsActivePresentage = "<?= $occasionsActivePresentage ?>";
    </script>

    <script src="{{ asset('') }}admin/vendors/js/charts/dashboard-analytics.min.js"></script>
@endsection

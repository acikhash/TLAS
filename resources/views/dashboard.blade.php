@extends('layouts.user_type.auth')

@section('content')
    @foreach ($faculties as $faculty)
        <h5 class="font-weight-bolder mb-0">{{ $faculty->code }}&nbsp;{{ $faculty->name }}</h5>
        <!-- Inline clickable icon -->
        <i class="fa fa-plus-circle text-primary cursor-pointer" style="margin-left: 10px;"
            onclick="toggleDept('toggleDept-{{ $faculty->code }}')"></i>
        <div class="row" id="toggleDept-{{ $faculty->code }}">
            @foreach ($faculty->departments as $dept)
                <h5 class="mb-0">{{ $dept->code }}&nbsp;{{ $dept->name }}</h5>
                <!-- Inline clickable icon -->
                <i class="fa fa-plus-circle text-primary cursor-pointer" style="margin-left: 10px;"
                    onclick="toggleDept('toggleDept-{{ $dept->code }}')"></i>
                <div id="toggleDept-{{ $dept->code }}" hidden>
                    @if (isset($staffs[$dept->code]))
                        <!-- Check if staff data exists for this department -->

                        @php
                            $data = $staffs[$dept->code];
                        @endphp

                        <!-- Highest Credit Hour Card -->
                        <div class="col-xl-6 col-sm-6 mb-xl-0 mb-4">
                            <div class="card">
                                <div class="card-body p-3">
                                    <div class="row">
                                        <div class="col-8">
                                            <div class="numbers">
                                                <p class="text-sm mb-0 text-capitalize font-weight-bold">Highest Credit Hour
                                                </p>
                                                <h6 class="font-weight-bolder mb-0">
                                                    {{ $data['highest']->title }}{{ $data['highest']->name }}
                                                    <span
                                                        class="text-success text-sm font-weight-bolder">{{ $data['highest']->total_credit }}</span>
                                                </h6>
                                            </div>
                                        </div>
                                        <div class="col-4 text-end">
                                            <div
                                                class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                                                <i class="fa fa-arrow-trend-up text-lg opacity-10" aria-hidden="true"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Lowest Credit Hour Card -->
                        <div class="col-xl-6 col-sm-6 mb-xl-0 mb-4">
                            <div class="card">
                                <div class="card-body p-3">
                                    <div class="row">
                                        <div class="col-8">
                                            <div class="numbers">
                                                <p class="text-sm mb-0 text-capitalize font-weight-bold">Lowest Credit Hour
                                                </p>
                                                <h6 class="font-weight-bolder mb-0">
                                                    {{ $data['lowest']->title }}{{ $data['lowest']->name }}
                                                    <span
                                                        class="text-success text-sm font-weight-bolder">{{ $data['lowest']->total_credit }}</span>
                                                </h6>
                                            </div>
                                        </div>
                                        <div class="col-4 text-end">
                                            <div
                                                class="icon icon-shape bg-gradient-warning shadow text-center border-radius-md">
                                                <i class="fa fa-arrow-trend-down text-lg opacity-10" aria-hidden="true"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="col-xl-12 col-sm-6 mb-xl-0 mb-4">
                            <div class="card">
                                <div class="card-body p-3">
                                    <div class="row">
                                        <div class="col-8">
                                            <div class="numbers">
                                                <p class="text-sm mb-0 text-capitalize font-weight-bold">No Record Found</p>
                                                <h6 class="font-weight-bolder mb-0">

                                                    <span class="text-success text-sm font-weight-bolder"></span>
                                                </h6>
                                            </div>
                                        </div>
                                        <div class="col-4 text-end">
                                            <div
                                                class="icon icon-shape bg-gradient-warning shadow text-center border-radius-md">
                                                <i class="fa fa-arrow-trend-down text-lg opacity-10" aria-hidden="true"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    @endforeach
@endsection
<script>
    function toggleDept(id) {
        const element = document.getElementById(id);
        if (element) {
            element.hidden = !element.hidden;
        }
    }
</script>

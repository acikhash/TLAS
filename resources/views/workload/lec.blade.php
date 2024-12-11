@extends('layouts.user_type.auth')

@section('content')
    <div>
        @if ($errors->any())
            <div class="mt-3  alert alert-primary alert-dismissible fade show" role="alert">
                <span class="alert-text text-white">
                    {{ $errors->first() }}</span>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    <i class="fa fa-close" aria-hidden="true"></i>
                </button>
            </div>
        @endif
        @if (session('success'))
            <div class="m-3  alert alert-success alert-dismissible fade show" id="alert-success" role="alert">
                <span class="alert-text text-white">
                    {{ session('success') }}</span>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    <i class="fa fa-close" aria-hidden="true"></i>
                </button>
            </div>
        @endif
<form method="post" action="{{ route('workload.lec', $staff->id) }} " enctype="multipart/form-data">
                        @csrf
                        @method('post')
        <div class="row">
            <div class="col-12">
                <div class="card mb-4 mx-4">
                    <div class="card-header pb-0">
                        <div class="d-flex flex-row justify-content-between">
                                                        <div>
                                <h5 class="mb-0">Staff Assignment <select id='year' name="year"></select></h5>
                            </div>


                        </div>
                    </div>
                    <div class="card-body px-2 pt-2 pb-2">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="staff_id" class="form-control-label">{{ __('Staff') }}</label>


                                </label>
                            </div>
                            <div class="col-md-6">

                                <button type="button" name="search" value="0"
                                    class="btn bg-gradient-primary btn-md mt-4 mb-4">Search</button>


                            </div>
                        </div>
                        <div class="row">
                            <div id="searchassign">

                                <livewire:lec-assignment />

                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
</form>
    </div>
@endsection
<script>
    let selectedStaffId = '';

    function updateStaffId() {
        const staffSelect = document.getElementById('staff_id');
        selectedStaffId = staffSelect.value;
        const assignmentDetail = document.querySelector('livewire\\:lec-assignment');
        // Update the staff_id property in the Livewire component
        assignmentDetail.setAttribute('staff_id', selectedStaffId);

        // Optionally, you can also trigger a Livewire refresh if needed
        Livewire.emit('refreshlec-assignment', selectedStaffId);
        const staffname = document.getElementById('staffname');
        staffname.value = staffSelect.value;
    }
</script>

@extends('common::layouts.master')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('') }}admin/css-rtl/plugins/forms/form-validation.css">
    {{-- <link rel="stylesheet" type="text/css" href="{{ asset('') }}admin/vendors/css/pickers/pickadate/pickadate.css"> --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('') }}admin/vendors/css/pickers/flatpickr/flatpickr.min.css">
    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/vendors/css/forms/select/select2.min.css') }}">
@endsection
@section('content')
    <div class="col-md-12 col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">انشاء تطوع جديدة</h4>
            </div>
            <div class="card-body">
                <form class="form form-horizontal" action="{{ url('admin/volunteering/') }}" method="POST"
                    enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="row">


                        <div class="col-12">
                            <div class="mb-1 row">
                                <div class="col-sm-3 text-center">
                                    <label class="col-form-label" for="default-select"> الموظف
                                    </label>
                                </div>
                                <div class="col-sm-9">
                                    <select class="select2 form-select client" name="client_id" id="default-select">
                                        @foreach ($viewModel->clientWithNoVolunteering() as $client)
                                            <option value="{{ $client['id'] }}">{{ $client['name'] }}</option>
                                        @endforeach
                                    </select>

                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="mb-1 row">
                                <div class="col-sm-3 text-center">
                                    <label class="col-form-label" for="fname-icon"> الاسم </label>
                                </div>
                                <div class="col-sm-9">
                                    <div class="input-group input-group-merge">
                                        {{-- <span class="input-group-text"><i data-feather="user"></i></span> --}}
                                        <input type="text" class="form-control name" name="name" placeholder="الاسم"
                                            value="{{ old('name') }}" />
                                        @error('name')
                                            <p class="alert alert-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>



                        <div class="col-12">
                            <div class="mb-1 row">
                                <div class="col-sm-3 text-center">
                                    <label class="col-form-label" for="fname-icon"> رقم الجوال</label>
                                </div>
                                <div class="col-sm-9">
                                    <div class="input-group input-group-merge">
                                        {{-- <span class="input-group-text"><i data-feather="user"></i></span> --}}
                                        <input type="number" id="fname-icon" class="form-control phone" name="phone"
                                            placeholder="phone number" value="{{ old('phone') }}" />
                                        @error('phone')
                                            <p class="alert alert-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-12">
                            <div class="mb-1 row">
                                <div class="col-sm-3 text-center">
                                    <label class="col-form-label" for="pass-icon">البريد الالكتروني</label>
                                </div>
                                <div class="col-sm-9">
                                    <div class="input-group input-group-merge">
                                        {{-- <span class="input-group-text"><i data-feather="image"></i></span> --}}
                                        <input type="text" id="pass-icon" class="form-control email" name="email"
                                            value="{{ old('email') }}" />
                                        @error('email')
                                            <p class="alert alert-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="mb-1 row">
                                <div class="col-sm-3 text-center">
                                    <label class="col-form-label" for="pass-icon">النوع</label>
                                </div>

                                <div class="col-sm-9">
                                    <div class="form-check">
                                        <input value="female" class="form-check-input" type="radio" name="gender"
                                            id="flexRadioDefault1" >
                                        <label class="form-check-label" for="flexRadioDefault1">
                                            انثي
                                        </label>
                                    </div>

                                    <div class="form-check">
                                        <input value="male" class="form-check-input" type="radio"
                                            name="gender" id="flexRadioDefault2">
                                        <label class="form-check-label" for="flexRadioDefault2">
                                            ذكر
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="mb-1 row">
                                <div class="col-sm-3 text-center">
                                    <label class="col-form-label" for="pass-icon">التفاصيل</label>
                                </div>
                                <div class="col-sm-9">
                                    <div class="input-group input-group-merge">
                                        {{-- <span class="input-group-text"><i data-feather="image"></i></span> --}}
                                        <textarea class="form-control" name="details" minlength="6" rows="20" style="direction: rtl !important;">
                                          {{ old('details') }}
                                        </textarea>
                                        @error('details')
                                            <p class="alert alert-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="mb-1 row">
                                <div class="col-sm-3 text-center">
                                    <label class="col-form-label" for="default-select-multi2"> نوع التطوع
                                    </label>
                                </div>
                                <div class="col-sm-9">

                                    <select class="select2 form-select " required name="volunteering_type_id[]"
                                        multiple="multiple" id="default-select-multi2">
                                        @foreach ($viewModel->VolunteeringTypes() as $volunteeringType)
                                            <option @if (in_array($volunteeringType['id'], [])) selected @endif
                                                value="{{ $volunteeringType['id'] }}">{{ $volunteeringType['title'] }}</option>
                                        @endforeach
                                    </select>

                                </div>
                            </div>
                        </div>


                        <div class="col-sm-9 offset-sm-3">
                            <div class="mb-1">
                                <div class="form-check">
                                    <input type="checkbox" value="1" name="is_active" class="form-check-input"
                                        id="customCheck2" />
                                    <label class="form-check-label" for="customCheck2">تفعيل</label>
                                </div>
                            </div>
                        </div>



                        <div class="col-sm-9 offset-sm-3">
                            <button type="submit" class="btn btn-primary me-1">اضافة</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('') }}admin/vendors/js/forms/validation/jquery.validate.min.js"></script>

    <script src="{{ asset('') }}admin/js/scripts/forms/form-validation.js"></script>
    <script src="{{ asset('') }}admin/vendors/js/extensions/sweetalert2.all.min.js"></script>

    <script src="{{ asset('') }}admin/js/scripts/forms/form-validation.js"></script>

    <script src="{{ asset('') }}admin/vendors/js/forms/repeater/jquery.repeater.min.js"></script>
    <script src="{{ asset('') }}admin/js/scripts/forms/form-repeater.js"></script>
    <script src="{{ asset('') }}admin/vendors/js/forms/select/select2.full.min.js"></script>
    <script src="{{ asset('') }}admin/vendors/js/pickers/flatpickr/flatpickr.min.js"></script>
    <script src="{{ asset('') }}admin/js/scripts/forms/pickers/form-pickers.js"></script>
    <script>
        var select = $('.select2');

        select.each(function() {
            var $this = $(this);
            $this.wrap('<div class="position-relative"></div>');
            $this.select2({
                // the following code is used to disable x-scrollbar when click in select input and
                // take 100% width in responsive also
                dropdownAutoWidth: true,
                width: '100%',
                dropdownParent: $this.parent()
            });
        });

        $(document).ready(function() {
            $(document).on('change', '.client', function() {
                var id = $(this).val();
                console.log(id);
                $.ajax({
                    type: 'get',
                    url: '/admin/volunteering/getClientData/' + id,

                    dataType: 'json', //return data will be json
                    success: function(data) {
                        console.log(data.email);
                        $('.name').val(data.name)
                        $('.phone').val(data.phone)
                    },
                    error: function() {

                    }
                });
            });
        });
    </script>
@endsection

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
                <h4 class="card-title">تعديل البيانات الخاصه بـ {{ $volunteering_request['title'] }}</h4>
            </div>
            <div class="card-body">
                <form class="form form-horizontal"
                    action="{{ url('admin/volunteeringRequest/' . $volunteering_request->id) }}" method="POST"
                    enctype="multipart/form-data">
                    {{ method_field('PUT') }}
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-12">
                            <div class="mb-1 row">
                                <div class="col-sm-3 text-center">
                                    <label class="col-form-label" for="fname-icon"> الاسم</label>
                                </div>
                                <div class="col-sm-9">
                                    <div class="input-group input-group-merge">
                                        <span class="input-group-text"><i data-feather="user"></i></span>
                                        <input type="text" id="fname-icon" value="{{ $volunteering_request->title }}"
                                            class="form-control" name="title" placeholder="العنوان" />
                                        @error('title')
                                            <p class="alert alert-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>


                            <div class="mb-1 row">
                                <div class="col-sm-3 text-center">
                                    <label class="col-form-label" for="default-select-multi2"> نوع التطوع
                                    </label>
                                </div>
                                <div class="col-sm-9">

                                    <select class="select2 form-select " required name="volunteering_type_id[]"
                                        multiple="multiple" id="default-select-multi2">
                                        @foreach ($viewModel->VolunteeringTypes() as $volunteeringType)
                                            <option @if (in_array($volunteeringType['id'], $volunteeringtypesArray)) selected @endif
                                                value="{{ $volunteeringType['id'] }}">{{ $volunteeringType['title'] }}
                                            </option>
                                        @endforeach
                                    </select>

                                </div>
                            </div>



                            <div class="mb-1 row">

                                <div class="col-sm-3 text-center">
                                    <label class="form-label" for="basic-icon-default-date"> تاريخ</label>
                                </div>
                                <div class="col-sm-9">
                                    <input type="date" value="{{ $volunteering_request->date }}" name="date"
                                        id="fp-date-time" class="form-control" />
                                    @error('date')
                                        <p class="alert alert-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-1 row">
                                <div class="col-sm-3 text-center">
                                    <label class="col-form-label" for="fname-iconn"> الوصف</label>
                                </div>
                                <div class="col-sm-9">
                                    <div class="input-group input-group-merge">
                                        <textarea class="form-control ckeditor" minlength="6" name="description" rows="20"
                                            style="direction: rtl !important;">
                                                    {{ $volunteering_request->description }}
                                                        </textarea>

                                        @error('description')
                                            <p class="alert alert-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="mb-1 row">
                                <div class="col-sm-3 text-center">
                                    <label class="col-form-label" for="fname-iconnn">الصور</label>
                                </div>
                                <div class="col-sm-9">
                                    <div class="input-group input-group-merge">
                                        <span class="input-group-text"><i data-feather="image"></i></span>
                                        <input multiple type="file" id="pass-icon" class="form-control" name="source[]"
                                            placeholder="image" />
                                    </div>

                                </div>
                            </div>
                            <div class="images-container  d-flex flex-row flex-wrap"
                                style="display: flex !important;margin-right:25%">
                                @for ($j = 0; $j < count($volunteering_request->images); $j++)
                                    <div class="image-container position-relative"
                                        image-id="{{ $volunteering_request->images[$j]->source }}"
                                        style="width: 100px; height: 100px;margin: 2px 7px;margin-top:10px"
                                        image-index="{{ $volunteering_request->images[$j]->id }}" image-name="">
                                        <img style="width: 100%; height: 100%"
                                            src="{{ asset($volunteering_request->images[$j]->source) }}">
                                        <span class="position-absolute text-center"
                                            style="color: white; width: 20px; height: 20px; background: red; top: 0; border-radius: 10px; padding-top: 1px; right: -10px;cursor: pointer"
                                            onclick="removeImage(this,{{ $volunteering_request->images[$j]->id }},'هل ترغب فى تاكيد عملية الحذف')">X</span>
                                    </div>
                                @endfor

                            </div>
                            <div class="col-sm-9 offset-sm-3">
                                <div class="mb-1">
                                    <div class="form-check">
                                        <input type="checkbox" value="1"
                                            @if ($volunteering_request->is_active == 1) checked @endif name="is_active"
                                            class="form-check-input" id="customCheck2" />
                                        <label class="form-check-label" for="customCheck2">تفعيل</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-9 offset-sm-3">
                        <button type="submit" class="btn btn-primary me-1">تعديل</button>
                    </div>
            </div>
            </form>
        </div>
    </div>
    </div>
@endsection
@section('js')
    {{-- <script src="//cdn.ckeditor.com/4.16.0/full/ckeditor.js"></script> --}}
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
    
        function removeImage(button, val, confirmText) {
            console.log(1);
            if (confirm(confirmText) == true) {
                $(button).parent().remove()
                $.ajax({
                    url: '{{ url('admin/deleteVolunteeringRequestPhoto') }}',
                    type: "POST",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        volunteering_request_photo_id: val,
                    },
                    success: function(result) {
                        // alert(result)
                        //  location.reload();
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            }

        }
    </script>
@endsection

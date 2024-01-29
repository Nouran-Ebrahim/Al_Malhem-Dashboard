@extends('common::layouts.master')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('') }}admin/css-rtl/plugins/forms/form-validation.css">
@endsection
@section('content')
    <div class="col-md-12 col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title"></h4>انشاء تفوق جديد</h4>
            </div>
            <div class="card-body">
                <form class="form form-horizontal" enctype="multipart/form-data" action="{{ url('admin/superior/') }}"
                    method="POST">
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
                                        <input type="text" class="form-control" name="name" placeholder="الاسم"
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
                                    <label class="col-form-label" for="pass-icon">النوع</label>
                                </div>

                                <div class="col-sm-9">
                                    <div class="form-check">
                                        <input value="female" class="form-check-input" type="radio" name="gender"
                                            id="flexRadioDefault1">
                                        <label class="form-check-label" for="flexRadioDefault1">
                                            انثي
                                        </label>
                                    </div>

                                    <div class="form-check">
                                        <input value="male" class="form-check-input" type="radio" name="gender"
                                            id="flexRadioDefault2">
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
                                    <label class="col-form-label" for="fname-icon"> سجل مدني</label>
                                </div>
                                <div class="col-sm-9">
                                    <div class="input-group input-group-merge">
                                        <span class="input-group-text"><i data-feather="user"></i></span>
                                        <input type="text" class="form-control" name="civil" placeholder="الاسم"
                                            value="{{ old('civil') }}" />
                                        @error('civil')
                                            <p class="alert alert-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="mb-1 row">
                                <div class="col-sm-3 text-center">
                                    <label class="col-form-label" for="fname-icon"> السنة الدراسيه</label>
                                </div>
                                <div class="col-sm-9">
                                    <div class="input-group input-group-merge">
                                        <span class="input-group-text"><i data-feather="user"></i></span>
                                        <input type="text" class="form-control" name="year" placeholder="الاسم"
                                            value="{{ old('year') }}" />
                                        @error('year')
                                            <p class="alert alert-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="mb-1 row">
                                <div class="col-sm-3 text-center">
                                    <label class="col-form-label" for="fname-icon"> التخصص</label>
                                </div>
                                <div class="col-sm-9">
                                    <div class="input-group input-group-merge">
                                        <span class="input-group-text"><i data-feather="user"></i></span>
                                        <input type="text" class="form-control" name="specialization" placeholder="الاسم"
                                            value="{{ old('specialization') }}" />
                                        @error('specialization')
                                            <p class="alert alert-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="mb-1 row">
                                <div class="col-sm-3 text-center">
                                    <label class="col-form-label" for="fname-icon"> المعدل</label>
                                </div>
                                <div class="col-sm-9">
                                    <div class="input-group input-group-merge">
                                        <span class="input-group-text"><i data-feather="user"></i></span>
                                        <input type="text" class="form-control" name="gpa" placeholder="المعدل"
                                            value="{{ old('gpa') }}" />
                                        @error('gpa')
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
                                        <span class="input-group-text"><i data-feather="user"></i></span>
                                        <input type="text" class="form-control" name="phone"
                                            placeholder="رقم الجوال" value="{{ old('phone') }}" />
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
                                    <label class="col-form-label" for="fname-icon"> رقم جوال ولي الامر</label>
                                </div>
                                <div class="col-sm-9">
                                    <div class="input-group input-group-merge">
                                        <span class="input-group-text"><i data-feather="user"></i></span>
                                        <input type="text" class="form-control" name="parent_phone"
                                            placeholder="رقم الجوال" value="{{ old('parent_phone') }}" />
                                        @error('parent_phone')
                                            <p class="alert alert-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="mb-1 row">
                                <div class="col-sm-3 text-center">
                                    <label class="col-form-label" for="fname-icon"> صورة المتفوق</label>
                                </div>
                                <div class="col-sm-9">
                                    <div class="input-group input-group-merge">
                                        <span class="input-group-text"><i data-feather="image"></i></span>
                                        <input type="file" class="form-control" id="fname-icon" name="personal" placeholder="صوره"
                                            value="{{ old('personal') }}" />
                                        {{-- @error('source')
                                            <p class="alert alert-danger">{{ $message }}</p>
                                        @enderror --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="mb-1 row">
                                <div class="col-sm-3 text-center">
                                    <label class="col-form-label" for="fname-icon2"> صورة الشهاده</label>
                                </div>
                                <div class="col-sm-9">
                                    <div class="input-group input-group-merge">
                                        <span class="input-group-text"><i data-feather="image"></i></span>
                                        <input type="file" id="fname-icon2" class="form-control" name="certification"
                                            placeholder="صوره" value="{{ old('certification') }}" />
                                        @error('certification')
                                            <p class="alert alert-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-sm-9 offset-sm-3">
                            <div class="mb-1">
                                <div class="form-check">
                                    <input type="checkbox" value="1" onclick="myFunction()" name="is_active"
                                        class="form-check-input" id="customCheck2" />
                                    <label class="form-check-label" for="customCheck2">تفعيل</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 " id="party" style="display: none">
                            <div class="mb-1 row">
                                <div class="col-sm-3 text-center">
                                    <label class="col-form-label" for="fname-icon"> الحفلة </label>
                                </div>
                                <div class="col-sm-9">
                                    <div class="input-group input-group-merge">
                                        <select class="select form-select " name="party_id" id="default-select">
                                          
                                            <option selected value="{{ null }}">اختر حفلة</option>
                                            @foreach ($viewModel->parties() as $party)
                                                <option value="{{ $party->id }}">{{ $party->title }}
                                                </option>
                                            @endforeach

                                        </select>
                                    </div>
                                </div>

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
    <script>
        function myFunction() {
            // Get the checkbox
            var checkBox = document.getElementById("customCheck2");
            // Get the output text
            var party = document.getElementById("party");

            // If the checkbox is checked, display the output text
            if (checkBox.checked == true) {
                party.style.display = "block";
            } else {
                party.style.display = "none";
            }
        }
    </script>
@endsection

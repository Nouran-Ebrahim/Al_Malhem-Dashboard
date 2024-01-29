@extends('common::layouts.master')


@section('content')
    <div class="col-md-12 col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">تعديل البيانات الخاصه بـ {{ $superior['title'] }}</h4>
            </div>
            <div class="card-body">
                <form class="form form-horizontal" action="{{ url('admin/superior/' . $superior->id) }}" method="POST"
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
                                        <input type="text" id="fname-icon" value="{{ $superior->name }}"
                                            class="form-control" name="name" placeholder="العنوان" />
                                        @error('name')
                                            <p class="alert alert-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="mb-1 row">
                                <div class="col-sm-3 text-center">
                                    <label class="col-form-label" for="pass-icon">النوع</label>
                                </div>

                                <div class="col-sm-9">
                                    <div class="form-check">
                                        <input value="female" class="form-check-input"
                                            @if ($superior->gender == 'female') checked @endif type="radio" name="gender"
                                            id="flexRadioDefault1">
                                        <label class="form-check-label" for="flexRadioDefault1">
                                            انثي
                                        </label>
                                    </div>

                                    <div class="form-check">
                                        <input @if ($superior->gender == 'male') checked @endif value="male"
                                            class="form-check-input" type="radio" name="gender" id="flexRadioDefault2">
                                        <label class="form-check-label" for="flexRadioDefault2">
                                            ذكر
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-1 row">
                                <div class="col-sm-3 text-center">
                                    <label class="col-form-label" for="fname-icon"> سجل مدني</label>
                                </div>
                                <div class="col-sm-9">
                                    <div class="input-group input-group-merge">
                                        <span class="input-group-text"><i data-feather="user"></i></span>
                                        <input type="text" class="form-control" name="civil" placeholder="الاسم"
                                            value="{{ $superior->civil }}" />
                                        @error('civil')
                                            <p class="alert alert-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="mb-1 row">
                                <div class="col-sm-3 text-center">
                                    <label class="col-form-label" for="fname-icon"> السنة الدراسيه</label>
                                </div>
                                <div class="col-sm-9">
                                    <div class="input-group input-group-merge">
                                        <span class="input-group-text"><i data-feather="user"></i></span>
                                        <input type="text" class="form-control" name="year" placeholder="الاسم"
                                            value="{{ $superior->year }}" />
                                        @error('year')
                                            <p class="alert alert-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="mb-1 row">
                                <div class="col-sm-3 text-center">
                                    <label class="col-form-label" for="fname-icon"> التخصص</label>
                                </div>
                                <div class="col-sm-9">
                                    <div class="input-group input-group-merge">
                                        <span class="input-group-text"><i data-feather="user"></i></span>
                                        <input type="text" class="form-control" name="specialization" placeholder="الاسم"
                                            value="{{ $superior->specialization }}" />
                                        @error('specialization')
                                            <p class="alert alert-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>


                            <div class="mb-1 row">
                                <div class="col-sm-3 text-center">
                                    <label class="col-form-label" for="fname-icon"> المعدل</label>
                                </div>
                                <div class="col-sm-9">
                                    <div class="input-group input-group-merge">
                                        <span class="input-group-text"><i data-feather="user"></i></span>
                                        <input type="text" class="form-control" name="gpa" placeholder="المعدل"
                                            value="{{ $superior->gpa }}" />
                                        @error('gpa')
                                            <p class="alert alert-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="mb-1 row">
                                <div class="col-sm-3 text-center">
                                    <label class="col-form-label" for="fname-icon"> رقم الجوال</label>
                                </div>
                                <div class="col-sm-9">
                                    <div class="input-group input-group-merge">
                                        <span class="input-group-text"><i data-feather="user"></i></span>
                                        <input type="text" class="form-control" name="phone"
                                            placeholder="رقم الجوال" value="{{ $superior->phone }}" />
                                        @error('phone')
                                            <p class="alert alert-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>


                            <div class="mb-1 row">
                                <div class="col-sm-3 text-center">
                                    <label class="col-form-label" for="fname-icon"> رقم جوال ولي الامر</label>
                                </div>
                                <div class="col-sm-9">
                                    <div class="input-group input-group-merge">
                                        <span class="input-group-text"><i data-feather="user"></i></span>
                                        <input type="text" class="form-control" name="parent_phone"
                                            placeholder="رقم الجوال" value="{{ $superior->parent_phone }}" />
                                        @error('parent_phone')
                                            <p class="alert alert-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="mb-1 row">
                                <div class="col-sm-3 text-center">
                                    <label class="col-form-label" for="fname-iconnn"> صورة الشهادة</label>
                                </div>
                                <div class="col-sm-9">
                                    <div class="input-group input-group-merge">
                                        <span class="input-group-text"><i data-feather="image"></i></span>
                                        <input type="file" value="{{asset( $superior->certification )}}" id="pass-icon"
                                            class="form-control" name="certification" placeholder="image" />
                                    </div>

                                </div>
                            </div>

                            <div class="mb-1 row">
                                <div class="col-sm-3 text-center">
                                    <label class="col-form-label" for="fname-iconnn"> صورة المتفوق</label>
                                </div>
                                <div class="col-sm-9">
                                    <div class="input-group input-group-merge">
                                        <span class="input-group-text"><i data-feather="image"></i></span>
                                        <input type="file" value="{{asset($superior->personal)  }}" id="pass-icon"
                                            class="form-control" name="personal" placeholder="image" />
                                    </div>

                                </div>
                            </div>
                            {{-- <div class="images-container  d-flex flex-row flex-wrap"
                                style="display: flex !important;margin-right:25%">
                                @for ($j = 0; $j < count($superior->images); $j++)
                                    <div class="image-container position-relative"
                                        image-id="{{ $superior->images[$j]->source }}"
                                        style="width: 100px; height: 100px;margin: 2px 7px;margin-top:10px"
                                        image-index="{{ $superior->images[$j]->id }}" image-name="">
                                        <img style="width: 100%; height: 100%"
                                            src="{{ asset($superior->images[$j]->source) }}">
                                        <span class="position-absolute text-center"
                                            style="color: white; width: 20px; height: 20px; background: red; top: 0; border-radius: 10px; padding-top: 1px; right: -10px;cursor: pointer"
                                            onclick="removeImage(this,{{ $superior->images[$j]->id }},'هل ترغب فى تاكيد عملية الحذف')">X</span>
                                    </div>
                                @endfor

                            </div> --}}
                            <div class="col-sm-9 offset-sm-3">
                                <div class="mb-1">
                                    <div class="form-check">
                                        <input type="checkbox" value="1" onclick="myFunction()"
                                            @if ($superior->is_active == 1) checked @endif name="is_active"
                                            class="form-check-input" id="customCheck2" />
                                        <label class="form-check-label" for="customCheck2">تفعيل</label>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-1 row" id="party" style="display: none">
                                <div class="mb-1 row">
                                    <div class="col-sm-3 text-center">
                                        <label class="col-form-label" for="fname-iconnn"> الحفلة </label>
                                    </div>
                                    <div class="col-sm-9">
                                        <div class="input-group input-group-merge">
                                            <select class="select form-select " name="party_id" id="default-select">

                                                <option selected value="{{ null }}">اختر حفلة</option>
                                                @foreach ($viewModel->parties() as $party)
                                                    <option @if ($superior->party_id == $party->id) selected @endif
                                                        value="{{ $party->id }}">{{ $party->title }}
                                                    </option>
                                                @endforeach

                                            </select>
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
    <script src="//cdn.ckeditor.com/4.16.0/full/ckeditor.js"></script>
    <script>
        // function removeImage(button, val, confirmText) {
        //     console.log(1);
        //     if (confirm(confirmText) == true) {
        //         $(button).parent().remove()
        //         $.ajax({
        //             url: '{{ url('admin/deletePartyPhoto') }}',
        //             type: "POST",
        //             data: {
        //                 "_token": "{{ csrf_token() }}",
        //                 superior_photo_id: val,
        //             },
        //             success: function(result) {
        //                 // alert(result)
        //                 //  location.reload();
        //             },
        //             error: function(error) {
        //                 console.log(error);
        //             }
        //         });
        //     }

        // }
        var checkBox = document.getElementById("customCheck2");
        // Get the output text
        var party = document.getElementById("party");

        // If the checkbox is checked, display the output text
        if (checkBox.checked == true) {
            party.style.display = "block";
        } else {
            party.style.display = "none";
        }

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

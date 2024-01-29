@extends('common::layouts.master')


@section('content')
    <div class="col-md-12 col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">تعديل البيانات الخاصه بالخبر {{ $calender['title'] }}</h4>
            </div>
            <div class="card-body">
                <form class="form form-horizontal" action="{{ url('admin/calender/' . $calender->id) }}" method="POST"
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
                                        <input type="text" id="fname-icon" value="{{ $calender->title }}"
                                            class="form-control" name="title" placeholder="العنوان" />
                                        @error('title')
                                            <p class="alert alert-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="mb-1 row">

                                <div class="col-sm-3 text-center">
                                    <label class="form-label" for="basic-icon-default-date"> تاريخ</label>
                                </div>
                                <div class="col-sm-9">
                                    <input value="{{ $calender->date }}" type="date" value="" name="date" id="fp-date-time"
                                        class="form-control" />
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
                                                    {{ $calender->description }}
                                                        </textarea>

                                        @error('description')
                                            <p class="alert alert-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="mb-1 row">
                                <div class="col-sm-3 text-center">
                                    <label class="col-form-label" for="fname-iconnn"> الصوره</label>
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
                                @for ($j = 0; $j < count($calender->images); $j++)
                                    <div class="image-container position-relative"
                                        image-id="{{ $calender->images[$j]->source }}"
                                        style="width: 100px; height: 100px;margin: 2px 7px;margin-top:10px"
                                        image-index="{{ $calender->images[$j]->id }}" image-name="">
                                        <img style="width: 100%; height: 100%"
                                            src="{{ asset($calender->images[$j]->source) }}">
                                        <span class="position-absolute text-center"
                                            style="color: white; width: 20px; height: 20px; background: red; top: 0; border-radius: 10px; padding-top: 1px; right: -10px;cursor: pointer"
                                            onclick="removeImage(this,{{ $calender->images[$j]->id }},'هل ترغب فى تاكيد عملية الحذف')">X</span>
                                    </div>
                                @endfor

                            </div>
                            <div class="col-sm-9 offset-sm-3 mt-2">
                                <div class="mb-1">
                                    <div class="form-check">
                                        <input type="checkbox" value="1"
                                            @if ($calender->is_active == 1) checked @endif name="is_active"
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
    <script src="//cdn.ckeditor.com/4.16.0/full/ckeditor.js"></script>
    <script>
        function removeImage(button, val, confirmText) {
            console.log(1);
            if (confirm(confirmText) == true) {
                $(button).parent().remove()
                $.ajax({
                    url: '{{ url('admin/deleteCalenderPhoto') }}',
                    type: "POST",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        calender_photo_id: val,
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

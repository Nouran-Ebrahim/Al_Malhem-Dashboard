@extends('common::layouts.master')


@section('content')
    <div class="col-md-12 col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">تعديل البيانات الخاصه بالخدمه </h4>
            </div>
            <div class="card-body">
                <form class="form form-horizontal" action="{{ url('admin/service/' . $service->id) }}" method="POST"
                    enctype="multipart/form-data">
                    {{ method_field('PUT') }}
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-12">

                            <div class="mb-1 row">
                                <div class="col-sm-3 text-center">
                                    <label class="col-form-label" for="fname-icon">نوع الخدمة</label>
                                </div>
                                <div class="col-sm-9">
                                    <div class="input-group input-group-merge">
                                        <span class="input-group-text"><i data-feather="user"></i></span>
                                        <select class="select form-select " name="service_type_id" id="default-select">

                                            @foreach ($viewModel->serviceTypes() as $serviceType)
                                                <option @if ($serviceType->id == $service->service_type_id) selected @endif
                                                    value="{{ $serviceType->id }}">{{ $serviceType->title }}</option>
                                            @endforeach

                                        </select>

                                    </div>
                                </div>
                            </div>
                            <div class="mb-1 row">
                                <div class="col-sm-3 text-center">
                                    <label class="col-form-label" for="fname-icon">النوع </label>
                                </div>
                                <div class="col-sm-9">
                                    <div class="input-group input-group-merge">
                                        <span class="input-group-text"><i data-feather="user"></i></span>
                                        <select class="select form-select " name="type" id="default-select">

                                            <option @if ($service->type == 'offer') selected @endif value="offer">عرض
                                            </option>
                                            <option @if ($service->type == 'request') selected @endif value="request">طلب
                                            </option>

                                        </select>

                                    </div>
                                </div>
                            </div>
                            <div class="mb-1 row">
                                <div class="col-sm-3 text-center">
                                    <label class="col-form-label" for="fname-icon">اسم العميل</label>
                                </div>
                                <div class="col-sm-9">
                                    {{-- <div class="input-group input-group-merge col-12"> --}}
                                    <select class="select2 form-select " name="client_id" id="default-select">

                                        @foreach ($viewModel->clients() as $client)
                                            <option @if($client['id']===$service->client_id) selected @endif value="{{ $client->id }}">{{ $client->name }}</option>
                                        @endforeach

                                    </select>
                                    {{-- </div> --}}
                                </div>
                                {{-- </div> --}}
                            </div>
                            <div class="mb-1 row">
                                <div class="col-sm-3 text-center">
                                    <label class="col-form-label" for="fname-iconn"> الوصف</label>
                                </div>
                                <div class="col-sm-9">
                                    <div class="input-group input-group-merge">
                                        <textarea class="form-control " minlength="6" name="description" rows="20" style="direction: rtl !important;">
                                                    {{ $service->description }}
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
                                @for ($j = 0; $j < count($service->images); $j++)
                                    <div class="image-container position-relative"
                                        image-id="{{ $service->images[$j]->source }}"
                                        style="width: 100px; height: 100px;margin: 2px 7px;margin-top:10px"
                                        image-index="{{ $service->images[$j]->id }}" image-name="">
                                        <img style="width: 100%; height: 100%"
                                            src="{{ asset($service->images[$j]->source) }}">
                                        <span class="position-absolute text-center"
                                            style="color: white; width: 20px; height: 20px; background: red; top: 0; border-radius: 10px; padding-top: 1px; right: -10px;cursor: pointer"
                                            onclick="removeImage(this,{{ $service->images[$j]->id }},'هل ترغب فى تاكيد عملية الحذف')">X</span>
                                    </div>
                                @endfor

                            </div>
                            <div class="col-sm-9 offset-sm-3 mt-2">
                                <div class="mb-1">
                                    <div class="form-check">
                                        <input type="checkbox" value="1"
                                            @if ($service->is_active == 1) checked @endif name="is_active"
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
    <script>
        function removeImage(button, val, confirmText) {
            console.log(1);
            if (confirm(confirmText) == true) {
                $(button).parent().remove()
                $.ajax({
                    url: '{{ url('admin/deleteServicePhoto') }}',
                    type: "POST",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        service_photo_id: val,
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

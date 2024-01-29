@extends('common::layouts.master')


@section('content')
    <div class="col-md-12 col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">تعديل البيانات الخاصه بالقسم {{ $volunteeringTypes['title'] }}</h4>
            </div>
            <div class="card-body">
                <form class="form form-horizontal" action="{{ url('admin/volunteeringTypes/' . $volunteeringTypes->id) }}" method="POST"
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
                                        <input type="text" id="fname-icon" value="{{ $volunteeringTypes->title }}"
                                            class="form-control" name="title" placeholder="العنوان" />
                                        @error('title')
                                            <p class="alert alert-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                            </div>
                            <div class="mb-1 row">
                            <div class="col-sm-3 text-center">
                                <label class="col-form-label" for="fname-icon2">لون القسم</label>
                            </div>
                            <div class="col-sm-1">
                                <div class="input-group input-group-merge">

                                    <input id="fname-icon2" type="color" class="form-control" name="color"
                                        value="{{ $volunteeringTypes->color }}" />
                                    {{-- @error('color')
                                        <p class="alert alert-danger">{{ $message }}</p>
                                    @enderror --}}
                                </div>
                            </div>
                            <div class="col-sm-9 offset-sm-3 mt-2">
                                <div class="mb-1">
                                    <div class="form-check">
                                        <input type="checkbox" value="1"
                                            @if ($volunteeringTypes->is_active == 1) checked @endif name="is_active"
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

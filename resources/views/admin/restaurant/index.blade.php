@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="panel panel-default">
                <div class="panel-heading">Restaurants</div>

                <div class="panel-body">
                    @if (session('main-status'))
                        <div class="alert alert-success">
                            {{ session('main-status') }}
                        </div>
                    @endif
                    @if (count($restaurants) > 0)
                        {{-- TODO: add pagination --}}
                        <table class="table admin-restaurant-list">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Address</th>
                                    <th>Owner</th>
                                    <th width="50px">&nbsp;</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($restaurants as $item)
                                    <tr class="{{ $selected_id == $item->id ? 'active' : '' }}">
                                        <td>{{ $item->id }}</td>
                                        <td><a href="{{ route('restaurant-store', ['id' => $item->id]) }}">{{ $item->name }}</a></td>
                                        <td>{{ $item->address }}</td>
                                        <td><a href="mailto:{{ $item->owner['email'] }}">{{ $item->owner['name'] }}</a></td>
                                        <td class="delete">
                                            <delete-button name="{{ $item->name }}" route="{{ route('restaurant-destroy', ['id' => $item->id]) }}"></delete-button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p>No restaurants. Create one using the form on the right.</p>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    @if (isset($restaurant))
                        Update "{{ $restaurant->name }}"
                    @else
                        Create new restaurant
                    @endif
                </div>
                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('restaurant-store', ['id' => optional($restaurant)->id]) }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name">Restaurant name</label>

                            <input id="name" type="text" class="form-control" name="name" value="{{ old('name', optional($restaurant)->name) }}" requiredx>

                            @if ($errors->has('name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
                            <label for="address">Address</label>

                            <textarea name="address" id="address" cols="30" rows="3" class="form-control">{{ old('address', optional($restaurant)->address) }}</textarea>

                            @if ($errors->has('address'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('address') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group{{ $errors->has('lat') || $errors->has('lng') ? ' has-error' : '' }}">

                            <label for="lng">Click to pin location</label>

                            @if ($errors->has('lat') || $errors->has('lng'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('lat') }}</strong>
                                    <strong>{{ $errors->first('lng') }}</strong>
                                </span>
                            @endif

                            @php
                                $lat = old('lat', optional($restaurant)->lat);
                                $lng = old('lng', optional($restaurant)->lng);
                            @endphp

                            <map-edit 
                                :lat="{{ $lat || $lat === 0 ? $lat : 5 }}" 
                                :lng="{{ $lng || $lng === 0 ? $lng : 5 }}"
                            ></map-edit>
                        </div>

                        @if (isset($restaurant))
                            <button type="submit" class="btn btn-primary">Update</button>
                        @else
                            <button type="submit" class="btn btn-primary">Create</button>
                        @endif

                        <a href="{{ route('restaurant-store') }}" class="btn btn-default">Cancel</a>


                    </form>
                </div>
            </div>
            
        </div>
        <!-- /.col-md-4 -->
    </div>
</div>
@endsection

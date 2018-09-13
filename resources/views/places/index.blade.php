@extends('layouts.app')

@section('content')
<div class="row">
    <a href="{{route('places.create')}}" class="btn btn-lg btn-success">Create New Place</a>
</div>
@if(isset($places) && $places !== null)
    <div class="row">
        <h1>Select address:</h1>
        <div class="input-group">
            <select class="form-control">
                <option></option>
                @foreach($places as $place)
                    <option id="{{$place->id}}">{{$place->address}}</option>
                @endforeach
            </select>
            <span class="input-group-btn">
                <form method="POST" id="deleteForm">
                    <a href="" class="btn btn-primary disabled" id="editButton">Edit</a>
                    <input type="submit" class="btn btn-danger" id="deleteButton" value="Delete" disabled>
                    {{method_field('DELETE')}}
                    {{csrf_field()}}
                </form>
            </span>
        </div>
    </div>
    <div class="row">
        <h1>All places:</h1>
        <table class="table table-striped table-bordered" id="unfilteredTable">
            <thead>
                <tr>
                    <th>Address</th>
                    <th>Latitude</th>
                    <th>Longitude</th>
                </tr>
            </thead>
            <tbody>
                @foreach($places as $place)
                <tr>
                    <td>{{$place->address}}</td>
                    <td>{{$place->lat}}</td>
                    <td>{{$place->lng}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <table class="table table-striped table-bordered" id="filteredTable" style="display:none;">
            <thead>
                <tr>
                    <th>Address</th>
                    <th>Distance (km)</th>
                </tr>
            </thead>
            <tbody id="fillable">
            </tbody>
        </table>
    </div>
@else
    <h1>No places found.</h1>
@endif
@endsection

@section('scripts')
<script>
    $('select').on('change', function() {
        let id = this.options[this.selectedIndex].id;
        if(id !== ''){
            axios.get(`/places/${id}/getDistances`)
            .then((response) => {
                $('#fillable').html('');
                $('#unfilteredTable').hide();
                $('#filteredTable').show();
                $('#editButton').removeClass('disabled');
                $('#deleteButton').removeAttr('disabled');
                $('#deleteForm').attr('action', `/places/${id}`);
                $('#editButton').attr('href', `/places/${id}/edit`);
                for (var prop in response.data) {
                    $('#fillable').append(
                        `<tr><td>${prop}</td><td>${response.data[prop]}</td></tr>`
                    );
                }
            })
            .catch((error) => {
                console.log(error);
            });
        } else {
            $('#editButton').addClass('disabled');
            $('#deleteButton').prop('disabled', true);
            $('#unfilteredTable').show();
            $('#filteredTable').hide();
        }
    });
</script>
@endsection
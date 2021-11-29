@extends('layouts.panel')

@section('breadcrumbs')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{$title}}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard.admin') }}">Home</a></li>
                        <li class="breadcrumb-item">Alerts</li>
                        <li class="breadcrumb-item active">{{$title}}</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
@stop


@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">

                <div class="col-12">
                    @if(session()->has('success'))
                        <div class="callout callout-success" style="color:green">
                            {{ session()->get('success') }}
                        </div>
                    @endif
                    @if(session()->has('error'))
                        <div class="callout callout-danger" style="color:red">
                            {{ session()->get('error') }}
                        </div>
                    @endif
                    <div class="card">
                        <div class="row mb-3 mt-3 ml-3">
                            <div class="col-md-6">
                                <form action="" method="GET" id="perPage">
                                    <label for="perPageCount">Show</label>
                                    <select id="perPageCount" name="count" onchange="$('#perPage').submit();"
                                            class="input-select mx-2">
                                        <option value="15"{{ request('count')=='15'?' selected':'' }}>15 rows</option>
                                        <option value="25"{{ request('count')=='25'?' selected':'' }}>25 rows</option>
                                        <option value="50"{{ request('count')=='50'?' selected':'' }}>50 rows</option>
                                        <option value="100"{{ request('count')=='100'?' selected':'' }}>100 rows</option>
                                    </select>
                                </form>
                            </div>
                        </div>
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap table-compact">
                                <thead>
                                <tr>
                                    <th>&nbsp</th>
                                    <th class="pl-0">Action</th>
                                    <th class="pl-0">Message</th>
                                    <th class="pl-0">Time</th>
                                </tr>
                                </thead>
                                <tbody id="myTable">
                                @forelse($alerts as $alert)
                                    <tr>
                                        <td><a href="{{ route(auth()->user()->user_role . '.alerts.show', $alert->id) }}">{!! $alert->seen == 0 ? '<i class="fa fa-circle" style="color:green;"></i>' : '' !!}</a></td>
                                        <td><a href="{{ route(auth()->user()->user_role . '.alerts.show', $alert->id) }}">
                                                @if($alert->action == 'assigned' || $alert->action == 'added')
                                                    {{ ucfirst($alert->action) }} to {{ ucfirst($alert->type) }}
                                                @elseif($alert->action == 'removed')
                                                    {{ ucfirst($alert->action) }} from {{ ucfirst($alert->type) }}
                                                @else
                                                    {{ ucfirst($alert->type) }} {{ ucfirst($alert->action) }}
                                                @endif
                                            </a></td>
                                        <td><a href="{{ route(auth()->user()->user_role . '.alerts.show', $alert->id) }}">{!! crop(strip_tags($alert->message),100) !!}</a></td>
                                        <td><a href="{{ route(auth()->user()->user_role . '.alerts.show', $alert->id) }}">{{ $alert->created_at->diffForHumans() }}</a></td>
                                    </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="py-3 text-center">No users found</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="d-flex flex-row-reverse">
                        {!! $alerts->appends($_GET)->links('pagination::bootstrap-4') !!}
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop

@section('extras')
    <script>
        $(document).ready(function(){
            $("#myInput").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("#myTable tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
            $('.c-tt').tooltip();
        });
    </script>
@stop

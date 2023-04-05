<!DOCTYPE html>
<html lang="ja">

@include('system.layouts.layoutHeader')

<body>

@include('system.partials.header')
<div class="page-wrapper">
    @include('system.partials.sidebar')
    <div class="page-contents clearfix">
        <div class="inner-content-fluid">
            <div class="custom-container-fluid">
                @include('system.partials.breadcrumb')
                @section('title')
                    <div class="page-head clearfix">
                        <div class="row">
                            <div class="col-6">
                                <div class="head-title">
                                    <h4>{{ translate($title) }}</h4>
                                </div><!-- ends head-title -->
                            </div>
                            {{--@section('create')--}}
                            {{--<div class="col-6">--}}
                            {{--@if(hasPermission($indexUrl.'/create'))--}}
                            {{--<a class="btn btn-primary pull-right btn-sm" id="addNew" href="{{url($indexUrl.'/create')}}">--}}
                            {{--<em class="fa fa-plus"></em> {{translate('Add New')}}--}}
                            {{--</a>--}}
                            {{--@endif--}}
                            {{--</div>--}}
                            {{--@show--}}
                        </div>
                    </div><!-- ends page-head -->
                @show
                <div class="content-display clearfix">
                    @yield('header')
                    <div class="panel">
                        <div class="panel-box">
                            @include('system.partials.message')
                            <div class="table-responsive mt-3">
                                <table class="table table-striped table-bordered" aria-describedby="general table">
                                    <thead>
                                    @yield('table-heading')
                                    </thead>
                                    <tbody>
                                    {{--@if($items->isEmpty())--}}
                                    {{--<tr>--}}
                                    {{--<td colspan="100%" class="text-center">{{translate('No data available')}}</td>--}}
                                    {{--</tr>--}}
                                    {{--@else--}}
                                    @yield('table-data')
                                    {{--@endif--}}
                                    </tbody>
                                </table>
                                {{--@include('system.partials.pagination')--}}
                            </div>
                        </div>
                    </div><!-- panel -->
                </div><!-- ends content-display -->
            </div>
        </div><!-- ends custom-container-fluid -->
    </div><!-- ends page-contents -->
</div><!-- page-wrapper -->
@section('delete')
    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <form method="post">
                <div class="modal-content">
                    @csrf
                    <div class="modal-header">
                        <h4 class="modal-title">{{translate('Confirm Delete')}}</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        {{translate('Are you sure you want to delete?')}}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">
                            <em class="glyph-icon icon-close"></em> {{translate('Cancel')}}
                        </button>
                        <button type="submit" class="btn btn-sm btn-danger" id="confirmDelete">
                            <em class="glyph-icon icon-trash"></em> {{translate('Delete')}}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@show
@include('system.layouts.layoutFooter')
@yield('scripts')
</body>

</html>

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
                            @section('download')
                                <div class="col-6">
                                    @if(hasPermission($indexUrl.'/download'))
                                        <a class="btn btn-primary pull-right btn-sm" id="addNew" href="{{url($indexUrl.'/download?keyword='.Request::get('keyword').'&date='.Request::get('date').'&from='.Request::get('from').'&to='.Request::get('to').'&mansion_name='.Request::get('mansion_name').'&building_id='.Request::get('building_id').'&contractor_name='.Request::get('contractor_name'))}}">
                                            <em class="fa fa-download"></em> {{translate('Download')}}
                                        </a>
                                    @endif
                                </div>
                            @show
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
                                            @if($items->isEmpty())
                                            <tr>
                                                <td colspan="100%" class="text-center">{{translate('No data available')}}</td>
                                            </tr>
                                            @else
                                            @yield('table-data')
                                            @endif
                                        </tbody>
                                    </table>
{{--                                    @include('system.partials.pagination')--}}
                                    @if(!$items->isEmpty())
                                        @if(method_exists($items, 'perPage') && method_exists($items, 'currentPage'))
                                            <div class="pagination-tile">
                                                <label class="pagination-sub" style="display: block">
                                                    {{translate('Showing') }} {{($items->currentpage()-1)*$items->perpage()+1}} {{translate('to')}} {{(($items->currentpage()-1)*$items->perpage())+$items->count()}} {{translate('of')}} {{$items->total()}} {{translate('entries')}}
                                                </label>
                                                <ul class="pagination">
                                                    {!! str_replace('/?', '?',$items->appends(['keyword'=>Request::get('keyword'), 'date'=>Request::get('date'), 'from'=>Request::get('from') ,'to'=>Request::get('to'), 'mansion_name'=>Request::get('mansion_name'), 'building_id'=>Request::get('building_id'), 'contractor_name'=>Request::get('contractor_name')])->render()) !!}
                                                </ul>
                                            </div>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </div><!-- panel -->
                    </div><!-- ends content-display -->
                </div>
            </div><!-- ends custom-container-fluid -->
        </div><!-- ends page-contents -->
    </div><!-- page-wrapper -->

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
    @include('system.layouts.layoutFooter')
    @yield('scripts')
</body>

</html>

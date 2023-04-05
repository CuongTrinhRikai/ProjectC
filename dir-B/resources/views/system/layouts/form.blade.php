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
                    @section('breadcrumb')
                    @include('system.partials.breadcrumb')
                    @show
                    <div class="page-head clearfix">
                        <div class="row">
                            <div class="col-9">
                                <div class="head-title">

                                    <h4>{{ translate($title) }}</h4>
                                </div><!-- ends head-title -->
                            </div>
                        </div>
                    </div><!-- ends page-head -->

                    <div class="content-display clearfix custom-border">
                        <div class="panel panel-default custom-padding">
                            <div class="panel-body">
                                @include('system.partials.message')
                                <form method="post" action="{{isset($item) ? url($indexUrl.'/'.$item->id) : url($indexUrl)}}" enctype="multipart/form-data" id="Formid">
                                    @csrf
                                    @if(isset($item))
                                    @method('PUT')
                                    @endif
                                    @yield('inputs')
                                    <div class="form-group row">
                                        @section('actionButtons')
                                        <div class="offset-sm-2 col-sm-10 forhiding">
                                            @if (isset($item))
                                            <button type="submit" class="btn btn-primary" id="editVideoButton">

                                            @else
                                            <button type="submit" class="btn btn-primary" id="addVideoButton">
                                            @endif

                                                <i class="fa fa-plus-circle" aria-hidden="true"></i> {{ !isset($item) ? translate('Create') : translate('Update')}}
                                            </button>
                                            <a href="{{url($indexUrl)}}" class="btn btn-secondary">
                                                <em class="far fa-window-close"></em> {{ translate('Cancel') }}
                                            </a>
                                        </div>
                                        @show
                                    </div>
                                    @show

                                    @yield('notificationtext')

                                </form>
                            </div>
                        </div><!-- panel -->
                    </div><!-- ends content-display -->
                </div>
            </div><!-- ends custom-container-fluid -->
        </div><!-- ends page-contents -->
    </div><!-- page-wrapper -->

    @include('system.layouts.layoutFooter')
    @include('system.layouts.editorScript')
    @yield('scripts')
</body>

</html>

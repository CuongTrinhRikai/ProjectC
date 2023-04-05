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
          <div class="page-head clearfix">
            <div class="row">
              <div class="col-6">
                <div class="head-title" style="margin-left: -5px;">
                  <h4>{{ translate($title) }}</h4>
                </div><!-- ends head-title -->
              </div>
              @yield('heading-contents')
            </div>
          </div><!-- ends page-head -->
          @yield('content')
        </div>
      </div>
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

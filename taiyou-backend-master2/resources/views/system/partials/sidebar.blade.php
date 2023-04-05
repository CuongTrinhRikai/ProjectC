<div class="nav-sidebar">
  <div class="inner-navbar clearfix">
    <ul class="ul-sidebar" id="accordion">
      @foreach($modules as $module)
      @if(hasPermissionOnModule($module) && showInSideBar($module['showInSideBar'] ?? true))
      @if($module['hasSubmodules'])
      <li class="panel">
        <a data-toggle="collapse" data-parent="#accordion" href="#sidenav{{$loop->index}}" class="arw collapsed">
          {!! $module['icon'] ?? ''!!}<span class="span-link">{{translate($module['name'])}}</span>
        </a>
        <ul id="sidenav{{$loop->index}}" class="collapse">
          <li><a href="#"></a></li>
          @foreach($module['submodules'] as $subModule)
          @if(hasPermission($subModule['route'], 'get'))
          <li>
            <a class="d-flex align-items-center" href="{{url(PREFIX.$subModule['route'])}}">
              {!! $subModule['icon'] ?? ''!!} <span class="span-link d-inline-block pl-1">{{translate($subModule['name'])}}</span>
            </a>
          </li>
          @endif
          @endforeach
        </ul>
      </li>
      @else
      <li>
        @if(hasPermission($module['route'], 'get'))
        <a href="{{url(PREFIX.$module['route'])}}">
          {!! $module['icon'] ?? ''!!}<span class="span-link">{{translate($module['name'])}}</span>
        </a>
        @endif
      </li>
      @endif
      @endif
      @endforeach
    </ul>
    <a class="toggle-button" role="button" title="Toggle sidebar" type="button">
      <span>{{translate('Collapse Sidebar')}}</span>
    </a>
  </div><!-- ends inner-navbar -->
</div><!-- ends nav-sidebar -->
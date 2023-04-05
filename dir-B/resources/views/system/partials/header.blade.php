<header class="header-navbar" style="background-color: {{ getCmsConfig('cms theme color') }}">
  <div class="container-fluid">
    <div class="header-content clearfix">
      <div class="header-left clearfix pull-left">
        <h1 class="pull-left logo-tag">
          <a href="#">
            <img src="{{asset('uploads/config/')}}/{{ getCmsConfig('cms logo')}}" alt="Ek logo" height="20">
            <span>{{getCmsConfig('cms title')}}</span>
          </a>
        </h1>
      </div>

      <div class="header-right clearfix pull-right">
        <ul class="nav nav-pills">
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="localeDropDown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              {{$globalLocale ?? ''}}
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="localeDropDown">
              @foreach(globalLanguages() as $lang)
              <a href="{{route('set.lang', $lang->language_code ?? '')}}" class="dropdown-item">
              {{$lang->name??''}} ({{$lang->language_code??''}})
              </a>
              @endforeach
            </div>
          </li>

          <li class="nav-item dropdown header-user">

            <a class="nav-link dropdown-toggle" href="#" id="userDropDown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              {{--@if(Auth::user()->image)--}}
              {{--<img class="header-avatar js-lazy-loaded" src="{{asset('uploads/users/'.Auth::user()->image) }}" width="23" height="23" alt="profile">--}}
            {{--@else--}}
              <img class="header-avatar js-lazy-loaded" src="{{asset('images/avatar.png')}}" width="23" height="23" alt="profile">
            {{--@endif--}}
            </a>

            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropDown">
              <div class="li-user dropdown-item">
                <h2>{{Auth::user()->name?? ''}}</h2>
                <p>{{Auth::user() ? Auth::user()->username ?? '': ''}}({{ getRoleCache(authUser())->name??''}})</p>
              </div>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="{{ route('profile') }}">
                {{ translate('Profile') }}
              </a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="{{ route('logout') }}">
                {{ translate('Logout') }}
              </a>

              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
              </form>
            </div>
          </li>
        </ul>
      </div>
    </div>
  </div>
</header>

@props(['action', 'method'])
<form method="{{ $method ?? 'get' }}" action="{{$action}}" class="mb-2">
    <div class="form-row align-items-center">
        {{$inputs}}
        <div class="form-row align-items-center">
        <button class="btn btn-primary mb-2 ml-2" type="submit"><em class="fas fa-search"></em> {{translate('Search')}}</button>
        <a href="{{URL::current()}}"class="btn btn-light mb-2 ml-2"  >{{translate('Clear')}}</a>
        </div>
    </div>
</form>

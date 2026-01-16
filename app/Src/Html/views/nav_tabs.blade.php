<div class="main-nav-tabs">
    <ul class="nav nav-tabs">
        @foreach($arr as $val)
            <li class="nav-item">
                @if(isset($val['url']))
                <a class="nav-link nav-tabs-link @if(isset($val['active'])) active @endif" href="{{$val['url']}}" id="{{isset($val['id'])?$val['id']:null}}">{{$val['name']}}</a>
                @else
                    <a class="nav-link nav-tabs-link @if(isset($val['active'])) active @endif" id="{{isset($val['id'])?$val['id']:null}}">{{$val['name']}}</a>
                @endif
            </li>
        @endforeach
    </ul>
</div>


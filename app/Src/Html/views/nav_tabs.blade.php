<div class="main-nav-tabs">
    <ul class="nav nav-tabs">
        @foreach($arr as $val)
            <li class="nav-item">
                <a class="nav-link nav-tabs-link @if(isset($val['active'])) active @endif" href="{{$val['url']}}">{{$val['name']}}</a>
            </li>
        @endforeach
    </ul>
</div>


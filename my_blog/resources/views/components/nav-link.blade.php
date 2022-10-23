<a class="nav-link {{request()->url()==$routeName? 'active':""}}" aria-current="page" href="{{$routeName}}">
    {{$slot}}
</a>

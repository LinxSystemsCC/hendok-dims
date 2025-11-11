<link rel="stylesheet" href="{{ asset('public/css/all.min.css') }}" />
<link rel="stylesheet" href="{{ asset('/css/myicons.css') }}">

<nav class="sidebar" style="height: 75vh !important">
    <!-- logo -->
    <a href="{{ url('/dashboard') }}">
        <img src="{{ url('/images/HendokLogoTransparent.png') }}" style="height: 70px; width: 100%; padding: 15px 35px 0px 20px;">
    </a>

    <ul class="main_side" style="padding-right: 10px;">
        @php
            $items = getMenuItems();
        @endphp
        @foreach ($items as $item)
            @if (isset($item['is_allow']) && $item['is_allow'] == 1)
                <li>
                    @if (isset($item['href']))
                    <a class="firstmenu {{ isset($item['is_active']) && $item['is_active'] ? 'active1' : '' }}" id="{{ $item['id'] ?? '' }}" href="{!! url($item['href']) !!}">
                        @if (isset($item['icon']))
                            <i class="{{ $item['icon'] }}"></i>
                        @endif
                        {{ $item['name'] }}
                        @if (isset($item['items']) && is_array($item['items']))
                            <span class="caret pull-down"></span>
                        @endif
                    </a>
                    @else
                        <a class="firstmenu" id="{{ $item['id'] ?? '' }}">
                            @if (isset($item['icon']))
                                <i class="{{ $item['icon'] }}"></i>
                            @endif
                            {{ $item['name'] }}
                            <span class="caret pull-down"></span>
                        </a>
                    @endif

                    @if (isset($item['submenuitems1']) && is_array($item['submenuitems1']))
                    <ul class="item-show-{{ $item['id'] }} {{ isset($item['is_active']) && $item['is_active'] ? 'show' : '' }}">
                        @foreach ($item['submenuitems1'] as $submenu1)
                            @if (isset($submenu1['is_allow']) && $submenu1['is_allow'] == 1)
                                <li>
                                    @if (isset($submenu1['href']))
                                        <a class="secondmenu {{ isset($submenu1['is_active']) && $submenu1['is_active'] ? 'active1' : '' }}" id="{{ $submenu1['id'] ?? '' }}" href="{!! url($submenu1['href']) !!}">
                                            @if (isset($submenu1['icon']))
                                                <i class="{{ $submenu1['icon'] }}"></i>
                                            @endif
                                            {{ $submenu1['name'] }}
                                            @if (isset($submenu1['submenuitems']) && is_array($submenu1['submenuitems']))
                                                <span class="caret pull-down"></span>
                                            @endif
                                        </a>
                                    @else
                                        <a class="secondmenu" id="{{ $submenu1['id'] ?? '' }}" >
                                            @if (isset($submenu1['icon']))
                                                <i class="{{ $submenu1['icon'] }}"></i>
                                            @endif
                                            {{ $submenu1['name'] }}
                                            @if (isset($submenu1['submenuitems']) && is_array($submenu1['submenuitems']))
                                                <span class="caret pull-down"></span>
                                            @endif
                                        </a>
                                    @endif
                                    
                                    @if (isset($submenu1['submenuitems']) && is_array($submenu1['submenuitems']))
                                    <ul class="item-show-{{ $submenu1['id'] ?? '' }} {{ isset($submenu1['is_active']) && $submenu1['is_active'] ? 'show' : '' }}">
                                        @foreach ($submenu1['submenuitems'] as $submenu)
                                            @if (isset($submenu['is_allow']) && $submenu['is_allow'] == 1)
                                                <li>
                                                    @if (isset($submenu['href']))
                                                        <a href="{!! url($submenu['href']) !!}" class="{{ isset($submenu['is_active']) && $submenu['is_active'] ? 'active1' : '' }}">{{ $submenu['name'] }}</a>
                                                    @else
                                                        {{ $submenu['name'] }}
                                                    @endif
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                    @endif
                                </li>
                            @endif
                            
                        @endforeach
                    </ul>
                    @endif
                </li>
            @endif
        @endforeach
    </ul>
</nav>

<!-- Logout -->

<nav class="sidebar" style="height: 25vh !important">
    <div style="position: absolute; bottom: 0;">
        <ul>
            <li>
                <a href= "{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();"> <i class="fa fa-sign-out"></i>Logout
                </a>
                <a class="text-light active"> <i class="fa fa-user"></i>
                    @if(Auth::check())
                        Welcome {{ Auth::user()->UserName }}
                    @endif
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
                <img  src="{{url('/images/logo-02.png')}}" style="height: 70px; width: 95%; padding:12px;">
            </li>
        </ul>
    </div>
</nav>

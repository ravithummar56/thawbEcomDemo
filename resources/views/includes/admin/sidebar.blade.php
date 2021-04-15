<!-- BEGIN: Aside Menu -->
<div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-body">
				<!-- BEGIN: Left Aside -->
				
				<div id="m_aside_left" class="m-grid__item	m-aside-left  m-aside-left--skin-dark ">
<div id="m_ver_menu" class="m-aside-menu  m-aside-menu--skin-dark m-aside-menu--submenu-skin-dark " m-menu-vertical="1" m-menu-scrollable="0" m-menu-dropdown-timeout="500" >
        <ul class="m-menu__nav  m-menu__nav--dropdown-submenu-arrow ">
           <li class="m-menu__item  m-menu__item--submenu {{ Request::is('admin/dashboard*') ? 'm-menu__item--active' : ''}}">
                <a  href="{{url::to('admin/dashboard')}}" class="m-menu__link ">
                    <i class="m-menu__link-icon fa fa-line-chart"></i>
                    <span class="m-menu__link-title">
                        <span class="m-menu__link-wrap">
                            <span class="m-menu__link-text">
                                {{trans('sidebar.dashboard')}}
                            </span>
                        </span>
                    </span>
                </a>
            </li>
            <li class="m-menu__item  m-menu__item--submenu {{ Request::is('admin/users*') ? 'm-menu__item--active' : ''}}">
                <a  href="{{url::to('admin/users')}}" class="m-menu__link ">
                    <i class="m-menu__link-icon fa fa-users"></i>
                    <span class="m-menu__link-title">
                        <span class="m-menu__link-wrap">
                            <span class="m-menu__link-text">
                                {{trans('sidebar.user')}}
                            </span>
                        </span>
                    </span>
                </a>
            </li>
            <li class="m-menu__item  m-menu__item--submenu {{ Request::is('admin/fabrics*') ? 'm-menu__item--active' : ''}}">
                <a  href="{{url::to('admin/fabrics')}}" class="m-menu__link ">
                    <i class="m-menu__link-icon fa fa-map-o"></i>
                    <span class="m-menu__link-title">
                        <span class="m-menu__link-wrap">
                            <span class="m-menu__link-text">
                                {{trans('sidebar.fabric')}}
                            </span>
                        </span>
                    </span>
                </a>
            </li>
            <li class="m-menu__item  m-menu__item--submenu {{ Request::is('admin/kandora-style*') || Request::is('admin/collar-style*')|| Request::is('admin/kandora-price*')   ? 'm-menu__item--active m-menu__item--open' : ''}}" aria-haspopup="true"  m-menu-submenu-toggle="hover">
                <a  href="javascript:;" class="m-menu__link m-menu__toggle">
                    <i class="m-menu__link-icon fa fa-thumb-tack"></i>
                    <span class="m-menu__link-text">
                        {{trans('sidebar.kandora')}}
                    </span>
                    <i class="m-menu__ver-arrow la la-angle-right"></i>
                </a>
                <div class="m-menu__submenu ">
                    <span class="m-menu__arrow"></span>
                    <ul class="m-menu__subnav">
                        <li class="m-menu__item {{ Request::is('admin/kandora-style*')  ? 'm-menu__item--active' : ''}}" aria-haspopup="true" >
                            <a  href="{{url::to('admin/kandora-style')}}" class="m-menu__link ">
                                <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                    <span></span>
                                </i>
                                <span class="m-menu__link-text">
                                    {{trans('sidebar.kandora_style')}}
                                </span>
                            </a>
                        </li>
                        <li class="m-menu__item {{ Request::is('admin/collar-style*')  ? 'm-menu__item--active' : ''}}" aria-haspopup="true" >
                            <a  href="{{url::to('admin/collar-style')}}" class="m-menu__link ">
                                <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                    <span></span>
                                </i>
                                <span class="m-menu__link-text">
                                    {{trans('sidebar.collar_sleeve_style')}}
                                </span>
                            </a>
                        </li>
                        <li class="m-menu__item {{ Request::is('admin/kandora-price*')  ? 'm-menu__item--active' : ''}}" aria-haspopup="true" >
                            <a  href="{{url::to('admin/kandora-price')}}" class="m-menu__link ">
                                <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                    <span></span>
                                </i>
                                <span class="m-menu__link-text">
                                    {{trans('sidebar.kandora_price')}}
                                </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="m-menu__item  m-menu__item--submenu {{ Request::is('admin/color*') ? 'm-menu__item--active' : ''}}">
                <a  href="{{url::to('admin/color')}}" class="m-menu__link ">
                    <i class="m-menu__link-icon fa fa-paint-brush"></i>
                    <span class="m-menu__link-title">
                        <span class="m-menu__link-wrap">
                            <span class="m-menu__link-text">
                                {{trans('sidebar.color')}}
                            </span>
                        </span>
                    </span>
                </a>
            </li>
            <li class="m-menu__item  m-menu__item--submenu {{ Request::is('admin/size*') ? 'm-menu__item--active' : ''}}">
                <a  href="{{url::to('admin/size')}}" class="m-menu__link ">
                    <i class="m-menu__link-icon fa  fa-sitemap"></i>
                    <span class="m-menu__link-title">
                        <span class="m-menu__link-wrap">
                            <span class="m-menu__link-text">
                                {{trans('sidebar.size')}}
                            </span>
                        </span>
                    </span>
                </a>
            </li>
            <li class="m-menu__item  m-menu__item--submenu {{ Request::is('admin/product*') ? 'm-menu__item--active' : ''}}">
                <a  href="{{url::to('admin/product')}}" class="m-menu__link ">
                    <i class="m-menu__link-icon fa fa-product-hunt"></i>
                    <span class="m-menu__link-title">
                        <span class="m-menu__link-wrap">
                            <span class="m-menu__link-text">
                                {{trans('sidebar.product')}}
                            </span>
                        </span>
                    </span>
                </a>
            </li>
            <li class="m-menu__item  m-menu__item--submenu {{ Request::is('admin/promotion-code*') ? 'm-menu__item--active' : ''}}">
                <a  href="{{url::to('admin/promotion-code')}}" class="m-menu__link ">
                    <i class="m-menu__link-icon fa fa-bookmark-o"></i>
                    <span class="m-menu__link-title">
                        <span class="m-menu__link-wrap">
                            <span class="m-menu__link-text">
                                {{trans('sidebar.promotionCode')}}
                            </span>
                        </span>
                    </span>
                </a>
            </li>
            <li class="m-menu__item  m-menu__item--submenu {{ Request::is('admin/order*') ? 'm-menu__item--active' : ''}}">
                <a  href="{{url::to('admin/order')}}" class="m-menu__link ">
                    <i class="m-menu__link-icon fa fa-dropbox"></i>
                    <span class="m-menu__link-title">
                        <span class="m-menu__link-wrap">
                            <span class="m-menu__link-text">
                                {{trans('sidebar.order')}}
                            </span>
                        </span>
                    </span>
                </a>
            </li>  
            <li class="m-menu__item  m-menu__item--submenu {{ Request::is('admin/status*') ? 'm-menu__item--active' : ''}}">
                <a  href="{{url::to('admin/status')}}" class="m-menu__link ">
                    <i class="m-menu__link-icon fa fa-weixin"></i>
                    <span class="m-menu__link-title">
                        <span class="m-menu__link-wrap">
                            <span class="m-menu__link-text">
                                {{trans('sidebar.status')}}
                            </span>
                        </span>
                    </span>
                </a>
            </li>
            <li class="m-menu__item  m-menu__item--submenu {{ Request::is('admin/request-trailer*') ? 'm-menu__item--active' : ''}}">
                <a  href="{{url::to('admin/request-trailer')}}" class="m-menu__link ">
                    <i class="m-menu__link-icon fa fa-map-o"></i>
                    <span class="m-menu__link-title">
                        <span class="m-menu__link-wrap">
                            <span class="m-menu__link-text">
                                {{trans('sidebar.request_trailer')}}
                            </span>
                        </span>
                    </span>
                </a>
            </li>
            <li class="m-menu__item  m-menu__item--submenu {{ Request::is('admin/shipping-charg*') ? 'm-menu__item--active' : ''}}">
                <a  href="{{url::to('admin/shipping-charg')}}" class="m-menu__link ">
                    <i class="m-menu__link-icon fa fa-map-o"></i>
                    <span class="m-menu__link-title">
                        <span class="m-menu__link-wrap">
                            <span class="m-menu__link-text">
                                {{trans('sidebar.shipping_charg')}}
                            </span>
                        </span>
                    </span>
                </a>
            </li>    
        </ul>
    </div>
</div>
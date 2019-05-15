<div class="m-header__bottom">
	<div class="m-container m-container--responsive m-container--xxl m-container--full-height m-page__container">
	<div class="m-stack m-stack--ver m-stack--desktop">
	  <!-- begin::Horizontal Menu -->
	  <div class="m-stack__item m-stack__item--middle m-stack__item--fluid">
	    <button class="m-aside-header-menu-mobile-close  m-aside-header-menu-mobile-close--skin-light " id="m_aside_header_menu_mobile_close_btn">
	      <i class="la la-close">
	      </i>
	    </button>
	    <div id="m_header_menu" class="m-header-menu m-aside-header-menu-mobile m-aside-header-menu-mobile--offcanvas  m-header-menu--skin-dark m-header-menu--submenu-skin-light m-aside-header-menu-mobile--skin-light m-aside-header-menu-mobile--submenu-skin-light "  >
	      <ul class="m-menu__nav  m-menu__nav--submenu-arrow ">
	      	@if(Route::currentRouteName() === "overview")
            <li class="m-menu__item m-menu__item--active"  aria-haspopup="true">
            @else
            <li class="m-menu__item" aria-haspopup="true" >
            @endif
	          	@if(Auth::user()->user_type=='2')
		        <a href="{{url('parent/overview')}}" class="m-menu__link ">
		        @else
		        <a href="{{url('overview')}}" class="m-menu__link ">
		        @endif
	            <span class="m-menu__link-text"> 
	              Overview
	            </span>
	          </a>
	        </li> 
	        @if(Route::currentRouteName() === "insight")
            <li class="m-menu__item  m-menu__item--active" aria-haspopup="true" >
            @else
            <li class="m-menu__item" aria-haspopup="true" >
            @endif
	         	@if(Auth::user()->user_type=='2')
                <a href="{{url('parent/insight')}}" class="m-menu__link ">
                @else
                <a href="{{route('insight')}}" class="m-menu__link ">
                @endif
	            <span class="m-menu__link-text"> 								
	              Insights
	            </span>
	          </a>
	        </li> 
            @if(Route::currentRouteName() === "tagging")
            <li class="m-menu__item  m-menu__item--active" aria-haspopup="true" >
            @else
            <li class="m-menu__item  m-menu__item" aria-haspopup="true" >
            @endif
                <a href="{{route('tagging')}}" class="m-menu__link "> 
	            <span class="m-menu__link-text"> 
	              @if(Auth::user()->user_type == '2')         
	                Child 
	                @elseif(Auth::user()->user_type == '3')    
	                Friends        
	                @endif
	            </span>
	          	</a>
            </li> 
	        @if(Route::currentRouteName() === "compare")
            <li class="m-menu__item  m-menu__item--active" aria-haspopup="true" >
            @else
            <li class="m-menu__item  m-menu__item" aria-haspopup="true" >
            @endif
                @if(Auth::user()->user_type=='2')
                <a href="{{url('parent/compare')}}" class="m-menu__link ">
                @else
                <a href="{{route('compare')}}" class="m-menu__link ">
                @endif
	            <span class="m-menu__link-text"> 
	              Compare
	            </span>
	          	</a>
	        </li> 
	      </ul>
	    </div>
	  </div>
	  <!-- end::Horizontal Menu -->	
	</div>
	</div>
</div>
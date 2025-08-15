      <div class="body-section">
        <div class="page-header">
            <button class="toggle-btn dextop"><i class="icon-2"></i></button>
            <div class="header-right">
                <ul class="header-right__icon">
                    <li>
                        <a href="#"><i class="icon-16"></i></a>
                    </li>
                    <li>
                        <a href="#"><i class="icon-17"></i></a>
                    </li>
                </ul>
                <div class="user-dropdown">
                    <div class="user-dropdown__image">
                        <img src="assets/img/user-dropdown__image.ng" alt="" />
                        <p>{{ Auth::user()->name }}</p>
                    </div>
                </div>
            </div>
            <div class="toggle-btn">
                <div class="one"></div>
                <div class="two"></div>
                <div class="three"></div>
            </div>
        </div>
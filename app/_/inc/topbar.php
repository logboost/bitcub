        <div id="topbar">
        	<div class="container-fluid">
        		<div class="row">
        		<div id="topbar-server" class="col-xs-5">
           			<span><? echo $Hoster_name; ?></span>
            	</div>
            	<div id="topbar-logo" class="col-xs-2">
                    <i class="fa fa-cube fa-3x"></i>
                    <div id="cubanim" class="cube-animated" style="display:none">
                        <svg class="icon">
                          <use xlink:href="#icon-waste"></use>
                        </svg>
                        <svg class="icon">
                          <use xlink:href="#icon-waste"></use>
                        </svg>
                        <svg class="icon">
                          <use xlink:href="#icon-waste"></use>
                        </svg>
                    </div>
            	</div>
            	<div id="topbar-user" class="col-xs-5">
                    <? if(!isset($me)) { ?>
            		    <span>Welcome unknown :)</span>
                    <? } else { ?>
                        <span>Welcome, <? echo $me->username; ?></span>
                        <button id="btn-logout" class="btn btn-link" onClick='logout();'>Logout</button>
                    <? } ?>
            	</div>
            	</div>
            </div>
        </div>
<li class="dropdown">
    <a class="dropdown-toggle" href="#" data-toggle="dropdown"><i class="icon-user"></i> Sign Up <strong class="caret"></strong></a>
    <div class="dropdown-menu" style="padding: 15px; padding-bottom: 0px;">
        <form name="registration" action="index.php" method="post" accept-charset="UTF-8">
            <legend>Please sign up</legend>
            <input style="margin-bottom: 15px;" type="text" name="regUser" size="30" placeholder="Username" required/>
            <input style="margin-bottom: 15px;" type="password" name="regPwd" size="30" placeholder="Password" pattern="(\S{4,10})" required/>
            <input style="margin-bottom: 15px;" type="password" name="regConfirmPwd" size="30" placeholder="Confirm password" pattern="(\S{4,10})" required/>
            <p class="robotic" id="pot">
            	<label>If you're human leave this blank:</label>
            	<input name="robotest" type="text" id="robotest" class="robotest"/>
        	</p>
            <input class="btn btn-primary" style="clear: left; width: 100%; height: 32px; margin-bottom: 15px; font-size: 13px;" type="submit" value="Sign Up" />
            <input class="btn btn-primary" style="clear: left; width: 100%; height: 32px; font-size: 13px;" type="submit" value="Sign up with Facebook" />
        </form>
    </div>
</li>
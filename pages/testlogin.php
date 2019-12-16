<form action="#" method="post">
         <!-- wwi_login_h0n3y -->
        <div class="form-group wwi_login_h0n3y">
            <input class="form-control" type="password" id="asfhhfaojaobgobnpg" name="asfhhfaojaobgobnpg" value="<?php echo session_id(); ?>" >
        </div>
            <div class="form-group wwi_login_h0n3y">
            <input class="form-control" type="email" name="email" id="inputEmail" placeholder="Email address">
        </div>
        <div class="form-group wwi_login_h0n3y">
            <input class="form-control" type="password" name="password1" id="inputPassword" placeholder="Password">
        </div>
        <div class="form-group wwi_login_h0n3y">
            <input class="form-control" type="password" name="password2" id="inputPassword" placeholder="Repeat password">
        </div>

        <div class="form-group wwi_login_margin">
            <input class="form-control" type="email" id="iughafvgohwbwh" name="iughafvgohwbwh" required="" placeholder="Email address" autofocus="">
        </div>
        <div class="form-group">
            <input class="form-control" type="password" id="asfjhgwfhkkw" name="asfjhgwfhkkw" required="" placeholder="Password">
        </div>
        <div class="form-group">
            <input class="form-control" type="password" id="wqpbuhwrgwgui" name="wqpbuhwrgwgui" required="" placeholder="Repeat password">
        </div>
        <div class="form-group">
            <button class="btn btn-primary btn-block btn-lg btn-signin wwi_maincolour" style="font-family:Roboto, sans-serif;font-size:16px;font-weight:normal;font-style:normal;" type="submit">Register</button>
        </div>
</form>

<?php
echo showSwall('Something went wrong!', "Can not register.", "error", "");
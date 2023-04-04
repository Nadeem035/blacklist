<div class="login-form mt-5">   
    <div id="signin-form-alert"></div> 
    <form action="process-login" method="post" id="signin-form">
        <div class="avatar"><i class="fas fa-user"></i></div>
        <h4 class="modal-title">Login to Your Account</h4>
        <div class="form-group">
            <input type="email" class="form-control" name="email" placeholder="Email" required="required">
        </div>
        <div class="form-group">
            <input type="password" class="form-control" name="password" placeholder="Password" required="required">
        </div>
        <div class="form-group small clearfix">
            <label class="checkbox-inline"><input type="checkbox"> Remember me</label>
            <a href="javascript://" class="forgot-link">Forgot Password?</a>
        </div> 
        <input type="submit" class="btn btn-primary w-100" value="Login">              
    </form>         
    <div class="text-center small">Don't have an account? <a href="signup">Sign Up</a></div>
</div>


<script>
    $('#signin-form').on('submit', function(event) {
        event.preventDefault();
        $this = $(this);
        $(".theatre-cover-loader").fadeIn(100);
        $.post('<?=BASEURL.'process-login'?>', {data: $this.serialize()}, function(resp) {
            $(".theatre-cover-loader").fadeOut(100);
            resp = $.parseJSON(resp);
            if (resp.status == true) {
                location.reload();
            }else{
                $('#signin-form-alert').html(resp.html);
            }
        });
    });
</script>
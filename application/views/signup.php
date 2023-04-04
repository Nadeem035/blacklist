<div class="login-form mt-5">    
    <div id="signup-form-alert"></div>
    <form action="process-signup" method="post" id="signup-form">
        <div class="avatar"><i class="fas fa-user"></i></div>
        <h4 class="modal-title">Create New Account</h4>
        <div class="form-group">
            <input type="text" class="form-control" name="name" placeholder="Name" required="required">
        </div>
        <div class="form-group">
            <input type="email" class="form-control" name="email" placeholder="Email" required="required">
        </div>
        <div class="form-group">
            <input type="text" class="form-control" name="phone" placeholder="Phone" required="required">
        </div>
        <div class="form-group">
            <input type="password" class="form-control" name="password" placeholder="Password" required="required">
        </div>
        <input type="submit" class="btn btn-primary w-100" value="Sign Up">              
    </form>         
    <div class="text-center small">Already have account? <a href="signin">Sign in</a></div>
</div>


<script>

    $('#signup-form').on('submit', function(event) {
        event.preventDefault();
        $this = $(this);
        $(".theatre-cover-loader").fadeIn(100);
        $.post('<?=BASEURL.'process-signup'?>', {data: $this.serialize()}, function(resp) {
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
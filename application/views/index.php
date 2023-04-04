<div class="container">
    <div class="row">
        <div class="col-lg-8">
            <?php if ($this->session->flashdata('msg')): ?>
                <div class="alert bg-info"><?php echo $this->session->flashdata('msg'); ?></div>
            <?php endif ?>
            <form action="" id="search-blacklist-form" method="post">        
                <div class="search-box">
                    <input class="search-input" name="search" type="text" required="required" placeholder="Search By Name or Phone..">
                    <button class="search-btn"><i class="fas fa-search"></i></button>
                </div>
            </form>
            <div class="mt-5" id="searched-records">
                
            </div>
        </div>   
        <div class="col-lg-4">
            <?php if (!isset($_SESSION['user'])): ?>
                <div class="login-form mb-0">   
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="login-tab" data-bs-toggle="tab" data-bs-target="#login-tab-pane" type="button" role="tab" aria-controls="login-tab-pane" aria-selected="true">Sign In</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="signup-tab" data-bs-toggle="tab" data-bs-target="#signup-tab-pane" type="button" role="tab" aria-controls="signup-tab-pane" aria-selected="false">Sign Up</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="login-tab-pane" role="tabpanel" aria-labelledby="login-tab" tabindex="0">
                            <div id="signin-form-alert"></div> 
                            <form action="process-login" method="post" id="signin-form">
                                <h4 class="modal-title text-uppercase">Sign In</h4>
                                <div class="form-group">
                                    <input type="email" class="form-control" name="email" placeholder="Email" required="required">
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control" name="password" placeholder="Password" required="required">
                                </div>
                                <input type="submit" class="btn btn-primary w-100" value="Sign In">              
                            </form>
                        </div>
                        <div class="tab-pane fade" id="signup-tab-pane" role="tabpanel" aria-labelledby="signup-tab" tabindex="0">
                            <div id="signup-form-alert"></div>
                            <form action="process-signup" method="post" id="signup-form">
                                <h4 class="modal-title text-uppercase">Sign Up</h4>
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
                        </div>
                    </div>
                </div>
            <?php endif ?>

            <div class="ipinfo mt-4">
                <h4 class="mb-4 text-center"><?=$ipinfo['ipinfo']['ip_address']?></h4>
                <div class="d-flex flex-wrap flex-row align-items-center justify-content-between mb-4">
                    <strong>Country</strong>
                    <strong>Total Visiters</strong>
                </div>
                <div class="d-flex flex-wrap flex-row align-items-center justify-content-between">
                    <strong>
                        <img src="<?=$ipinfo['ipinfo']['flag']?>" width="40" alt="">
                        <?=$ipinfo['ipinfo']['country']?>
                    </strong>
                    <strong>
                        <?=$ipinfo['countryInfo']['count_visiter']?>
                    </strong>
                </div>
            </div>
        </div>      
    </div>
</div>



<script>
    $('#search-blacklist-form').on('submit', function(event) {
        event.preventDefault();
        $.post('search-blacklist', {data: $(this).serialize()}, function(resp) {
            resp = $.parseJSON(resp);
            if (resp.status == true) {
                $('#searched-records').html(resp.data);
            }else{
                alert("No Result Found");
            }
        });
    });
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
    $(document).on('click', '.product-display__tile-wrapper', function(event) {
        event.preventDefault();
        if (!$(this).children('.product-display__tile').hasClass('selected')) { 
            $('.product-display__tile, .product-detail').removeClass('selected'); 
        }
        $(this).children('.product-display__tile').toggleClass('selected');
        $(this).next('.product-detail').toggleClass('selected');
    });
</script>
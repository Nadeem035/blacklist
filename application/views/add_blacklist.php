<div class="container">
    <div class="row">
        <div class="col-lg-8">
            <div class="login-form w-100">
                <form action="<?=($mode != 'edit') ? 'post-blacklist' : 'update-blacklist' ?>" method="post">
                    <h4 class="modal-title">
                        <?php if ($mode != 'edit'): ?>
                            Add blacklist Person / Company
                        <?php else: ?>
                            Edit blacklist Person / Company
                            <input type="hidden" name="aid" value="<?=$q['blacklist_id']?>">
                        <?php endif ?>
                    </h4>
                    <div class="row">
                        <div class="col-md-6">
                            <label>Name</label>
                            <div class="form-group">
                                <input type="text" class="form-control" value="<?=$q['name']?>" name="name" placeholder="Name" required="required">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label>Email</label>
                            <div class="form-group">
                                <input type="email" class="form-control" value="<?=$q['email']?>" name="email" placeholder="Email" required="required">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label>Company or Person</label>
                            <div class="form-group">
                                <select name="company_or_person" class="form-select" id="" required="required">
                                    <option value="">Select Company or Person</option>
                                    <option <?=($q['company_or_person'] == 'person') ? 'selected' : '' ?> value="person">Person</option>
                                    <option <?=($q['company_or_person'] == 'company') ? 'selected' : '' ?> value="company">Company</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label>Type</label>
                            <div class="form-group">
                                <select name="type" class="form-select" id="" required="required">
                                    <option value="">Select Type</option>
                                    <option <?=($q['type'] == 'fraud') ? 'selected' : '' ?> value="fraud">Fraud</option>
                                    <option <?=($q['type'] == 'deceit') ? 'selected' : '' ?> value="deceit">Deceit</option>
                                    <option <?=($q['type'] == 'theft') ? 'selected' : '' ?> value="theft">Theft</option>
                                    <option <?=($q['type'] == 'debt') ? 'selected' : '' ?> value="debt">Debt</option>
                                    <option <?=($q['type'] == 'not paying ability') ? 'selected' : '' ?> value="not paying ability">Not Paying Ability</option>
                                    <option <?=($q['type'] == 'murder') ? 'selected' : '' ?> value="murder">Murder</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label>Phone</label>
                            <div class="form-group">
                                <input type="phone" class="form-control" value="<?=$q['phone']?>" name="phone" placeholder="Phone" required="required">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label>Detail</label>
                            <div class="form-group">
                                <textarea name="detail" class="form-control" rows="5" placeholder="Detail Information" required="required"><?=$q['detail']?></textarea>
                            </div>
                        </div>
                        <div class="col-md-12 d-flex flex-wrap">
                            <div class="form-group">
                                <input type="hidden" name="image0" value="<?=$q['image0']?>">
                                <input type="file" class="imageUpload" data-name="image0" >
                            </div>
                            <div class="form-group">
                                <input type="hidden" name="image1" value="<?=$q['image1']?>">
                                <input type="file" class="imageUpload" data-name="image1" >
                            </div>
                            <div class="form-group">
                                <input type="hidden" name="image2" value="<?=$q['image2']?>">
                                <input type="file" class="imageUpload" data-name="image2" >
                            </div>
                            <div class="form-group">
                                <input type="hidden" name="image3" value="<?=$q['image3']?>">
                                <input type="file" class="imageUpload" data-name="image3" >
                            </div>
                            <div class="form-group">
                                <input type="hidden" name="image4" value="<?=$q['image4']?>">
                                <input type="file" class="imageUpload" data-name="image4" >
                            </div>
                            <div class="form-group">
                                <input type="hidden" name="image5" value="<?=$q['image5']?>">
                                <input type="file" class="imageUpload" data-name="image5" >
                            </div>
                        </div>
                    </div>
                    <input type="submit" class="btn btn-primary w-25" value="Submit">              
                </form>
            </div>
        </div> 
    </div>
</div>


<script>
    $(".imageUpload").change(function() {
        $this=$(this);
        $attr = $this.attr('data-name');

        var data = new FormData();
        data.append('img', $(this).prop('files')[0]);
        $.ajax({
            type: 'POST',
            processData: false,
            contentType: false,
            data: data,
            url: '<?=BASEURL?>post-photo-ajax',
            dataType : 'json',
            success: function(resp){
                if (resp.status == true)
                {
                    $("input[name='"+$attr+"']").val(resp.data);
                }
                else
                {
                    alert(resp.msg)
                }
            }
        });
    });
</script>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-12 mt-5">
            <?php if ($this->session->flashdata('msg')): ?>
                <div class="alert bg-info"><?php echo $this->session->flashdata('msg'); ?></div>
            <?php endif ?>
            <div class="table-responsive">
                <h4>All Records</h4>
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Type</th>
                            <th>Company / Person</th>
                            <th>At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Type</th>
                            <th>Company / Person</th>
                            <th>At</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php foreach ($record as $key => $r): ?>
                            <tr>
                                <td><?=$r['name']?></td>
                                <td><?=$r['email']?></td>
                                <td><?=$r['phone']?></td>
                                <td><?=$r['type']?></td>
                                <td><?=$r['company_or_person']?></td>
                                <td><?=DATE("Y-m-d", strtotime($r['at']))?></td>
                                <td>
                                    <a href="edit-blacklist?id=<?=$r['blacklist_id']?>" class="btn btn-sm btn-info"><i class="fas fa-edit"></i></a>
                                    <a href="delete-blacklist?id=<?=$r['blacklist_id']?>" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></a>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>    
                </table>
            </div>
        </div> 
    </div>
</div>

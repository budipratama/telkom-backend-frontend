<?php if($this->session->flashdata('errors') OR validation_errors() OR isset($notif_error)) : ?>
    <div class="alert alert-danger">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <?php echo $this->session->flashdata('errors'); ?>
        <?php echo validation_errors(); ?>
        <?php echo isset($notif_error) ? $notif_error : ''; ?>
    </div>
<?php endif; ?>
<?php if($this->session->flashdata('success') OR isset($notif_success)) : ?>
    <div class="alert alert-success">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <?php echo isset($notif_success) ? $notif_success : $this->session->flashdata('success'); ?>
    </div>
<?php endif; ?>
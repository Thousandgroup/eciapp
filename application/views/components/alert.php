<?php if ($this->session->flashdata('message')): ?>
  <div id="flash-data"
       data-type="<?= $this->session->flashdata('type'); ?>"
       data-message="<?= $this->session->flashdata('message'); ?>">
  </div>
<?php endif; ?>
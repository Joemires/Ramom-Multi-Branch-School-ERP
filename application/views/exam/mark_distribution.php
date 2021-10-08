<link rel="stylesheet" href="https://bootstrap-tagsinput.github.io/bootstrap-tagsinput/dist/bootstrap-tagsinput.css">

<script src="https://cdnjs.cloudflare.com/ajax/libs/typeahead.js/0.11.1/typeahead.bundle.min.js"></script>
<script src="https://bootstrap-tagsinput.github.io/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js"></script>

<style>
	html.dark .bootstrap-tagsinput {
		background-color: #fff;
		border: 1px solid #ccc;
		line-height: 28px;
	}
	.bootstrap-tagsinput .tag {
		background-color: #383838;
		font-size: 14px
	}
	.bootstrap-tagsinput input:not(:focus) {
		width: 10px
	}
.switch {
  display: inline-block;
  height: 28px;
  position: relative;
  width: 60px;
  margin: 0;
}

.switch input {
  display:none;
}

.slider {
  background-color: #ccc;
  bottom: 0;
  cursor: pointer;
  left: 0;
  position: absolute;
  right: 0;
  top: 0;
  transition: .4s;
}

.slider:before {
  background-color: #fff;
  bottom: 4px;
  content: "";
  height: 20px;
  left: 6px;
  position: absolute;
  transition: .4s;
  width: 20px;
}

input:checked + .slider {
  background-color: #66bb6a;
}

input:checked + .slider:before {
  transform: translateX(26px);
}

.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}
</style>

<div class="row">
<?php if (get_permission('mark_distribution', 'is_add')): ?>
	<div class="col-md-5">
		<section class="panel">
			<header class="panel-heading">
				<h4 class="panel-title"><i class="far fa-edit"></i> <?=translate('add') . " " . translate('mark_distribution')?></h4>
			</header>
			<?php echo form_open($this->uri->uri_string());?>
				<div class="panel-body">
					<?php if (is_superadmin_loggedin()): ?>
					<div class="form-group">
						<label class="control-label"><?=translate('branch')?> <span class="required">*</span></label>
						<?php
							$arrayBranch = $this->app_lib->getSelectList('branch');
							echo form_dropdown("branch_id", $arrayBranch, set_value('branch_id'), "class='form-control' id='branch_id'
							data-plugin-selectTwo data-width='100%' data-minimum-results-for-search='Infinity'");
						?>
						<span class="error"><?=form_error('branch_id')?></span>
					</div>
					<?php endif; ?>
					<div class="form-group mb-md">
						<label class="control-label"><?=translate('name')?> <span class="required">*</span></label>
						<input type="text" class="form-control" name="name" value="<?=set_value('name')?>" />
						<span class="error"><?=form_error('name')?></span>
					</div>
					<!-- <div class="form-group mb-md" style="display: none; align-items: center; flex-wrap: wrap">
						<label class="control-label">Extra Activity Mark</label>
						<label class="switch" for="checkbox" style="margin-left: 10px">
							<input type="checkbox" id="checkbox" name="type" value="extra" onchange="$('.mark-tags').toggle()">
							<div class="slider round"></div>
						</label>
						<span class="small text-muted" style="width: 100%">Check if this mark distribution is extra curreculum activity</span>
					</div>
					
					<div class="form-group mark-tags" style="display: none">
						<label class="control-label">Scoring Sections <span class="required">*</span></label>
						<div class="bs-example">
							<input type="text" name="extra-tags" value="Amsterdam,Washington,Sydney,Beijing,Cairo" data-role="tagsinput">
						</div>
					</div> -->

				</div>
				<div class="panel-footer">
					<div class="row">
						<div class="col-md-12">
							<button class="btn btn-default pull-right" type="submit" name="save" value="1">
								<i class="fas fa-plus-circle"></i> <?=translate('save')?>
							</button>
						</div>	
					</div>
				</div>
			<?php echo form_close();?>
		</section>
	</div>
<?php endif; ?>
<?php if (get_permission('mark_distribution', 'is_view')): ?>
	<div class="col-md-<?php if (get_permission('mark_distribution', 'is_add')){ echo "7"; }else{ echo "12"; } ?>">
		<section class="panel">
			<header class="panel-heading">
				<h4 class="panel-title"><i class="fas fa-list-ul"></i>  <?=translate('mark_distribution') . " " . translate('list')?></h4>
			</header>
			<div class="panel-body">
				<div class="table-responsive">
					<table class="table table-bordered table-hover table-condensed mb-none">
						<thead>
							<tr>
								<th><?=translate('sl')?></th>
								<th><?=translate('branch')?></th>
								<th><?=translate('name')?></th>
								<th><?=translate('action')?></th>
							</tr>
						</thead>
						<tbody>
							<?php
							$count = 1;
							if (count($termlist)){
								foreach ($termlist as $row):
							?>
							<tr>
								<td><?php echo $count++;?></td>
								<td><?php echo $row['branch_name']; ?></td>
								<td><?php echo $row['name']; ?></td>
								<td>
								<?php if (get_permission('mark_distribution', 'is_edit')): ?>
									<!-- update link -->
									<a class="btn btn-default btn-circle icon" href="javascript:void(0);" onclick="getCategoryModal(this)"
									data-id="<?=$row['id']?>" data-name="<?=$row['name']?>" data-branch="<?=$row['branch_id']?>">
										<i class="fas fa-pen-nib"></i>
									</a>
								<?php endif; if (get_permission('mark_distribution', 'is_delete')): ?>
									<!-- delete link -->
									<?php echo btn_delete('exam/mark_distribution_delete/' . $row['id']);?>
								<?php endif; ?>
								</td>
							</tr>
							<?php
								endforeach;
							}else{
								echo '<tr><td colspan="4"><h5 class="text-danger text-center">' . translate('no_information_available') . '</td></tr>';
							}
							?>
						</tbody>
					</table>
				</div>
			</div>
		</section>
	</div>
</div>
<?php endif; ?>
<?php if (get_permission('mark_distribution', 'is_edit')): ?>
<div class="zoom-anim-dialog modal-block modal-block-primary mfp-hide" id="modal">
	<section class="panel">
		<?php echo form_open('exam/mark_distribution_edit', array('class' => 'frm-submit')); ?>
			<header class="panel-heading">
				<h4 class="panel-title"><i class="far fa-edit"></i> <?=translate('edit') . " " . translate('mark_distribution')?></h4>
			</header>
			<div class="panel-body">
				<input type="hidden" name="distribution_id" id="ecategory_id" value="" />
				<?php if (is_superadmin_loggedin()): ?>
				<div class="form-group">
					<label class="control-label"><?=translate('branch')?> <span class="required">*</span></label>
					<?php
						$arrayBranch = $this->app_lib->getSelectList('branch');
						echo form_dropdown("branch_id", $arrayBranch, set_value('branch_id'), "class='form-control' id='ebranch_id'
						id='branch_id' data-plugin-selectTwo data-width='100%' data-minimum-results-for-search='Infinity'");
					?>
					<span class="error"></span>
				</div>
				<?php endif; ?>
				<div class="form-group mb-md">
					<label class="control-label"><?=translate('name')?> <span class="required">*</span></label>
					<input type="text" class="form-control" name="name" id="ename" value="" />
					<span class="error"></span>
				</div>
			</div>
			<footer class="panel-footer">
				<div class="row">
					<div class="col-md-12 text-right">
						<button type="submit" class="btn btn-default" data-loading-text="<i class='fas fa-spinner fa-spin'></i> Processing">
							<i class="fas fa-plus-circle"></i> <?=translate('update')?>
						</button>
						<button class="btn btn-default modal-dismiss"><?=translate('cancel')?></button>
					</div>
				</div>
			</footer>
		<?php echo form_close();?>
	</section>
</div>
<?php endif; ?>

<script>
	$(document).ready( () => {
		$("#inputTag").tagsinput('items');
	})
</script>
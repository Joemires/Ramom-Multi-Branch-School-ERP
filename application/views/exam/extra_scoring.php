<?php
$widget = (is_superadmin_loggedin() ? 2 : 3);
?>
<div class="row">
	<div class="col-md-12">
		<section class="panel">
			<?php echo form_open($this->uri->uri_string(), array('class' => 'validate')); ?>
			<header class="panel-heading">
				<h4 class="panel-title"><?= translate('select_ground') ?></h4>
			</header>
			<div class="panel-body">
				<div class="row mb-sm">
					<?php if (is_superadmin_loggedin()) : ?>
						<div class="col-md-2 mb-sm">
							<div class="form-group">
								<label class="control-label"><?= translate('branch') ?> <span class="required">*</span></label>
								<?php
								$arrayBranch = $this->app_lib->getSelectList('branch');
								echo form_dropdown("branch_id", $arrayBranch, set_value('branch_id'), "class='form-control' id='branch_id'
								data-plugin-selectTwo data-width='100%' data-minimum-results-for-search='Infinity'");
								?>
							</div>
						</div>
					<?php endif; ?>
					<div class="col-md-<?php echo $widget; ?> mb-sm">
						<div class="form-group">
							<label class="control-label"><?= translate('exam') ?> <span class="required">*</span></label>
							<?php
							if (isset($branch_id)) {
								$arrayExam = array("" => translate('select'));
								$exams = $this->db->get_where('exam', array('branch_id' => $branch_id, 'session_id' => get_session_id()))->result();
								foreach ($exams as $row) {
									$arrayExam[$row->id] = $this->application_model->exam_name_by_id($row->id);
								}
							} else {
								$arrayExam = array("" => translate('select_branch_first'));
							}
							echo form_dropdown("exam_id", $arrayExam, set_value('exam_id'), "class='form-control' id='exam_id' required data-plugin-selectTwo
								data-width='100%' data-minimum-results-for-search='Infinity' ");
							?>
						</div>
					</div>
					<div class="col-md-3 mb-sm">
						<div class="form-group">
							<label class="control-label"><?= translate('class') ?> <span class="required">*</span></label>
							<?php
							$arrayClass = $this->app_lib->getClass($branch_id);
							echo form_dropdown("class_id", $arrayClass, set_value('class_id'), "class='form-control' id='class_id' onchange='getSectionByClass(this.value,0)'
								required data-plugin-selectTwo data-width='100%' data-minimum-results-for-search='Infinity' ");
							?>
						</div>
					</div>
					<div class="col-md-<?php echo $widget; ?> mb-sm">
						<div class="form-group">
							<label class="control-label"><?= translate('section') ?> <span class="required">*</span></label>
							<?php
							$arraySection = $this->app_lib->getSections(set_value('class_id'), false);
							echo form_dropdown("section_id", $arraySection, set_value('section_id'), "class='form-control' id='section_id' required
								data-plugin-selectTwo data-width='100%' data-minimum-results-for-search='Infinity' ");
							?>
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<label class="control-label"><?= translate('student') ?> <span class="required">*</span></label>
							<?php
							if (!empty(set_value('student_id'))) {
								$arraySubject = array("" => translate('select'));
								$query = $this->student_model->getStudentList(set_value('class_id'), set_value('section_id'), set_value('branch_id'));
								$students = $query->result_array();
								foreach ($students as $row) {
									$arraySubject[$row['student_id']] =  ucwords(strtolower($row['fullname']));
								}
							} else {
								$arraySubject = array("" => translate('select_class_first'));
							}
							echo form_dropdown("student_id", $arraySubject, set_value('student_id'), "class='form-control' id='student_id' required
								data-plugin-selectTwo data-width='100%' data-minimum-results-for-search='Infinity' ");
							?>
						</div>
					</div>
				</div>
			</div>
			<footer class="panel-footer">
				<div class="row">
					<div class="col-md-offset-10 col-md-2">
						<button type="submit" name="search" value="1" class="btn btn btn-default btn-block"> <i class="fas fa-filter"></i> <?= translate('filter') ?></button>
					</div>
				</div>
			</footer>
			<?php echo form_close(); ?>
		</section>

		<?php if (isset($extra_scores)) : ?>
			<section class="panel appear-animation" data-appear-animation="<?php echo $global_config['animations']; ?>" data-appear-animation-delay="100">
				<?php echo form_open('exam/extra_scoring_save', array('class' => 'frm-submit-msg'));
				$data = array(
					'class_id' => $class_id,
					'section_id' => $section_id,
					'exam_id' => $exam_id,
					'student_id' => $student_id,
					'session_id' => get_session_id(),
					'branch_id' => $branch_id
				);

                // print_r($extra_scores);
				echo form_hidden($data);
				?>
				<header class="panel-heading">
					<h4 class="panel-title"><i class="fas fa-users"></i> Extra Curriculum Entries </h4>
				</header>
				<div class="panel-body">
                    <?php
                        foreach($extra_scores as $title => $extra_score) {?>
                            <div class="container-fluid">
                                <h4> <?= ucwords(str_replace('slash', '/', str_replace('_', ' ', $title))) ?> </h4>
                                    <div class="row">
                                        <?php
                                        foreach($extra_score as $label => $score) { ?>
                                            <div class="form-group col-lg-4">
                                                <label for=""> <?= ucwords(str_replace('slash', '/', str_replace('_', ' ', $label))) ?> </label>
                                                <input type="number" class="form-control" name="extra_scores[<?= $title ?>][<?= $label ?>][score]" value="<?= $score['score'] ?>" placeholder="0" max="<?= $score['max'] ?>">
                                                
                                                <input type="hidden" name="extra_scores[<?= $title ?>][<?= $label ?>][max]" value="<?= $score['max'] ?>">
                                            </div>
                                        <?php }
                                        ?>
                                    </div>
                                <hr>
                            </div>
                        <?php }
                    ?>
				</div>
				<div class="panel-footer">
					<div class="row">
						<div class="col-md-offset-10 col-md-2">
							<button type="submit" class="btn btn-default btn-block">
								<i class="fas fa-plus-circle"></i> <?= translate('save') ?>
							</button>
						</div>
					</div>
				</div>
				<?php echo form_close(); ?>
			</section>
		<?php endif; ?>
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function() {
		$('#branch_id').on('change', function() {
			var branchID = $(this).val();
			getClassByBranch(branchID);
			getExamByBranch(branchID);
			$('#subject_id').html('').append('<option value=""><?= translate("select") ?></option>');
		});

		$('#section_id').on('change', function() {
            var branchID = $('#branch_id').val();
			var classID = $('#class_id').val();
			var sectionID = $(this).val();
			$.ajax({
				url: base_url + 'student/getByClassSection',
				type: 'POST',
				data: {
                    branchID: branchID,
					classID: classID,
					sectionID: sectionID
				},
				success: function(data) {
                    // console.log(data);
					$('#student_id').html(data);
				}
			});
		});
		
	});

</script>
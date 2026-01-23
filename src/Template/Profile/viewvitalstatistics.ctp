<?php echo $this->element('viewprofile') ?>
<div class="col-sm-9 my-info vital_Sta">
	<div class="col-sm-12 prsnl-det">
		<div class="clearfix">
			<h4 class="pull-left">Vital<span> Statistics</span></h4>
			<div class="pull-right"></div>
		</div>



		<?php $i = 0;
		foreach ($uservitals as $vitalss) {   //pr($vitalss);
		?>
			<?php if (!empty($vitalss['voption']['value']) || !empty($vitalss['value'])) { ?>
				<div class="form-group">
					<label for="" class="col-sm-4 control-label"><?php echo $vitalss['vque']['question'] ?>:</label>
					<div class="col-sm-6">
						<?php if ($vitalss['voption']['value'] != '') { ?>
							<?php echo $vitalss['voption']['value']; ?>

						<?php } else { ?>
							<?php echo $vitalss['value']; ?>
						<?php } ?>
					</div>
					<div class="col-sm-2"></div>
				</div>
		<?php }
		} ?>



	</div>
</div>
</div>
</div>
</div>
<div id="Pro-Summary" class="tab-pane fade">
	<div class="container m-top-60"> </div>
</div>
<div id="Perfo-Des" class="tab-pane fade">
	<div class="container m-top-60"> </div>
</div>
<div id="Gallery" class="tab-pane fade">
	<div class="container m-top-60"> </div>
</div>
<div id="Vital" class="tab-pane fade">
	<div class="container m-top-60"> </div>
</div>
</div>
</div>
</div>
</section>
<!-------------------------------------------------->
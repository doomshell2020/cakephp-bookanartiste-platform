	  
<?php 

foreach ($performance_subgenre as $performance_subgenrekey => $performance_subgenrevalue) { 
		//echo "<pre>"; print_r($performance_subgenrevalue);

	$subgenrearray[]= $performance_subgenrevalue['subgenre_id'];

}

?>

<?php echo  $this->element('viewprofile') ?>
<div class="col-sm-9 my-info">
    <?php if($perdes->performance_desc || $perdes->setup_requirement || $perdes->infulences || $genre) { ?>
	<div class="col-sm-12 prsnl-det">


		<ul class="p_detail_ul_list">
		    <?php if($perdes->performance_desc){ ?>
			<li class="dtl_li">
				<ul class="row">
					<li class="col-sm-12">Performance,Work Description</li>
					<li class="col-sm-12"><span class="li_discription_dtl"><?php echo $perdes->performance_desc; ?></span></li>
				</ul>
			</li>
			<?php } ?>
			<?php if($perdes->setup_requirement){ ?>
			<li class="dtl_li">
				<ul class="row">
					<li class="col-sm-12">Special Requirements</li>
					<li class="col-sm-12"><span class="li_discription_dtl"><?php echo $perdes->setup_requirement; ?></span></li>
				</ul>
			</li>
			<?php } ?>
			
			<?php if($perdes->infulences!=''){ ?>
				<li class="dtl_li">
					<ul class="row">
						<li class="col-sm-5">Performance Language(s)</li>
						<li class="col-sm-1">:</li>
						<li class="col-sm-6"><span>
						    <?php foreach($languageknow as $language){  echo $language['language']['name']; } ?></span></li>
					</ul>
				</li>
			<?php } ?>
			<?php if($perdes->infulences!=''){ ?>
				<li class="dtl_li">
					<ul class="row">
						<li class="col-sm-5">Influenced by</li>
						<li class="col-sm-1">:</li>
						<li class="col-sm-6"><span><?php echo $perdes->infulences; ?></span></li>
					</ul>     
				</li>
			<?php } ?>
			<?php if($genre){ ?>
			<li class="dtl_li">
				<ul class="row">
					<li class="col-sm-5">Genre</li>
					<li class="col-sm-1">:</li>
					<li class="col-sm-6"><span><?php 
					if($genre)
					{
						$generes = '';
					foreach ($genre as $gen) { //pr($gen);
						if(!empty($generes))
						{
							$generes =  $generes.', '.$gen->Genre->name;
						}
						else
						{
							$generes =  $gen->Genre->name;
						}


					}
					echo $generes; 
				}
				?></span></li>
			</ul>
		</li>
		<?php } ?>
		<?php if($subgenre)
		{ ?>
			<li class="dtl_li">
				<ul class="row">
					<li class="col-sm-5">SubGenre</li>
					<li class="col-sm-1">:</li>
					<li class="col-sm-6"><span><?php


					$subgenres = '';
					foreach($subgenre as $subgen)
					{ 
						if(in_array($subgen['id'], $subgenrearray))
						{
							$subgenres = $subgenres.' '.$subgen['name'].',';
						}
					}
					echo $subgenres;


					?></span></li>
				</ul>
			</li>

		<?php    } ?>

		
		
		<?php /* ?><div class="form-group">
			<label for="" class="col-sm-4 control-label">Payment Terms And Conditions </label>
			<div class="col-sm-6">
						
				<?php echo $proff->paytermsandcondition; ?>
			</div>
			<div class="col-sm-2"></div>
		</div>
		
		<?php */ ?>

		
	</ul>

</div>

	<?php } ?>




<div class="col-sm-12 prsnl-det summ-det m-top-20">
	<h4 class=""><span>Charges</span> </h4>


	<?php 

		//pr($payfrequency);
	if(count($payfrequency)>0)
		{ ?>
			
			
			<div class=""> 

				<div class="table-responsive">

					<div class="multi-field-wrapperpayment">
						<table class="table table-bordered">


							<thead class="th_bg_clr">
								<tr>
									<th> Charges Type</th> 
									<th>Currency</th>
									<th>Charges</th>

								</tr>
							</thead>

							<tbody class="payment_container">
								<?php foreach($payfrequency as $frequency){
			//pr($frequency);
									?>	

									<tr class="payment_details table-bordered">



										<td><p><?php echo $frequency->paymentfequency->name; ?></p></td>

										<td><p><?php echo  $frequency->currency->name; ?></p></td>

										<td><p><?php echo  $frequency->amount; ?></p></td>

									</tr>


								</div>

							<?php }?> 
						</tbody>
					</table>
				</div>


			</div>  

		<?php } else { 
		
		echo "No Charges Available"; 
		}
		?>
		
		
	</div>

<!-- by rupam sir  -->
	<!-- <div class="col-sm-12 prsnl-det summ-det m-top-20">
		<h4 class="">Personnel <span>Details</span></h4>



		<?php 
		
		if(count($videoprofile)>0)
			{ ?>
				<div class="working-det">
					<?php foreach($videoprofile as $personals){?>	

						<div class="form-group">


							<div class="form-group">
								<div class="col-sm-6">
									<p><a href="<?php echo $personals->url; ?>"><?php echo $personals->name; ?></a></p>
								</div>
								<div class="col-sm-2"></div>
							</div>
						</div>  
					<?php }?>
				</div>  
			<?php  } else { 
		
		echo "No Personnel Details Available"; 
		}
		?>
		</div> -->
		<!-- end this code  -->
		<!-- column is visible and not visible -->

		<?php 
if (!empty($videoprofile)) { ?>
    
        <div class="summ-det ">
            <h4 class="">Personnel <span>Details</span></h4>
            <?php foreach ($videoprofile as $personals) { ?>
                <div class="form-group row">
                    <div class="col-sm-6 personnel_links">
                        <p><a href="<?php echo $personals->url; ?>"><?php echo $personals->name; ?></a></p>
					
                    </div>
				
                    <!-- <div class="col-sm-2"></div> -->
                
            <?php } ?>
        </div>
    </div>
<?php } else { 
    // echo "No Personnel Details Available"; 
}
?>

<!-- end code  -->


		<div class="">

			<div class="clearfix">
				<h4 class="pull-left">Open <span> To Travel</span></h4>

			</div>
			<ul class="p_detail_ul_list">

				<?php 


				if ($perdes->opentotravel!=''){ ?>
					<li class="dtl_li">

						<ul class="row">
							<li class="col-sm-5">Open To Travel</li>
							<li class="col-sm-1">:</li>
							<li class="col-sm-6"><span><?php $opentravel=array('Y'=>'Yes','N'=>'No'); ?>
							<?php echo $opentravel[$perdes->opentotravel]; ?></span>
						</li>
					</ul>


				</li>
			<?php } ?>
			<?php if($perdes['opentotravel']!='N') { ?>
			<li class="dtl_li">
				<ul class="row">
					<li class="col-sm-12" <?php if($perdes['opentotravel']!='Y'){ ?>style="display:none"<?php } ?>>Travel Description</li>
					<li class="col-sm-12"><span class="li_discription_dtl"><span><?php echo $perdes->description;?></span></span></li>
				</ul>
			</li>
		<?php } ?>

		</ul>
	</div>


	
	<?php if ($perdes['acceptassignment']==1){ ?>
		<div class="col-sm-12 prsnl-det summ-det m-top-20">
			<h4 class=""><span>
				<p> <?php echo $profile->name; ?> is Open to accepting interesting assignment for free</p>
			</span> </h4>
			</div><?php } ?>


		</div>

	</div> </div>
</div>
</div>
</div>
</div>
</div>
</section>

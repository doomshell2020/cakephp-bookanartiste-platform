 <table class="table table-bordered table-striped">
    <thead>
      <tr>
        <th><b>Title</b></th>
        <th><b>Reviews</b></th>
      </tr>
    </thead>
    <tbody>
    
      
      
    
<?php 
	//pr($activities);
	if(count($review)>0){ 
	foreach($review as $reviewusers){ //pr($reviewusers);?>
		<tr>
                <td>  <b><?php echo R1; ?> </b></td>
                      <td><fieldset id='demo1' class="ratingusers">
                    
                        <input class="stars" type="radio" id="starr15 <?php echo $reviewusers['id']; ?>" name="r1 <?php echo $reviewusers['id']; ?>" value="5" <?php if($reviewusers['r1']==5){ echo "checked"; }?>  disabled />
                        <span class = "review full" for="starr15 <?php echo $reviewusers['id']; ?>" title="Awesome - 5 stars"></span>
                        
                        <input class="stars" type="radio" id="starr14half <?php echo $reviewusers['id']; ?>" name="r1 <?php echo $reviewusers['id']; ?>" value="4.5" <?php if($reviewusers['r1']==4.5){ echo "checked"; }?> disabled />
                        <span class="review half" for="starr14half <?php echo $reviewusers['id']; ?>" title="Pretty good - 4.5 stars"></span>
                        
                        <input class="stars" type="radio" id="starr14 <?php echo $reviewusers['id']; ?>" name="r1 <?php echo $reviewusers['id']; ?>" value="4" <?php if($reviewusers['r1']==4){ echo "checked"; }?> disabled />
                        <span class = "review full" for="starr14 <?php echo $reviewusers['id']; ?>" title="Pretty good - 4 stars"></span>
                        
                        <input class="stars" type="radio" id="starr13half <?php echo $reviewusers['id']; ?>" name="r1 <?php echo $reviewusers['id']; ?>" value="3.5" <?php if($reviewusers['r1']==3.5){ echo "checked"; } ?> disabled />
                        <span class="review half" for="starr13half <?php echo $reviewusers['id']; ?>" title="Meh - 3.5 stars"></span>
                        
                        <input class="stars" type="radio" id="starr13 <?php echo $reviewusers['id']; ?>" name="r1 <?php echo $reviewusers['id']; ?>" value="3" <?php if($reviewusers['r1']==3){ echo "checked"; }?> disabled />
                        <span class = "review full" for="starr13 <?php echo $reviewusers['id']; ?>" title="Meh - 3 stars"></span>
                        
                        <input class="stars" type="radio" id="starr12half <?php echo $reviewusers['id']; ?>" name="r1 <?php echo $reviewusers['id']; ?>" value="2.5" <?php if($reviewusers['r1']==2.5){ echo "checked"; } ?> disabled />
                        <span class="review half" for="starr12half <?php echo $reviewusers['id']; ?>" title="Kinda bad - 2.5 stars"></span>
                        
                        <input class="stars" type="radio" id="starr12 <?php echo $reviewusers['id']; ?>" name="r1 <?php echo $reviewusers['id']; ?>" value="2" <?php if($reviewusers['r1']==2){ echo "checked"; }?> disabled />
                        <span class = "review full" for="starr12 <?php echo $reviewusers['id']; ?>" title="Kinda bad - 2 stars"></span>
                        
                        <input class="stars" type="radio" id="starr11half <?php echo $reviewusers['id']; ?>" name="r1 <?php echo $reviewusers['id']; ?>" value="1.5" <?php if($reviewusers['r1']==1.5){ echo "checked"; } ?> disabled />
                        <span class="review half" for="starr11half <?php echo $reviewusers['id']; ?>" title="Meh - 1.5 stars"></span>
                        
                        <input class="stars" type="radio" id="starr11 <?php echo $reviewusers['id']; ?>" name="r1 <?php echo $reviewusers['id']; ?>" value="1" <?php if($reviewusers['r1']==1){ echo "checked"; }?> disabled />
                        <span class = "review full" for="starr11 <?php echo $reviewusers['id']; ?>" title="Sucks big time - 1 star"></span>
                        
                        <input class="stars" type="radio" id="starr1half <?php echo $reviewusers['id']; ?>" name="r1 <?php echo $reviewusers['id']; ?>" value="0.5" <?php if($reviewusers['r1']==0.5){ echo "checked"; } ?> disabled />
                        <span class="review half" for="starr1half <?php echo $reviewusers['id']; ?>" title="Sucks big time - 0.5 stars"></span>
                    </fieldset></td>
              </div> 
                  
                
	    </tr>
	     <tr>
                <td> <b><?php echo R2; ?> </b></td>
                      <td><fieldset id='demo2' class="ratingusers">
                        <input class="stars" type="radio" id="starr25<?php echo $reviewusers['id']; ?>" name="r2<?php echo $reviewusers['id']; ?>" value="5" <?php if($reviewusers['r2']==5){ echo "checked"; }?>  disabled />
                        <span class = "review full" for="starr25<?php echo $reviewusers['id']; ?>" title="Awesome - 5 stars"></span>
                        
                        <input class="stars" type="radio" id="starr24half<?php echo $reviewusers['id']; ?>" name="r2<?php echo $reviewusers['id']; ?>" value="4.5" <?php if($reviewusers['r2']==4.5){ echo "checked"; }?>  disabled />
                        <span class="review half" for="starr24half<?php echo $reviewusers['id']; ?>" title="Pretty good - 4.5 stars"></span>
                        
                        <input class="stars" type="radio" id="starr24<?php echo $reviewusers['id']; ?>" name="r2<?php echo $reviewusers['id']; ?>" value="4" <?php if($reviewusers['r2']==4){ echo "checked"; }?>  disabled />
                        <span class = "review full" for="starr24<?php echo $reviewusers['id']; ?>" title="Pretty good - 4 stars"></span>
                        
                        <input class="stars" type="radio" id="starr23half<?php echo $reviewusers['id']; ?>" name="r2<?php echo $reviewusers['id']; ?>" value="3.5" <?php if($reviewusers['r2']==3.5){ echo "checked"; }?>  disabled />
                        <span class="review half" for="starr23half<?php echo $reviewusers['id']; ?>" title="Meh - 3.5 stars"></span>
                        
                        <input class="stars" type="radio" id="starr23<?php echo $reviewusers['id']; ?>" name="r2<?php echo $reviewusers['id']; ?>" value="3" <?php if($reviewusers['r2']==3){ echo "checked"; }?>  disabled />
                        <span class = "review full" for="starr23<?php echo $reviewusers['id']; ?>" title="Meh - 3 stars"></span>
                        
                        <input class="stars" type="radio" id="starr22half<?php echo $reviewusers['id']; ?>" name="r2<?php echo $reviewusers['id']; ?>" value="2.5" <?php if($reviewusers['r2']==2.5){ echo "checked"; }?>  disabled />
                        <span class="review half" for="starr22half<?php echo $reviewusers['id']; ?>" title="Kinda bad - 2.5 stars"></span>
                        
                        <input class="stars" type="radio" id="starr22<?php echo $reviewusers['id']; ?>" name="r2<?php echo $reviewusers['id']; ?>" value="2" <?php if($reviewusers['r2']==2){ echo "checked"; }?>  disabled />
                        <span class = "review full" for="starr22<?php echo $reviewusers['id']; ?>" title="Kinda bad - 2 stars"></span>
                        
                        <input class="stars" type="radio" id="starr21half<?php echo $reviewusers['id']; ?>" name="r2<?php echo $reviewusers['id']; ?>" value="1.5" <?php if($reviewusers['r2']==1.5){ echo "checked"; }?>  disabled />
                        <span class="review half" for="starr21half<?php echo $reviewusers['id']; ?>" title="Meh - 1.5 stars"></span>
                        
                        <input class="stars" type="radio" id="starr21<?php echo $reviewusers['id']; ?>" name="r2<?php echo $reviewusers['id']; ?>" value="1" <?php if($reviewusers['r2']==1){ echo "checked"; }?>  disabled />
                        <span class = "review full" for="starr21<?php echo $reviewusers['id']; ?>" title="Sucks big time - 1 star"></span>
                        
                        <input class="stars" type="radio" id="starr2half<?php echo $reviewusers['id']; ?>" name="r2<?php echo $reviewusers['id']; ?>" value="0.5" <?php if($reviewusers['r2']==0.5){ echo "checked"; }?>  disabled />
                        <span class="review half" for="starr2half<?php echo $reviewusers['id']; ?>" title="Sucks big time - 0.5 stars"></span>
                    </fieldset></td>
                     </div>  </tr>
                     
	    <tr>
                 <td> <b><?php echo R3; ?> </b></td>
                 
                      <td><fieldset id='demo3' class="ratingusers">
                    
                        <input class="stars" type="radio" id="starr35<?php echo $reviewusers['id']; ?>" name="r3<?php echo $reviewusers['id']; ?>" value="5" <?php if($reviewusers['r3']==5){ echo "checked"; }?>  disabled  />
                        <span class = "review full" for="starr35<?php echo $reviewusers['id']; ?>" title="Awesome - 5 stars"></span>
                        
                        <input class="stars" type="radio" id="starr34half<?php echo $reviewusers['id']; ?>" name="r3<?php echo $reviewusers['id']; ?>" value="4.5" <?php if($reviewusers['r3']==4.5){ echo "checked"; }?>  disabled  />
                        <span class="review half" for="starr34half<?php echo $reviewusers['id']; ?>" title="Pretty good - 4.5 stars"></span>
                        
                        <input class="stars" type="radio" id="starr34<?php echo $reviewusers['id']; ?>" name="r3<?php echo $reviewusers['id']; ?>" value="4" <?php if($reviewusers['r3']==4){ echo "checked"; }?>  disabled  />
                        <span class = "review full" for="starr34<?php echo $reviewusers['id']; ?>" title="Pretty good - 4 stars"></span>
                        
                        <input class="stars" type="radio" id="starr33half<?php echo $reviewusers['id']; ?>" name="r3<?php echo $reviewusers['id']; ?>" value="3.5" <?php if($reviewusers['r3']==3.5){ echo "checked"; }?>  disabled  />
                        <span class="review half" for="starr33half<?php echo $reviewusers['id']; ?>" title="Meh - 3.5 stars"></span>
                        
                        <input class="stars" type="radio" id="starr33<?php echo $reviewusers['id']; ?>" name="r3<?php echo $reviewusers['id']; ?>" value="3" <?php if($reviewusers['r3']==3){ echo "checked"; }?>  disabled  />
                        <span class = "review full" for="starr33<?php echo $reviewusers['id']; ?>" title="Meh - 3 stars"></span>
                        
                        <input class="stars" type="radio" id="starr32half<?php echo $reviewusers['id']; ?>" name="r3<?php echo $reviewusers['id']; ?>" value="2.5" <?php if($reviewusers['r3']==2.5){ echo "checked"; }?>  disabled  />
                        <span class="review half" for="starr32half<?php echo $reviewusers['id']; ?>" title="Kinda bad - 2.5 stars"></span>
                        
                        <input class="stars" type="radio" id="starr32<?php echo $reviewusers['id']; ?>" name="r3<?php echo $reviewusers['id']; ?>" value="2" <?php if($reviewusers['r3']==2){ echo "checked"; }?>  disabled  />
                        <span class = "review full" for="starr32<?php echo $reviewusers['id']; ?>" title="Kinda bad - 2 stars"></span>
                        
                        <input class="stars" type="radio" id="starr31half<?php echo $reviewusers['id']; ?>" name="r3<?php echo $reviewusers['id']; ?>" value="1.5" <?php if($reviewusers['r3']==1.5){ echo "checked"; }?>  disabled  />
                        <span class="review half" for="starr31half<?php echo $reviewusers['id']; ?>" title="Meh - 1.5 stars"></span>
                        
                        <input class="stars" type="radio" id="starr31<?php echo $reviewusers['id']; ?>" name="r3<?php echo $reviewusers['id']; ?>" value="1" <?php if($reviewusers['r3']==1){ echo "checked"; }?>  disabled  />
                        <span class = "review full" for="starr31<?php echo $reviewusers['id']; ?>" title="Sucks big time - 1 star"></span>
                        
                        <input class="stars" type="radio" id="starr3half<?php echo $reviewusers['id']; ?>" name="r3<?php echo $reviewusers['id']; ?>" value="0.5" <?php if($reviewusers['r3']==0.5){ echo "checked"; }?>  disabled  />
                        <span class="review half" for="starr3half<?php echo $reviewusers['id']; ?>" title="Sucks big time - 0.5 stars"></span>
                    </fieldset></td>
               </div> </tr>
	   
	   
	
              
              
              <tr>
                 <td> <b><?php echo R4; ?> </b></td>
                      <td><fieldset id='demo3' class="ratingusers">
                    
                      <input class="stars" type="radio" id="starr45<?php echo $reviewusers['id']; ?>" name="r4<?php echo $reviewusers['id']; ?>" value="5" <?php if($reviewusers['r4']==5){ echo "checked"; }?>  disabled />
                        <span class = "review full" for="starr45<?php echo $reviewusers['id']; ?>" title="Awesome - 5 stars"></span>
                        
                        <input class="stars" type="radio" id="starr44half<?php echo $reviewusers['id']; ?> name="r4<?php echo $reviewusers['id']; ?>" value="4.5" <?php if($reviewusers['r4']==4.5){ echo "checked"; }?>  disabled />
                        <span class="review half" for="starr44half<?php echo $reviewusers['id']; ?>" title="Pretty good - 4.5 stars"></span>
                        
                        <input class="stars" type="radio" id="starr44<?php echo $reviewusers['id']; ?>" name="r4<?php echo $reviewusers['id']; ?>" value="4" <?php if($reviewusers['r4']==4){ echo "checked"; }?>  disabled />
                        <span class = "review full" for="starr44<?php echo $reviewusers['id']; ?>" title="Pretty good - 4 stars"></span>
                        
                        <input class="stars" type="radio" id="starr43half<?php echo $reviewusers['id']; ?>" name="r4<?php echo $reviewusers['id']; ?>" value="3.5" <?php if($reviewusers['r4']==3.5){ echo "checked"; }?>  disabled />
                        <span class="review half" for="starr43half<?php echo $reviewusers['id']; ?>" title="Meh - 3.5 stars"></span>
                        
                        <input class="stars" type="radio" id="starr43<?php echo $reviewusers['id']; ?>" name="r4<?php echo $reviewusers['id']; ?>" value="3" <?php if($reviewusers['r4']==3){ echo "checked"; }?>  disabled />
                        <span class = "review full" for="starr43<?php echo $reviewusers['id']; ?>" title="Meh - 3 stars"></span>
                        
                        <input class="stars" type="radio" id="starr42half<?php echo $reviewusers['id']; ?>" name="r4<?php echo $reviewusers['id']; ?>" value="2.5" <?php if($reviewusers['r4']==2.5){ echo "checked"; }?>  disabled />
                        <span class="review half" for="starr42half<?php echo $reviewusers['id']; ?>" title="Kinda bad - 2.5 stars"></span>
                        
                        <input class="stars" type="radio" id="starr42<?php echo $reviewusers['id']; ?>" name="r4<?php echo $reviewusers['id']; ?>" value="2" <?php if($reviewusers['r4']==2){ echo "checked"; }?>  disabled />
                        <span class = "review full" for="starr42<?php echo $reviewusers['id']; ?>" title="Kinda bad - 2 stars"></span>
                        
                        <input class="stars" type="radio" id="starr41half<?php echo $reviewusers['id']; ?>" name="r4<?php echo $reviewusers['id']; ?>" value="1.5" <?php if($reviewusers['r4']==1.5){ echo "checked"; }?>  disabled />
                        <span class="review half" for="starr41half<?php echo $reviewusers['id']; ?>" title="Meh - 1.5 stars"></span>
                        
                        <input class="stars" type="radio" id="starr41<?php echo $reviewusers['id']; ?>" name="r4<?php echo $reviewusers['id']; ?>" value="1" <?php if($reviewusers['r4']==1){ echo "checked"; }?>  disabled />
                        <span class = "review full" for="starr41<?php echo $reviewusers['id']; ?>" title="Sucks big time - 1 star"></span>
                        
                        <input class="stars" type="radio" id="starr4half<?php echo $reviewusers['id']; ?>" name="r4<?php echo $reviewusers['id']; ?>" value="0.5" <?php if($reviewusers['r4']==0.5){ echo "checked"; }?>  disabled />
                        <span class="review half" for="starr4half<?php echo $reviewusers['id']; ?>" title="Sucks big time - 0.5 stars"></span>
                    </fieldset></td>
             </div> 
	   </tr>
	   <tr>
                 <td><b><?php echo R5; ?> </b></td>
                      <td><fieldset id='demo3' class="ratingusers">
                    
                   <input class="stars" type="radio" id="starr55<?php echo $reviewusers['id']; ?>" name="r5<?php echo $reviewusers['id']; ?>" value="5" <?php if($reviewusers['r5']==5){ echo "checked"; }?>  disabled />
                        <span class = "review full" for="starr55<?php echo $reviewusers['id']; ?>" title="Awesome - 5 stars"></span>
                        
                        <input class="stars" type="radio" id="starr54half<?php echo $reviewusers['id']; ?>" name="r5<?php echo $reviewusers['id']; ?>" value="4.5" <?php if($reviewusers['r5']==4.5){ echo "checked"; }?>  disabled />
                        <span class="review half" for="starr54half<?php echo $reviewusers['id']; ?>" title="Pretty good - 4.5 stars"></span>
                        
                        <input class="stars" type="radio" id="starr54<?php echo $reviewusers['id']; ?>" name="r5<?php echo $reviewusers['id']; ?>" value="4" <?php if($reviewusers['r5']==4){ echo "checked"; }?>  disabled />
                        <span class = "review full" for="starr54<?php echo $reviewusers['id']; ?>" title="Pretty good - 4 stars"></span>
                        
                        <input class="stars" type="radio" id="starr53half<?php echo $reviewusers['id']; ?>" name="r5<?php echo $reviewusers['id']; ?>" value="3.5" <?php if($reviewusers['r5']==3.5){ echo "checked"; }?>  disabled />
                        <span class="review half" for="starr53half<?php echo $reviewusers['id']; ?>" title="Meh - 3.5 stars"></span>
                        
                        <input class="stars" type="radio" id="starr53<?php echo $reviewusers['id']; ?>" name="r5<?php echo $reviewusers['id']; ?>" value="3" <?php if($reviewusers['r5']==3){ echo "checked"; }?>  disabled />
                        <span class = "review full" for="starr53<?php echo $reviewusers['id']; ?>" title="Meh - 3 stars"></span>
                        
                        <input class="stars" type="radio" id="starr52half<?php echo $reviewusers['id']; ?>" name="r5<?php echo $reviewusers['id']; ?>" value="2.5" <?php if($reviewusers['r5']==2.5){ echo "checked"; }?>  disabled />
                        <span class="review half" for="starr52half<?php echo $reviewusers['id']; ?>" title="Kinda bad - 2.5 stars"></span>
                        
                        <input class="stars" type="radio" id="starr52<?php echo $reviewusers['id']; ?>" name="r5<?php echo $reviewusers['id']; ?>" value="2" <?php if($reviewusers['r5']==2){ echo "checked"; }?>  disabled />
                        <span class = "review full" for="starr52<?php echo $reviewusers['id']; ?>" title="Kinda bad - 2 stars"></span>
                        
                        <input class="stars" type="radio" id="starr51half<?php echo $reviewusers['id']; ?>" name="r5<?php echo $reviewusers['id']; ?>" value="1.5" <?php if($reviewusers['r5']==1.5){ echo "checked"; }?>  disabled />
                        <span class="review half" for="starr51half<?php echo $reviewusers['id']; ?>" title="Meh - 1.5 stars"></span>
                        
                        <input class="stars" type="radio" id="starr51<?php echo $reviewusers['id']; ?>" name="r5<?php echo $reviewusers['id']; ?>" value="1" <?php if($reviewusers['r5']==1){ echo "checked"; }?>  disabled />
                        <span class = "review full" for="starr51<?php echo $reviewusers['id']; ?>" title="Sucks big time - 1 star"></span>
                        
                        <input class="stars" type="radio" id="starr5half<?php echo $reviewusers['id']; ?>" name="r5<?php echo $reviewusers['id']; ?>" value="0.5" <?php if($reviewusers['r5']==0.5){ echo "checked"; }?>  disabled />
                        <span class="review half" for="starr5half<?php echo $reviewusers['id']; ?>" title="Sucks big time - 0.5 stars"></span>
                    </fieldset></td>
          </div> 
                  
	   
	   </tr>
	   
	     </tbody>
  </table>

					  <?php echo $this->Form->input('description',array('class'=>'form-control','placeholder'=>'Short Description','required'=>true,'label' =>false,'type'=>'textarea','value'=>$reviewusers['description'],'readonly'=>true)); ?>	
      
              

<?php }} ?>

  <!-------------------------------------------------->

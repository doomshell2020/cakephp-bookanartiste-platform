       <form action="<?php echo SITE_URL ?>/jobpost/SendQoute" method="POST" onsubmit="return submitfalse(this);">
         <div class="form-group">
           <label for="comment">Skill</label>
           <select class="form-control" name="skill" onchange="return myfunction(this)" data-req="<?php echo $requirement_data['id'] ?>" required="true" id="skillid">
             <option value="0">Select Skill</option>
             <?php foreach ($requirement_data['requirment_vacancy'] as $value) { ?>
               <option value="<?php echo $value['skill']['id'] ?>"><?php echo $value['skill']['name'] ?></option>
             <?php  } ?>
           </select>
         </div>
         <div> Currency </div>
         <div style="margin-bottom: 20px">
           <input type="text" class="form-control" id="currency<?php echo $requirement_data['id'] ?>" name="currency<?php echo $a ?>" readonly>
         </div>
         <div> Offer Amount </div>
         <div style="margin-bottom: 20px">
           <input type="text" class="form-control" id="offeramt<?php echo $requirement_data['id'] ?>" name="offerecamt<?php echo $a ?>" readonly>
         </div>
         <div class="form-group">
           <label for="email">Your Quote</label>
           <div class="input-group">
             <span class="input-group-addon" id="prefixcode"><?php echo $requirement_data['requirment_vacancy'][0]['currency']['symbol']  ?></span>
             <input type="number" class="form-control" id="sendquouteamt" patten="^[0-9]*$" name="amt" required readonly="readonly">
           </div>
         </div>
         <input type="hidden" name="job_id" value="<?php echo $requirement_data['id'] ?>" />
         <?php if ($quoteid) { ?>
           <input type="hidden" name="job_idprimary" value="<?php echo $quoteid ?>" />
         <?php } ?>
         <button type="submit" class="btn btn-default">Send Quote</button>
       </form>
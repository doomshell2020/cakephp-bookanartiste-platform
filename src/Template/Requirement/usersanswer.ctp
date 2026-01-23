
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" style="text-align:center;">Questionnaire Answers</h4>
      </div>
      <div class="modal-body">
        <?php $i=1; foreach ($jobquestion as $key => $valuejobanswr) { ?>
        <h4><small><strong>Question:</strong> <?php echo "(".$i.") ".$valuejobanswr['question_title']." ?"; ?></small></h4>
        <h4><small><strong>Answer:</strong> <?php 
        foreach ($valuejobanswr['jobanswer'] as $key => $jobanswerval) {
          if ($requirement['user_id']==$valuejobanswr['userjobanswer'][0]['user_id']) 
          {
            if ($jobanswerval['id']==$valuejobanswr['userjobanswer'][0]['option_id']) {
              echo $jobanswerval['answervalue'].".";  
            }
          }
        }
        ?></small></h4>
        <?php $i++; } ?>
        </div>

      </div>


<div class="card">
    <div class="card-body">
        <!-- <h4 class="card-title">Payment Information</h4> -->
        <div class="row mb-3">
            <div class="col-md-6">
                <?php echo $this->Form->input('user_name', array(
                    'class' => 'form-control',
                    'placeholder' => 'Your Name',
                    'required' => true,
                    'readonly' => true,
                    'type' => 'text',
                    'value' => $this->request->session()->read('Auth.User.user_name')
                )); ?>
            </div>
            <div class="col-md-6">
                <?php echo $this->Form->email('email', array(
                    'class' => 'form-control',
                    'placeholder' => 'Your Email',
                    'required' => true,
                    'readonly' => true,
                    'value' => $this->request->session()->read('Auth.User.email')
                )); ?>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <?php echo $this->Form->input('card_name', array(
                    'class' => 'form-control',
                    'placeholder' => 'Name on Card',
                    'required' => true,
                    'type' => 'text'
                )); ?>
            </div>
            <div class="col-md-6">
                <?php echo $this->Form->input('card_number', array(
                    'class' => 'form-control',
                    'placeholder' => 'Card Number',
                    'required' => true,
                    'maxlength' => '16',
                    'minlength' => '16',  // Use minlength for client-side validation
                    'type' => 'text'
                )); ?>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <?php echo $this->Form->input('csv_number', array(
                    'class' => 'form-control',
                    'placeholder' => 'CVV',  // Corrected spelling
                    'required' => true,
                    'maxlength' => '3',
                    'minlength' => '3', // Use minlength
                    'type' => 'text'
                )); ?>
            </div>
            <div class="col-md-3">
                <?php echo $this->Form->input('expiry_month', array( // More descriptive name
                    'class' => 'form-control',
                    'empty' => 'Expiry Month',
                    'options' => range(1, 12), // Simplified month generation
                    'required' => true
                )); ?>
            </div>
            <div class="col-md-3">
                <?php echo $this->Form->input('expiry_year', array( // More descriptive name
                    'class' => 'form-control',
                    'empty' => 'Expiry Year',
                    'options' => range(date('Y'), date('Y') + 10), // Simplified year generation
                    'required' => true
                )); ?>
            </div>
        </div>

        <div class="mb-3">
            <label for="skill">Skill</label>
            <select class="form-control" name="skill" required>
                <option value="">Select Skill</option>
                <?php foreach ($details['requirment_vacancy'] as $value): ?>
                    <option value="<?php echo $value['skill']['id']; ?>">
                        <?php echo $value['skill']['name']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="cover">Cover Letter</label> <textarea class="form-control" rows="5" id="cover" name="cover"></textarea>
        </div>

        <input type="hidden" name="job_id" value="<?= $details['id']; ?>" />

        <!-- <div class="d-grid gap-2"> <button type="submit" class="btn btn-primary"><?php echo __('Submit'); ?></button> </div> -->

        <div class="form-group" style="margin-top: 18px;">
            <div class="col-sm-12 text-center">
                <button type="submit" class="btn btn-default"><?php echo __('Submit'); ?></button>
            </div>
        </div>

    </div>
</div>
<!----------------------editprofile-strt----------------------->
<section id="edit_profile">
  <div class="container">
    <h2>Change <span>Password</span></h2>

    <div class="row">
      <div class="tab-content">
        <div class="profile-bg m-top-20">

          <?php echo $this->Flash->render(); ?>

          <div id="Personal" class="tab-pane fade in active">
            <div class="container m-top-30">

              <?php
              echo $this->Form->create($pagepersonal, array(
                'url' => array('controller' => 'users', 'action' => 'changepassword'),
                'class' => 'form-horizontal',
                'id' => 'user_form',
                'autocomplete' => 'off'
              ));
              ?>
              <input type="hidden" name="email" value="<?php echo $_SESSION['Auth']['User']['email']; ?>">
              <!-- Current Password -->
              <div class="form-group">
                <label class="col-sm-2 control-label">Current Password:</label>
                <div class="col-sm-9 position-relative">
                  <?php
                  echo $this->Form->input('password', array(
                    'type' => 'password',
                    'class' => 'form-control',
                    'placeholder' => 'Current Password',
                    'id' => 'current_password',
                    'required' => true,
                    'label' => false
                  ));
                  ?>
                  <span class="toggle-password" onclick="togglePassword('current_password', this)">
                    <i class="fa fa-eye"></i>
                  </span>
                </div>
              </div>

              <!-- New Password -->
              <div class="form-group">
                <label class="col-sm-2 control-label">New Password:</label>
                <div class="col-sm-9 position-relative">
                  <?php
                  echo $this->Form->input('newpassword', array(
                    'type' => 'password',
                    'class' => 'form-control',
                    'placeholder' => 'New Password',
                    'id' => 'new_password',
                    'required' => true,
                    'label' => false,
                    'oninput' => 'validatePassword()'
                  ));
                  ?>
                  <span class="toggle-password" onclick="togglePassword('new_password', this)">
                    <i class="fa fa-eye"></i>
                  </span>
                  <small class="text-muted">
                    Min 8 chars, uppercase, lowercase, number & special character
                  </small>
                </div>
              </div>

              <!-- Confirm Password -->
              <div class="form-group">
                <label class="col-sm-2 control-label">Confirm Password:</label>
                <div class="col-sm-9 position-relative">
                  <input type="password"
                    name="confirmpassword"
                    id="confirm_password"
                    class="form-control"
                    placeholder="Confirm Password"
                    required
                    oninput="validatePassword()">
                  <span class="toggle-password" onclick="togglePassword('confirm_password', this)">
                    <i class="fa fa-eye"></i>
                  </span>
                </div>
              </div>

              <!-- Submit -->
              <div class="form-group">
                <div class="col-sm-12 text-center">
                  <button type="submit" class="btn btn-default">Submit</button>
                </div>
              </div>

              <?php echo $this->Form->end(); ?>

            </div>
          </div>

        </div>
      </div>
    </div>
  </div>
</section>

<!-- STYLE FOR EYE ICON -->
<style>
  .position-relative {
    position: relative;
  }

  .toggle-password {
    position: absolute;
    top: 50%;
    right: 15px;
    transform: translateY(-50%);
    cursor: pointer;
    color: #777;
  }

  .toggle-password:hover {
    color: #000;
  }
</style>

<!-- PASSWORD VALIDATION + TOGGLE SCRIPT -->
<script>
  function togglePassword(fieldId, el) {
    const input = document.getElementById(fieldId);
    const icon = el.querySelector('i');

    if (input.type === 'password') {
      input.type = 'text';
      icon.classList.remove('fa-eye');
      icon.classList.add('fa-eye-slash');
    } else {
      input.type = 'password';
      icon.classList.remove('fa-eye-slash');
      icon.classList.add('fa-eye');
    }
  }

  function validatePassword() {
    const password = document.getElementById('new_password');
    const confirmPassword = document.getElementById('confirm_password');

    const pattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;

    if (!pattern.test(password.value)) {
      password.setCustomValidity(
        'Password must be at least 8 characters and include uppercase, lowercase, number and special character.'
      );
    } else {
      password.setCustomValidity('');
    }

    if (confirmPassword.value !== '' && password.value !== confirmPassword.value) {
      confirmPassword.setCustomValidity('Passwords do not match');
    } else {
      confirmPassword.setCustomValidity('');
    }
  }
</script>
<!----------------------editprofile-end----------------------->
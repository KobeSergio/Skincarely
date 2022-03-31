<?php
  require_once "db_connection.php";

  $username = $password = $confirm_password = $first_name = $last_name = $email = "";
  $username_err = $password_err = $confirm_password_err = $first_name_err = $last_name_err = $email_err = "";

  if($_SERVER['REQUEST_METHOD'] == 'POST') {

    //validate username
    if(empty(trim($_POST['username']))) {
      $username_err = "Please enter a valid username.";
    } elseif(!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST['username']))) {
      $username_err = "Username should contain numbers and letters.";
    } else {
      // prepare select statement
      $sql = "SELECT customer_id FROM customers WHERE customer_username = ?";

      if($stmt = mysqli_prepare($link, $sql)) {
        mysqli_stmt_bind_param($stmt, "s", $param_username);
        $param_username = trim($_POST['username']);
        if(mysqli_stmt_execute($stmt)) {
          mysqli_stmt_store_result($stmt);
          if(mysqli_stmt_num_rows($stmt) == 1) {
            $username_err = "Username already taken.";
          } else {
            $username = trim($_POST['username']);
          }
        } else {
          echo "Error.";
        }
        mysqli_stmt_close($stmt);
      }
    }

    //validate email
    if(empty(trim($_POST['email']))) {
      $email_err = "Please enter your email.";
    } else {
      $sql = "SELECT customer_id FROM customers where customer_email = ?";
      
      if($stmt = mysqli_prepare($link, $sql)) {
        mysqli_stmt_bind_param($stmt, "s", $param_email);
        $param_email = trim($_POST['email']);
        if(mysqli_stmt_execute($stmt)) {
          mysqli_stmt_store_result($stmt);
          if(mysqli_stmt_num_rows($stmt) == 1) {
            $email_err = "Email already taken.";
          } else {
            $email = trim($_POST['email']);
          }
        } else {
          echo "Error.";
        }
        mysqli_stmt_close($stmt);
      }
    }

    //validate password and password confirmation
    if(empty(trim($_POST['password']))) {
      $password_err = "Please enter your password.";
    } elseif(strlen(trim($_POST['password']) < 7)) {
      $password_err = "Password must be atleast 7 characters.";
    } else {
      $password = trim($_POST['password']);
    }

    if(empty(trim($_POST['confirm_password']))) {
      $confirm_password_err = "Please confirm your password.";
    } else {
      $confirm_password = trim($_POST['confirm_password']);
      if(empty($password_err) && ($password != $confirm_password)) {
        $confirm_password_err = "Password confirmation did not match.";
      }
    }

  } //end if
?>
<section class="vh-100" style="background-color: #f7f3f2;">
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col col-xl-10">
        <div class="card" style="border-radius: 1rem;">
          <div class="row g-0">
            <div class="col-md-6 col-lg-5 d-none d-md-block">
              <img
                src="img/img1.webp"
                alt="login form"
                class="img-fluid" style="border-radius: 1rem 0 0 1rem;"
              />
            </div>
            <div class="col-md-6 col-lg-7 d-flex align-items-center">
              <div class="card-body p-4 p-lg-5 text-black">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
                  <div class="d-flex align-items-center mb-4 pb-3">
                  <i class="fas fa-crow fa-2x me-3" style="color: #AC7672;"></i>
                    <span class="h1 fw-bold mb-0">Skincarely</span>
                  </div>

                  <h5 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">Create an account</h5>

                  <div class="row">
                      <div class="col-md-6 mb-4">
                          <div class="form-outline">
                            <label for="fn" class="form-label">First Name</label>
                            <input type="text" name="fn" class="form-control"/>
                            <span class="invalid-feedback">
                                Please enter your first name.
                            </span>
                          </div>
                      </div>
                      <div class="col-md-6 mb-4">
                          <div class="form-outline">
                            <label for="ln" class="form-label">Last Name</label>
                            <input type="text" name="ln" class="form-control"/>
                            <span class="invalid-feedback">
                                Please enter your last name.
                            </span>
                          </div>
                      </div>
                  </div>

                  <div class="row">
                      <div class="col-md-6 mb-4">
                          <div class="form-outline">
                              <label for="username" class="form-label">Username</label>
                              <input type="text" name="username" class="form-control <?php echo(!empty($username_err)) ? 'is-invalid' : ''; ?>"/>
                              <span class="invalid-feedback">
                                  <?php echo $username_err; ?>
                              </span>
                          </div>
                      </div>
                      <div class="col-md-6 mb-4">
                          <div class="form-outline">
                              <label for="email" class="form-label <?php echo(!empty($email_err)) ? 'is-invalid' : '';?>">Email</label>
                              <input type="email" name="email" class="form-control"/>
                              <span class="invalid-feedback">
                                  <?php echo $email_err; ?>
                              </span>
                          </div>
                      </div>
                  </div>

                  <div class="row">
                      <div class="form-outline mb-4">
                          <label for="password" class="form-label">Password</label>
                          <input type="password" name="password" class="form-control <?php echo(!empty($password_err)) ? 'is-invalid' : ''; ?>"/>
                          <span class="invalid-feedback">
                              <?php echo $password_err; ?>
                          </span>
                      </div>
                  </div>

                  <div class="pt-1 mb-4">
                    <button class="btn btn-block" type="submit" style="background-color: #AC7672; color: #fff;">Register</button>
                  </div>

                  <p class="mb-5 pb-lg-2" style="color: #393f81;">Already have an account? <a href="login_page.php" style="color: #393f81;">Login here</a></p>
                </form>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<?php
    include 'includes/login/head.php';
?>

<?php
    include 'includes/login/footer.php';
?>
<!DOCTYPE html>

<html>
    <head>
        <title>Login</title>
        <link rel="stylesheet" type="text/css" href="btn.css">
        <!-- Bootstrap CSS -->
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>
        <div class="container">
            <!-- Button to Open the Login Modal -->
<button type="button" class="btn btn-animated" data-toggle="modal" data-target="#loginModal">
  <span>Login</span>
</button>

<!-- Button to Open the Signup Modal -->
<button type="button" class="btn btn-animated" data-toggle="modal" data-target="#signupModal">
  <span>Signup</span>
</button>
<!-- Login Modal -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="loginModalLabel">Login</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="login.php" method="post">
          <div class="form-group">
            <label for="loginEmail">Email address</label>
            <input type="email" class="form-control" id="loginEmail" name="email" placeholder="Enter email" required>
          </div>
          <div class="form-group">
            <label for="loginPassword">Password</label>
            <input type="password" class="form-control" id="loginPassword" name="password" placeholder="Password" required>
          </div>
          <button type="submit" class="btn btn-primary">Login</button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Signup Modal -->
<div class="modal fade" id="signupModal" tabindex="-1" aria-labelledby="signupModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="signupModalLabel">Signup</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="signup.php" method="post">
          <div class="form-group">
            <label for="signupFirstName">First Name</label>
            <input type="text" class="form-control" id="signupFirstName" name="first_name" placeholder="Enter first name" required>
          </div>
          <div class="form-group">
            <label for="signupLastName">Last Name</label>
            <input type="text" class="form-control" id="signupLastName" name="last_name" placeholder="Enter last name" required>
          </div>
          <div class="form-group">
            <label for="signupEmail">Email address</label>
            <input type="email" class="form-control" id="signupEmail" name="email" placeholder="Enter email" required>
          </div>
          <div class="form-group">
            <label for="signupPassword">Password</label>
            <input type="password" class="form-control" id="signupPassword" name="password" placeholder="Password" required>
          </div>
          <div class="form-group">
            <label for="signupIdNumber">ID Number</label>
            <input type="text" class="form-control" id="signupIdNumber" name="id_number" placeholder="Enter ID number" required>
            <div class="form-group">
            <label for="signupMeterNumber">Meter Number</label>
            <input type="text" class="form-control" id="signupMeterNumber" name="meter_number" placeholder="Enter Meter number" required>
          </div>
          </div>
          <button type="submit" class="btn btn-primary">Signup</button>
        </form>
      </div>
    </div>
  </div>
</div>

</div>
    </body>
   <!-- Bootstrap JS and jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    </html>

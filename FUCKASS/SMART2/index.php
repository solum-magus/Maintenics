<?php
session_start();

$mysqli = require __DIR__ . "/database.php";

if (isset($_GET['verify_email'])) {
    $school_id = $_GET['verify_email'];
    $otp = $_GET['otp'] ?? '';
    
    $sql = "SELECT * FROM userinfo WHERE school_id = ? AND otp = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("ss", $school_id, $otp);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        // Update user status to Approved and clear OTP
        $update_sql = "UPDATE userinfo SET userstatus = 'Approved', otp = NULL, is_verified = 1 WHERE school_id = ?";
        $update_stmt = $mysqli->prepare($update_sql);
        $update_stmt->bind_param("s", $school_id);
        $update_stmt->execute();
        
        $_SESSION['verification_success'] = "Email verified successfully! You can now log in.";
    } else {
        $_SESSION['verification_error'] = "Invalid verification link or OTP has expired.";
    }
    
    header("Location: index.php");
    exit();
}

// Display verification messages if they exist
$verification_success = isset($_SESSION['verification_success']) ? $_SESSION['verification_success'] : "";
$verification_error = isset($_SESSION['verification_error']) ? $_SESSION['verification_error'] : "";
unset($_SESSION['verification_success']);
unset($_SESSION['verification_error']);

$error_message2 = isset($_SESSION["error_message2"]) ? $_SESSION["error_message2"] : "";
$entered_name = isset($_SESSION["entered_name"]) ? htmlspecialchars($_SESSION["entered_name"]) : "";
$entered_school_id = isset($_SESSION["entered_school_id"]) ? htmlspecialchars($_SESSION["entered_school_id"]) : "";

if (isset($_SESSION["position"])) {
    switch ($_SESSION["position"]) {
        case "Student":
            header("Location: Page/Home.php");
            exit();
        case "Teacher":
            header("Location: Page/Home.php");
            exit();
        case "Admin":
            header("Location: Page/AdminHome.php");
            exit();
        case "Maintenance Staff":
            header("Location: Page/MaintenanceHome.php");
            exit();
        default:
            header("Location: index.php");
            exit();
    }
}

unset($_SESSION["error_message2"]);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $full_name = trim($_POST["full_name"]);
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];
    $school_id = $_POST["school_id"];
    $position = trim($_POST["position"]);

    $_SESSION["entered_name"] = $full_name;
    $_SESSION["entered_school_id"] = $school_id;
    $_SESSION["entered_pos"] = $position;

    if (strlen($full_name) < 3 || strlen($full_name) > 70) {
        echo "<script>
              document.addEventListener('DOMContentLoaded', function() {
                  customAlert('Full name must be at least 3 characters or more.');
              });
              setTimeout(function() {
                  window.location.href = 'index.php';
              }, 2000);
              </script>";
    } elseif (!strpos($full_name, ' ')) { 
        echo "<script>
              document.addEventListener('DOMContentLoaded', function() {
                  customAlert('Please insert your full name.');
              });
              setTimeout(function() {
                  window.location.href = 'index.php';
              }, 2000);
              </script>";
    }

    elseif (strlen($password) < 8) {
        echo "<script>
              document.addEventListener('DOMContentLoaded', function() {
                  customAlert('Password must be at least 8 characters long.');
              });
              setTimeout(function() {
                  window.location.href = 'index.php';
              }, 2000);
              </script>";
    }

    elseif ($password !== $confirm_password) {
        echo "<script>
              document.addEventListener('DOMContentLoaded', function() {
                  customAlert('Passwords do not match.');
              });
              setTimeout(function() {
                  window.location.href = 'index.php';
              }, 2000);
              </script>";
    }

    /*elseif (!ctype_digit($school_id) || strlen($school_id) < 11 || strlen($school_id) > 12) {
        echo "<script>
              document.addEventListener('DOMContentLoaded', function() {
                  customAlert('School ID must be 11-12 digits and contain only numbers.');
              });
              setTimeout(function() {
                  window.location.href = 'index.php';
              }, 2000);
              </script>";
    }*/

    else {
        $sql_check_id = "SELECT * FROM userinfo WHERE school_id = ?";
        $stmt_check_id = $mysqli->prepare($sql_check_id);
        $stmt_check_id->bind_param("s", $school_id);
        $stmt_check_id->execute();
        $result_check_id = $stmt_check_id->get_result();
        
        if ($result_check_id->num_rows > 0) {
            echo "<script>
              document.addEventListener('DOMContentLoaded', function() {
                  customAlert('This School Email is already registered.');
              });
              setTimeout(function() {
                  window.location.href = 'index.php';
              }, 2000);
              </script>";
        } else {
            $sql_check_name = "SELECT * FROM userinfo WHERE full_name = ?";
            $stmt_check_name = $mysqli->prepare($sql_check_name);
            $stmt_check_name->bind_param("s", $full_name);
            $stmt_check_name->execute();
            $result_check_name = $stmt_check_name->get_result();
            
            if ($result_check_name->num_rows > 0) {
                echo "<script>
                      document.addEventListener('DOMContentLoaded', function() {
                          customAlert('This full name is already taken.');
                      });
                      setTimeout(function() {
                          window.location.href = 'index.php';
                      }, 2000);
                      </script>";
            } else {
                $hashword = password_hash($password, PASSWORD_DEFAULT);
                $userstatus = ($position === 'Maintenance Staff' || $position === 'Admin') ? "Pending" : "Approved";
    
                $sql = "INSERT INTO userinfo (position, full_name, school_id, hashword, userstatus) VALUES (?, ?, ?, ?, ?)";
                $insert = $mysqli->prepare($sql);
                $insert->bind_param("sssss", $position, $full_name, $school_id, $hashword, $userstatus);
    
                try {
                  // Generate random 6-digit OTP
                  $otp = str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);
                  
                  $sql = "INSERT INTO userinfo (position, full_name, school_id, hashword, userstatus, otp, is_verified) 
                          VALUES (?, ?, ?, ?, ?, ?, 0)";
                  $insert = $mysqli->prepare($sql);
                  $insert->bind_param("ssssss", $position, $full_name, $school_id, $hashword, $userstatus, $otp);
                  
                  if ($insert->execute()) {
                      // Send verification email
                      $to = $school_id;
                      $subject = "Email Verification for SMART";
                      $message = "Hello " . htmlspecialchars($full_name) . ",\n\n";
                      $message .= "Thank you for registering with SMART. Please verify your email by clicking the link below:\n\n";
                      $message .= "http://yourdomain.com/index.php?verify_email=" . urlencode($school_id) . "&otp=" . $otp . "\n\n";
                      $message .= "If you didn't request this, please ignore this email.\n\n";
                      $message .= "Best regards,\nSMART Team";
                      $headers = "From: no-reply@yourdomain.com";
                      
                      if (mail($to, $subject, $message, $headers)) {
                          $_SESSION['signup_success'] = "Registration successful! Please check your email for verification instructions.";
                          header("Location: index.php?signup_success=1");
                      } else {
                          throw new Exception("Failed to send verification email.");
                      }
                      exit();
                  } else {
                      throw new Exception("An error occurred while creating the account.");
                  }
              } catch (Exception $e) {
                  // Error handling
              }
            }
        }
    }
}

if (isset($_GET['signup_success'])) {
    unset($_SESSION['entered_name']);
    unset($_SESSION['entered_school_id']);
    unset($_SESSION['entered_pos']);
}
$entered_pos = $_SESSION['entered_pos'] ?? '';
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="apple-touch-icon" sizes="180x180" href="Assets/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="Assets/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="Assets/favicon-16x16.png">
    <link rel="manifest" href="../Assets/site.webmanifest">
   <title>SMART</title>
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style/newindex.css" />
  </head>
  <body>
  <section class="container-fluid min-vh-100 d-flex align-items-center pb-5">
    <div class="row w-100">
        <!-- Left Side Placeholder -->
        <div class="col-md-6 mb-3 d-flex justify-content-center align-items-center">
		<div class="image">
			<img src="Assets/logo.svg" style="width: 250px;"/>
        </div>
        <div class="text-left fw-bold px-4">
            <h1 class="fw-bold text-info" id="smart">SMART</h1>
            <h2 class="fw-bold smartt">Report Instantly,</h2>
            <h2 class="fw-bold smartt">Resolve Efficiently!</h2>
        </div>
        </div>

        <!-- Right Side Forms -->
        <div class="col-12 col-md-6 d-flex justify-content-center align-items-center">
        <div class="wrapper px-4 <?php echo (!empty($error_message2) || isset($_GET['signup_success'])) ? 'active' : ''; ?>" style="max-width: 400px; width: 100%;">
            <!-- Signup Form -->
            <div class="form signup">
            <header class="text-center">Sign Up</header>
            <form action="" method="post" id="signUpForm">
            <div class="form-group">
                <select id="position" name="position" required>
                  <option value="">Position</option>
                  <option value="Student" <?php echo ($entered_pos == "Student") ? "selected" : ""; ?>>Student</option>
                  <option value="Teacher" <?php echo ($entered_pos == "Teacher") ? "selected" : ""; ?>>Teacher</option>
                  <option value="Admin" <?php echo ($entered_pos == "Admin") ? "selected" : ""; ?>>Admin</option>
                  <option value="Maintenance Staff" <?php echo ($entered_pos == "Maintenance Staff") ? "selected" : ""; ?>>Maintenance Staff</option>
                </select>
            </div>

            <div class="form-group">
                <input type="text" id="full_name" name="full_name" required maxlength="70" minlength="3"
                  oninput="this.value = this.value.replace(/[^A-Za-z\s]/g, '').replace(/\s{2,}/g, ' ');"
                  onblur="this.value = this.value.trim(), this.placeholder = 'Enter your full name'"
                  placeholder="Full Name"
                  onfocus="this.placeholder=''"
                  value="<?php echo isset($_SESSION['entered_name']) ? htmlspecialchars($_SESSION['entered_name']) : ''; ?>">
            </div>
    
            <div class="form-group">
                <input type="text" id="school_id" name="school_id" required
                  placeholder="School Email"
                  onfocus="this.placeholder = ''"
                  onblur="this.placeholder='Enter your School Email'"
                  pattern="^[a-zA-Z0-9._%+-]+@gmail\.com$"
                  value="<?php echo htmlspecialchars($_SESSION['entered_school_id'] ?? ''); ?>">
            </div>
    
            <div class="form-group" id="passworddiv">
                <input type="password" id="password" name="password" required
                       placeholder="Password"
                       onfocus="this.placeholder = ''"
                       onblur="this.placeholder = 'Enter your password'">
                <img src="Assets/eye-alt.svg" onclick="showpass()" class="pass-icon" id="pass-icon">
            </div>
    
            <div class="form-group" id="passworddiv2">
                <input type="password" id="confirm_password" name="confirm_password" required
                       placeholder="Confirm Password"
                       onblur="this.placeholder = 'Re-enter your password'"
                       onfocus="this.placeholder = ''">
                <img src="Assets/eye-alt.svg" onclick="showpass2()" class="pass-icon2" id="pass-icon2">
            </div>
            <button type="submit" class="btn btn-warning">Create Account</button>
        </form>
            </div>

            <!-- Login Form -->
            <div class="form login mt-4">
            <header class="text-center">Log In</header>
            <form action="Authentication/signin.php" method="post" id="signInForm">
                <div class="mb-3">
                <label for="signin_full_name" class="form-label">Full Name</label>
                <input type="text" id="signin_full_name" name="signin_full_name" maxlength="70" required
                    class="form-control"
                    onblur="this.value = this.value.trim()" placeholder="Enter your full name"
                    value="<?= $entered_school_id ?>">
                </div>

                <div class="mb-3 position-relative">
                <label for="signin_password" class="form-label">Password</label>
                <input type="password" id="signin_password" name="signin_password" required
                    class="form-control" placeholder="Enter your password">
                <img src="Assets/eye-alt.svg" onclick="showpass3()" class="pass-icon3 position-absolute" style="right:10px;top:35px;cursor:pointer;" id="pass-icon3">
                </div>

                <button name="signin" type="submit" class="btn btn-success w-100">Log In</button>

                <?php if (!empty($error_message2)) : ?>
                <div class="text-danger mt-2"><?= htmlspecialchars($error_message2) ?></div>
                <script>
                    document.addEventListener("DOMContentLoaded", function () {
                    navigateTo('signInPage');
                    });
                </script>
                <?php endif; ?>
            </form>
            </div>
        </div>
        </div>
    </div>
   </section>

   <section class="container py-5">
    <div class="row">
        <div class="col-md-8 mb-4">
        <div class="p-4 h-100 text-justify">
          <h2 class="mb-4 text-left spectext fw-bold fs-2">Privacy and Policy</h2>
            <p style="text-align: justify;">At SMART, we are committed to protecting your privacy. This Privacy Policy outlines how we collect, use, and protect your personal information when you interact with our website or services. We collect personal details such as your name, email, and contact information when you sign up or contact us, as well as usage data like your IP address and browsing activity. This information helps us improve our services and provide a better user experience.
              <br><br>
              We do not sell or share your personal information with third parties, except for trusted service providers who assist us in operating our services. While we take steps to protect your data, please note that no transmission over the internet is completely secure. You have the right to access, update, or delete your information, and you can opt out of marketing communications at any time. We also use cookies to enhance your experience, and you can adjust your cookie preferences through your browser settings.
              <br><br>
              By using our website, you agree to this Privacy Policy. If we make any updates, we will post them here with an updated effective date.
            </p>
        </div>
        </div>
        <div class="col-md-4 mb-4">
        <img src="Assets/protect.svg" class="img-fluid mx-auto d-flex imga" />
        </div>
    </div>
    </section>

    <section class="container py-5">
    <div class="row align-items-center justify-content-center">
        <div class="col-md-4 mb-4">
        <div class="p-4 h-100 text-justify">
          <h2 class="mb-4 text-left spectext fw-bold fs-2">What SMART Does</h2>
            <p style="text-align: justify;">Smart takes the stress out of reporting and fixing everyday issues. Whether it's a maintenance task, a workplace snag, or something that just needs attention, Smart makes it simple to report problems instantly and keep things moving. We connect the right people at the right time, so issues get resolved quickly—without the back-and-forth. It’s smoother communication, smarter workflows, and happier teams.</p>
        </div>
        </div>
        <div class="col-md-4 mb-4">
        <img src="Assets/what.svg" class="img-fluid mx-auto d-block imga" style="width: 250px;"/>
        </div>
    </div>
    </section>

    <section class="container py-5">
  <div class="row" style="text-align: justify;">
    <div class="col-md-5 mb-4">
      <div class="p-4 h-100">
        <h4 class="spectext fw-bold fs-2 text-center">Our Mission</h4>
        <p>Our mission is to provide schools with an innovative, user-friendly platform that simplifies maintenance management through real-time tracking and data-driven insights. We are committed to delivering reliable, efficient, and sustainable solutions that empower schools to optimize their operations, reduce costs, and create safer, more productive learning environments. What sets us apart is our dedication to use technology to solve real-world challenges, ensuring every school can focus on what matters most—educating future generations.</p>
      </div>
    </div>
    <div class="col-md-2 mb-4">
      <div class="p-4 h-100 d-flex align-items-center justify-content-center">
      <img src="Assets/cogs.svg" class="img-fluid mx-auto d-block imga" />
      </div>
    </div>
    <div class="col-md-5 mb-4">
      <div class="p-4 h-100">
        <h4 class="spectext fw-bold fs-2 text-center">Our Vision</h4>
        <p>In the coming years, we see ourselves as the global leader in school maintenance solutions, using cutting-edge real-time tracking technology to transform how schools manage their facilities. We are building SMART because we believe every school deserves a safe, well-maintained, and efficient environment for learning, ensuring a brighter future for students and educators everywhere.</p>
      </div>
    </div>
  </div>
</section>

<section class="container py-5 features">
  <h2 class="mb-4 text-center spectext fw-bold fs-2">SMART Features</h2>
  <div class="row d-flex justify-content-around flex-wrap text-center">
  <div class="col-md-2 mb-4">
      <div class="p-4 h-100">
      <img src="Assets/indexhistory.svg" class="img-fluid mx-auto d-block imga"class="img-fluid mx-auto d-block"class="img-fluid mx-auto d-block" />
        <h4>Report History</h4>
      </div>
</div>
    <div class="col-md-2 mb-4">
      <div class="p-4 h-100">
      <img src="Assets/indexnotif.svg" class="img-fluid mx-auto d-block imga" />
        <h4>Instant Notifications</h4>
      </div>
    </div>
    <div class="col-md-2 mb-4">
      <div class="p-4 h-100">
      <img src="Assets/indexstatus.svg" class="img-fluid mx-auto d-block imga" />
        <h4>Visual Status</h4>
      </div>
    </div>

    <div class="col-md-2 mb-4"> 
      <div class="p-4 h-100">
      <img src="Assets/indexqr.svg" class="img-fluid mx-auto d-block imga" />
        <h4>QR Code Reporting</h4>
      </div>
    </div>
    <div class="col-md-2 mb-4">
      <div class="p-4 h-100">
      <img src="Assets/indexfeedback.svg" class="img-fluid mx-auto d-block imga" />
        <h4>Report Feedback</h4>
      </div>
    </div>
  </div>
</section>

<section class="container py-5">
  <div class="row">
    <div class="col-md-6 mb-4">
      <div class="p-4 h-100">
        <h4 class="spectext fw-bold fs-2">Get in touch</h4>
        <img src="Assets/contact.svg" class="img-fluid mx-auto d-block imga" style="width: 300px;" />
      </div>
    </div>
   <div class="container-fit mb-4 w-auto mx-auto justify-content-center align-items-center d-flex">
  <div class="p-4 border rounded shadow-sm bg-white d-flex flex-column gap-3 justify-content-center">
    <div class="d-flex align-items-center gap-3">
      <img src="Assets/email.svg" style="width: 30px;" alt="Email" />
      <h5 class="mb-0">maintenics@gmail.com</h5>
    </div>
    <div class="d-flex align-items-center gap-3">
      <img src="Assets/phone.svg" style="width: 30px;" alt="Phone" />
      <h5 class="mb-0">0912-345-6789</h5>
    </div>
    <div class="d-flex align-items-center gap-3">
      <img src="Assets/messenger.svg" style="width: 30px;" alt="Messenger" />
      <h5 class="mb-0">
        <a href="https://www.facebook.com/profile.php?id=61575765484799" target="_blank" rel="noopener noreferrer">
          Maintenics
        </a>
      </h5>
    </div>
  </div>
</div>
  </div>
</section>

<?php if (isset($_GET['signup_success'])): ?>
<script>
    window.addEventListener('DOMContentLoaded', () => {
        document.querySelector('.wrapper').classList.add('active');

        setTimeout(() => {
            const url = new URL(window.location);
            url.searchParams.delete('signup_success');
            window.history.replaceState({}, document.title, url);
        }, 1000);
    });
</script>
<?php endif; ?>

    <script>
        const wrapper = document.querySelector(".wrapper"),
          signupHeader = document.querySelector(".signup header"),
          loginHeader = document.querySelector(".login header");
        loginHeader.addEventListener("click", () => {
          wrapper.classList.add("active");
        });
        signupHeader.addEventListener("click", () => {
          wrapper.classList.remove("active");
        });
    </script>
    <div id="popup" style="display:none; position:fixed; top:20px; left:50%; transform:translateX(-50%); background: rgb(255, 191, 191); padding:10px 20px; border:1px solid rgb(154, 0, 0); border-radius:8px; z-index:10000; color:rgb(169, 0, 0); font-family: Roboto, sans-serif; box-shadow:0 0 10px rgba(0,0,0,0.1);">
        <span id="popup-message"></span>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="JS/script8.js"></script>
    <script src="JS/script7.js"></script>
    <script src="index.js"></script>
  </body>
</html>
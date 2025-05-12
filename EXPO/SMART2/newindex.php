<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

$mysqli = require __DIR__ . "/database.php";

$error_message2 = isset($_SESSION["error_message2"]) ? $_SESSION["error_message2"] : "";
$entered_name = isset($_SESSION["entered_name"]) ? htmlspecialchars($_SESSION["entered_name"]) : "";

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
unset($_SESSION["entered_name"]);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $full_name = trim($_POST["full_name"]);
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];
    $school_id = $_POST["school_id"];
    $position = trim($_POST["position"]);

    if (strlen($full_name) < 3 || strlen($full_name) > 70) {
        $error_message = "Full name must be at least 3 characters or more."; 
    } elseif (!strpos($full_name, ' ')) { 
        $error_message = "Please insert your full name.";
    }

    elseif (strlen($password) < 8) {
        $error_message = "Password must be at least 8 characters long.";
    }

    elseif ($password !== $confirm_password) {
        $error_message = "Passwords do not match.";
    }

    elseif (!ctype_digit($school_id) || strlen($school_id) < 11 || strlen($school_id) > 12) {
        $error_message = "School ID must be 11-12 digits and contain only numbers.";
    }

    else {
        $sql_check_id = "SELECT * FROM userinfo WHERE school_id = ?";
        $stmt_check_id = $mysqli->prepare($sql_check_id);
        $stmt_check_id->bind_param("s", $school_id);
        $stmt_check_id->execute();
        $result_check_id = $stmt_check_id->get_result();
        
        if ($result_check_id->num_rows > 0) {
            $error_message = "This School ID is already registered.";
        } else {
            $sql_check_name = "SELECT * FROM userinfo WHERE full_name = ?";
            $stmt_check_name = $mysqli->prepare($sql_check_name);
            $stmt_check_name->bind_param("s", $full_name);
            $stmt_check_name->execute();
            $result_check_name = $stmt_check_name->get_result();
            
            if ($result_check_name->num_rows > 0) {
                $error_message = "This full name is already taken.";
            } else {
                $hashword = password_hash($password, PASSWORD_DEFAULT);
                $userstatus = ($position === 'Maintenance Staff' || $position === 'Admin') ? "Pending" : "Approved";
    
                $sql = "INSERT INTO userinfo (position, full_name, school_id, hashword, userstatus) VALUES (?, ?, ?, ?, ?)";
                $insert = $mysqli->prepare($sql);
                $insert->bind_param("ssiss", $position, $full_name, $school_id, $hashword, $userstatus);
    
                try {
                    $insert->execute();
                    header("Location: index.php#signInPage"); 
                    exit;
                } catch (Exception $e) {
                    $error_message = "An error occurred while creating the account.";
                }
            }
        }
    }
}
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
  <section class="container-fluid min-vh-100 d-flex align-items-center">
    <div class="row w-100">
        <!-- Left Side Placeholder -->
        <div class="col-md-6 d-flex justify-content-center align-items-center">
		<div class="image">
			<img src="Assets/logo.svg" style="width: 300px;"/>
        </div>
        <div class="text-left fw-bold px-4">
            <h1 class="fw-bolder text-info">SMART</h1>
            <h2 class="fw-bold">Report Instantly,</h2>
            <h2 class="fw-bold">Resolve Efficiently!</h2>
        </div>
        </div>

        <!-- Right Side Forms -->
        <div class="col-md-6 d-flex justify-content-center align-items-center">
        <div class="wrapper w-100 px-4">
            <!-- Signup Form -->
            <div class="form signup">
            <header class="text-center">Sign Up</header>
            <form action="" method="post" id="signUpForm">
            <div class="form-group">
                <select id="position" name="position" required>
                    <option value="">Position</option>
                    <option value="Student" <?php echo (isset($_POST['position']) && $_POST['position'] == "Student") ? "selected" : ""; ?>>Student</option>
                    <option value="Teacher" <?php echo (isset($_POST['position']) && $_POST['position'] == "Teacher") ? "selected" : ""; ?>>Teacher</option>
                    <option value="Admin" <?php echo (isset($_POST['position']) && $_POST['position'] == "Admin") ? "selected" : ""; ?>>Admin</option>
                    <option value="Maintenance Staff" <?php echo (isset($_POST['position']) && $_POST['position'] == "Maintenance Staff") ? "selected" : ""; ?>>Maintenance Staff</option>
                </select>
            </div>

            <div class="form-group">
                <input type="text" id="full_name" name="full_name" required maxlength="70" minlength="3"
                       oninput="this.value = this.value.replace(/[^A-Za-z\s]/g, '').replace(/\s{2,}/g, ' ');"
                       onblur="this.value = this.value.trim(), this.placeholder = 'Enter your full name'"
                       placeholder="Full Name"
                       onfocus="this.placeholder=''"
                       value="<?php echo htmlspecialchars($_POST['full_name'] ?? ''); ?>">
            </div>
    
            <div class="form-group">
                <input type="text" id="school_id" name="school_id" required
                       placeholder="Phone Number or LRN"
                       onfocus="this.placeholder = ''"
                       onblur="this.placeholder='Enter your LRN or Phone Number'"
                       oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 12);"
                       pattern="[0-9]{11,12}" minlength="11" maxlength="12"
                       value="<?php echo htmlspecialchars($_POST['school_id'] ?? ''); ?>">
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

            <?php if (!empty($error_message)): ?>
                <p style="color: red;"><?php echo $error_message; ?></p>
                <script>
                    document.addEventListener("DOMContentLoaded", function() {
                        onclick="navigateTo('signInPage')";
                    });
                </script>
            <?php endif; ?>

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
                    oninput="this.value = this.value.replace(/[^A-Za-z\s]/g, '').replace(/\s{2,}/g, ' ')"
                    onblur="this.value = this.value.trim()" placeholder="Enter your full name"
                    value="<?= $entered_name ?>">
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
    <h2 class="mb-4 text-center">Privacy and Policy</h2>
    <div class="row">
        <div class="col-md-8 mb-4">
        <div class="p-4 h-100 text-justify">
            <p style="text-align: justify;">At SMART, we are committed to protecting your privacy. This Privacy Policy outlines how we collect, use, and protect your personal information when you interact with our website or services. We collect personal details such as your name, email, and contact information when you sign up or contact us, as well as usage data like your IP address and browsing activity. This information helps us improve our services and provide a better user experience.
<br><br>
We do not sell or share your personal information with third parties, except for trusted service providers who assist us in operating our services. While we take steps to protect your data, please note that no transmission over the internet is completely secure. You have the right to access, update, or delete your information, and you can opt out of marketing communications at any time. We also use cookies to enhance your experience, and you can adjust your cookie preferences through your browser settings.
<br><br>
By using our website, you agree to this Privacy Policy. If we make any updates, we will post them here with an updated effective date. </p>
        </div>
        </div>
        <div class="col-md-4 mb-4">
        <img src="Assets/protect.svg" />
        </div>
    </div>
    </section>

    <section class="container py-5">
    <h2 class="mb-4 text-center">What SMART Does</h2>
    <div class="row">
        <div class="col-md-8 mb-4">
        <div class="p-4 h-100 text-justify">
            <p style="text-align: justify;">Smart takes the stress out of reporting and fixing everyday issues. Whether it's a maintenance task, a workplace snag, or something that just needs attention, Smart makes it simple to report problems instantly and keep things moving. We connect the right people at the right time, so issues get resolved quickly—without the back-and-forth. It’s smoother communication, smarter workflows, and happier teams.</p>
        </div>
        </div>
        <div class="col-md-4 mb-4">
        <img src="Assets/what.svg" />
        </div>
    </div>
    </section>

    <section class="container py-5">
  <div class="row" style="text-align: justify;">
    <div class="col-md-4 mb-4">
      <div class="p-4 border rounded shadow-sm h-100 bg-light">
        <h4>Our Mission</h4>
        <p>Our mission is to provide schools with an innovative, user-friendly platform that simplifies maintenance management through real-time tracking and data-driven insights. We are committed to delivering reliable, efficient, and sustainable solutions that empower schools to optimize their operations, reduce costs, and create safer, more productive learning environments. What sets us apart is our dedication to use technology to solve real-world challenges, ensuring every school can focus on what matters most—educating future generations.</p>
      </div>
    </div>
    <div class="col-md-4 mb-4">
      <div class="p-4 border rounded shadow-sm h-100 bg-white">
      <img src="Assets/cogs.svg" />
      </div>
    </div>
    <div class="col-md-4 mb-4">
      <div class="p-4 border rounded shadow-sm h-100 bg-white">
        <h4>Our Vision</h4>
        <p>In the coming years, we see ourselves as the global leader in school maintenance solutions, using cutting-edge real-time tracking technology to transform how schools manage their facilities. We are building SMART because we believe every school deserves a safe, well-maintained, and efficient environment for learning, ensuring a brighter future for students and educators everywhere.</p>
      </div>
    </div>
  </div>
</section>

<section class="container py-5">
  <h2 class="mb-4 text-center">Explore More Features</h2>
  <div class="row">
  <div class="col-md-2 mb-4">
      <div class="p-4 border rounded shadow-sm h-100 bg-light">
      <img src="Assets/indexhistory.svg" />
        <h4>Report History</h4>
      </div>
</div>
    <div class="col-md-2 mb-4">
      <div class="p-4 border rounded shadow-sm h-100 bg-light">
      <img src="Assets/indexnotif.svg" />
        <h4>Instant Notifications</h4>
      </div>
    </div>
    <div class="col-md-2 mb-4">
      <div class="p-4 border rounded shadow-sm h-100 bg-light">
      <img src="Assets/indexstatus.svg" />
        <h4>Visual Status</h4>
      </div>
    </div>

    <div class="col-md-2 mb-4">
      <div class="p-4 border rounded shadow-sm h-100 bg-light">
      <img src="Assets/indexqr.svg" />
        <h4>QR Code Reporting</h4>
      </div>
    </div>
    <div class="col-md-2 mb-4">
      <div class="p-4 border rounded shadow-sm h-100 bg-light">
      <img src="Assets/indexfeedback.svg" />
        <h4>Report Feedback</h4>
      </div>
    </div>
  </div>
</section>

<section class="container py-5">
  <h2 class="mb-4 text-center">Explore More Features</h2>
  <div class="row">
    <div class="col-md-6 mb-4">
      <div class="p-4 border rounded shadow-sm h-100 bg-light">
        <h4>Contact Us</h4>
        <img src="Assets/contact.svg" />
      </div>
    </div>
    <div class="col-md-6 mb-4">
      <div class="p-4 border rounded shadow-sm h-100 bg-white">
        <h2>maintenics@gmail.com</h2>
        <h2>0912-345-6789</h2>
        <h2>Maintenics</h2>
      </div>
    </div>
  </div>
</section>

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
    <div id="popup" style="display:none; position:fixed; top:20px; left:50%; transform:translateX(-50%); background: rgb(191, 255, 222); padding:10px 20px; border:1px solid rgb(18, 154, 0); border-radius:8px; z-index:10000; color:rgb(0, 169, 82); font-family: Roboto, sans-serif; box-shadow:0 0 10px rgba(0,0,0,0.1);">
        <span id="popup-message"></span>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="JS/script8.js"></script>
    <script src="JS/script7.js"></script>
    <script src="script.js"></script>
  </body>
</html>
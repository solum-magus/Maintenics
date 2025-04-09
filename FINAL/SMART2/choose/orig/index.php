<?php
session_start();
// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection
$mysqli = require __DIR__ . "/database.php";

// Initialize error message
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

// Clear session error messages after displaying
unset($_SESSION["error_message2"]);
unset($_SESSION["entered_name"]);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $full_name = trim($_POST["full_name"]);
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];
    $school_id = $_POST["school_id"];
    $position = trim($_POST["position"]);

    // Validate Full Name
    if (strlen($full_name) < 3 || strlen($full_name) > 70) {
        $error_message = "Full name must be at least 3 characters or more."; 
    } elseif (!strpos($full_name, ' ')) { 
        $error_message = "Please insert your full name.";
    }

    // Validate Password Length
    elseif (strlen($password) < 8) {
        $error_message = "Password must be at least 8 characters long.";
    }

    // Validate Password Match
    elseif ($password !== $confirm_password) {
        $error_message = "Passwords do not match.";
    }

    // Validate School ID (Only Numbers Allowed)
    elseif (!ctype_digit($school_id) || strlen($school_id) < 11 || strlen($school_id) > 12) {
        $error_message = "School ID must be 11-12 digits and contain only numbers.";
    }

    // Check if School ID and name is already taken
    else {
        $sql_check = "SELECT * FROM userinfo WHERE school_id = ? OR full_name = ?";
        $stmt_check = $mysqli->prepare($sql_check);
        $stmt_check->bind_param("ss", $school_id, $full_name);
        $stmt_check->execute();
        $result_check = $stmt_check->get_result();

        if ($result_check->num_rows > 0) {
            $existing_user = $result_check->fetch_assoc();
            
            if ($existing_user["school_id"] === $school_id) {
                $error_message = "This School ID is already taken.";
            } elseif ($existing_user["full_name"] === $full_name) {
                $error_message = "This Name is already taken.";
            }
        }
    }

    // If no errors, proceed with user registration
    if (empty($error_message)) {
        $hashword = password_hash($password, PASSWORD_DEFAULT);
        $userstatus = ($position === 'Maintenance Staff' || $position === 'Admin') ? "Pending" : "Approved";

        $sql = "INSERT INTO userinfo (position, full_name, school_id, hashword, userstatus) VALUES (?, ?, ?, ?, ?)";
        $insert = $mysqli->prepare($sql);
        $insert->bind_param("ssiss", $position, $full_name, $school_id, $hashword, $userstatus);

        try {
            $insert->execute();
            echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                customAlert('Account made successfully!');
            });
            </script>";
            
        } catch (Exception) {
            $error_message = "An error occurred while creating the account.";
        }
    }
}
?>


<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SMART</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:ital,wght@0,300;0,400;0,700;0,900;1,300;1,400;1,700;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="Style/index.css">
    <script src="index.js"></script>
</head>
<body>
    <div class="row">
        <div class="col-6 d-flex justify-content-center align-items-center" style="height: 100vh; width: 100vh;">
            <div class="page" id="welcomePage" style="display: block;">
                <div class="content">
                    <div class="header-flex">
                        <img src="Assets/logo.svg" alt="SMART Logo" class="Logo">
                        <h1>SMART</h1>
                    </div>
                    <h2>Welcome!</h2>
                    <div class="mt-2">
                        <button onclick="navigateTo('signInPage')" class="btn btn-primary mb-1">Sign In</button>
                        <button onclick="navigateTo('signUpPage')" class="btn btn-primary">Sign Up</button>
                    </div>
                </div>
            </div>

            <div class="page" id="signUpPage" style="display: none;">
    <div class="header-flex">
        <img src="Assets/Logo.svg" alt="SMART Logo" class="Logo">
        <h1>SMART</h1>
    </div>
    <div class="content">
        <h2>Create your account</h2>
        <form action="" method="post" id="signUpForm">
            <div class="form-group">
                <label for="position">Position</label>
                <select id="position" name="position" required>
                    <option value="">Select Position</option>
                    <option value="Student" <?php echo (isset($_POST['position']) && $_POST['position'] == "Student") ? "selected" : ""; ?>>Student</option>
                    <option value="Teacher" <?php echo (isset($_POST['position']) && $_POST['position'] == "Teacher") ? "selected" : ""; ?>>Teacher</option>
                    <option value="Admin" <?php echo (isset($_POST['position']) && $_POST['position'] == "Admin") ? "selected" : ""; ?>>Admin</option>
                    <option value="Maintenance Staff" <?php echo (isset($_POST['position']) && $_POST['position'] == "Maintenance Staff") ? "selected" : ""; ?>>Maintenance Staff</option>
                </select>
            </div>

            <div class="form-group">
                <label for="full-name">Full Name</label>
                <input type="text" id="full_name" name="full_name" required maxlength="70" minlength="3"
                       oninput="this.value = this.value.replace(/[^A-Za-z\s]/g, '').replace(/\s{2,}/g, ' ');"
                       onblur="this.value = this.value.trim(), this.placeholder = 'Enter your full name'"
                       placeholder="Enter your full Name"
                       onfocus="this.placeholder=''"
                       value="<?php echo htmlspecialchars($_POST['full_name'] ?? ''); ?>">
            </div>
    
            <div class="form-group">
                <label for="school-id">Phone Number or LRN</label>
                <input type="text" id="school_id" name="school_id" required
                       placeholder="Enter your LRN or Phone Number"
                       onfocus="this.placeholder = ''"
                       onblur="this.placeholder='Enter your LRN or Phone Number'"
                       oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 12);"
                       pattern="[0-9]{11,12}" minlength="11" maxlength="12"
                       value="<?php echo htmlspecialchars($_POST['school_id'] ?? ''); ?>">
            </div>
    
            <div class="form-group" id="passworddiv">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required
                       placeholder="Enter your password"
                       onfocus="this.placeholder = ''"
                       onblur="this.placeholder = 'Enter your password'">
                <img src="Assets/eye-alt.svg" onclick="showpass()" class="pass-icon" id="pass-icon">
            </div>
    
            <div class="form-group" id="passworddiv2">
                <label for="confirm-password">Confirm Password</label>
                <input type="password" id="confirm_password" name="confirm_password" required
                       placeholder="Re-enter your password"
                       onblur="this.placeholder = 'Re-enter your password'"
                       onfocus="this.placeholder = ''">
                <img src="Assets/eye-alt.svg" onclick="showpass2()" class="pass-icon2" id="pass-icon2">
            </div>

            <!-- Display Error Message -->
            <?php if (!empty($error_message)): ?>
                <p style="color: red;"><?php echo $error_message; ?></p>
                <script>
                    document.addEventListener("DOMContentLoaded", function() {
                        navigateTo('signUpPage');
                    });
                </script>
            <?php endif; ?>

            <button class="btn btn-primary">Create Account</button>
        </form>                
        <p>Already have an account? <a href="#" onclick="navigateTo('signInPage')">Sign in</a>.</p>
        <p>By signing up, you agree to our <a href="#" onclick="navigateTo('termsPage')">Terms and Policy</a>.</p>
    </div>
</div>        
            <div class="page" id="signInPage" style="display: none;">
                <div class="content">
                    <div class="header-flex">
                        <img src="Assets/logo.svg" alt="SMART Logo" class="Logo">
                        <h1>SMART</h1>
                    </div>
        
                    <h2>Welcome!</h2>
        
                    <form action="Authentication/signin.php" method="post" id="signInForm"> <!--onsubmit="return validateSignInForm()"-->
                         <div class="form-group">
                            <label for="school_id">Full Name</label>
                            <input type="text" id="signin_full_name" name="signin_full_name" maxlength="70" required
                            oninput="this.value = this.value.replace(/[^A-Za-z\s]/g, '').replace(/\s{2,}/g, ' ')"
                            onblur="this.value = this.value.trim(), this.placeholder = 'Enter your full name'"
                            placeholder="Enter your full Name"
                            onfocus="this.placeholder=''"
                            value="<?= $entered_name ?>">
                            </div>

                        <div class="form-group" id="passworddiv3">
                            <label for="signin_password">Password</label>
                            <input type="password" id="signin_password" name="signin_password" required
                            onblur="this.placeholder = 'Re-enter your password'"
                            onfocus="this.placeholder = ''"
                            placeholder="Enter your password">
                            <img src="Assets/eye-alt.svg" onclick="showpass3()" class="pass-icon3" id="pass-icon3">
                        </div>
                        <button name="signin"type="submit" class="btn btn-primary">Sign In</button>
                        
                        <?php if (!empty($error_message2)) : ?>
                        <div class="error" style="color: red;">
                            <?= htmlspecialchars($error_message2) ?>
                        </div>
                        <script>
                    document.addEventListener("DOMContentLoaded", function() {
                        navigateTo('signInPage');
                    });
                </script>
                    <?php endif; ?>

                    </form>
                    <p>Don't have an account yet? 
                    
                    <a href="#" onclick="navigateTo('signUpPage')">Create an account</a>.</p>
                </div>
            </div>

            <div class="page" id="termsPage" style="display: none;">
                <div class="header-flex">
                    <h1>Welcome to SMART!</h1>
                </div>
                <div class="content" id="contentt">
                    <p>Before continuing, please take a moment to review and agree to our Terms & Conditions and Privacy Policy.</p>
                    <p>Our Terms & Conditions state that by using this app, you agree to act responsibly and follow all applicable laws. You are responsible for maintaining the confidentiality of your account credentials, and any activity under your account is your responsibility. We aim to keep the app running smoothly but cannot guarantee uninterrupted service. Updates may be rolled out to improve functionality, and it's your responsibility to keep the app updated. We reserve the right to terminate your access for violating these terms.</p>
                    <p>Our Privacy Policy outlines how we collect and use your personal data. We may collect information such as your name, email, and usage data to enhance your experience. We do not share your data with third parties without your consent, and we take necessary precautions to safeguard your information. However, no system is completely secure, and we cannot guarantee absolute protection. You have the right to request access to your data at any time.</p>
                    <p>By proceeding, you acknowledge that you have read and accept our Terms & Conditions and Privacy Policy.</p>
                    <button onclick="navigateTo('signUpPage')" class="btn btn-primary">Proceed</button>
                </div>
            </div>

        </div>

        <div class="col-6 d-flex justify-content-center align-items-center" style="height: 85%; ">
            <img src="Assets/stuff.svg" class="img-fluid" id="stuff" style="max-width: 80%; height: 100%; right: 10%;  top: 2%; z-index: -1;">
        </div>
    </div>

    <div id="popup" style="display:none; position:fixed; top:20px; left:50%; transform:translateX(-50%); background: rgb(191, 255, 222); padding:10px 20px; border:1px solid rgb(18, 154, 0); border-radius:8px; z-index:10000; color:rgb(0, 169, 82); font-family: Roboto, sans-serif; box-shadow:0 0 10px rgba(0,0,0,0.1);">
        <span id="popup-message"></span>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="JS/script8.js"></script>
</body>
</html>

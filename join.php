<?php

/**
 * Template Name: ddmd
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Astra
 * @since 1.0.0
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}
get_header();
if (isset($_POST['submit'])) {
    // Sanitize and store the form data
    $full_name = sanitize_text_field($_POST['fullname']);
    $phone = sanitize_text_field($_POST['mobile']);
    $age = intval($_POST['age']);
    $father_name = sanitize_text_field($_POST['fathersname']);
    $district = sanitize_text_field($_POST['district']);
    $vidhan_sabha = sanitize_text_field($_POST['vidhan_sabha']);
    $village_ward = sanitize_text_field($_POST['village_ward']);
    $phone_str = substr(strval($phone), 0, 10); // Convert the number to string and limit it to 10 characters
    $username = strtoupper(substr($district, 0, 1) . substr($vidhan_sabha, 0, 3)) . $phone_str;

    global $wpdb;
    $table_name = $wpdb->prefix . 'form_submissions';


    ///-------------------------Check the code number already Exist
    $number_exist = $wpdb->get_row(
        $wpdb->prepare("SELECT * FROM $table_name WHERE phone = %s", $phone)
    );
    ////-----------------------If number exist then redirect to "already-filled.php" page
    if ($number_exist) {
       echo "<script>window.location.href = 'https://ddmd2024.in/already-filled/';</script>";
        exit;
    } else {
        $data = array(
            'full_name' => $full_name,
            'phone' => $phone,
            'age' => $age,
            'father_name' => $father_name,
            'district' => $district,
            'vidhan_sabha' => $vidhan_sabha,
            'village_ward' => $village_ward,
            'username' => $username,
        );

        $wpdb->insert($table_name, $data);


        echo "<script>window.location.href = 'https://ddmd2024.in/form-submission-successful/';</script>";
        exit;
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>दीपेंद भाई से जुड़ने के लिए यह फॉर्म भरें </title>
    <style>
        .empty-error {
            color: red;

        }

        .error-field {
            border: 1px solid red;
        }

        .form-container {
            background-color: #f1f1f1;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
        }

        /* Styling for the input fields */
        .form-container input[type="text"],
        .form-container input[type="tel"],
        .form-container select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-bottom: 10px;
            background-color: white;
            /* Set the background color of input to white */
        }

        /* Styling for the error messages */
        .empty-error {
            color: red;
            font-size: 14px;
            display: block;
            margin-top: 5px;
        }

        /* Styling for the focused input fields */
        .form-container input[type="text"]:focus,
        .form-container input[type="tel"]:focus,
        .form-container select:focus {
            border: 2px solid blue;
            outline: none;
            /* Remove the default outline */
        }

        /* Styling for the darker border */
        .form-container input[type="text"],
        .form-container input[type="tel"],
        .form-container select {
            border: 1px solid #bbb;
        }

        /* Styling for the darker border on focus */
        .form-container input[type="text"]:focus,
        .form-container input[type="tel"]:focus,
        .form-container select:focus {
            border: 1px solid #0078d4;
        }



        /**/
        --- .form-page-title {
            text-align: center;
            font-size: 2rem;

        }

        .required-mark {
            color: red;
        }
    </style>
</head>

<body>
    <h1 class="form-page-title">Fill out the Form</h1>
    <form method="post">
        <!-- Name (compulsory) -->
        <div class="form-container">
            <label for="fullname">Name:<span class="required-mark">*</span></label>
            <input type="text" name="fullname" id="fullname" maxlength="30" required>
        </div>

        <!-- Father's Name (compulsory) -->
        <div class="form-container">
            <label for="fathersname">Father's Name:<span class="required-mark">*</span></label>
            <input type="text" name="fathersname" id="fathersname" maxlength="30" required>
        </div>

        <!-- Age (compulsory) -->
        <div class="form-container">
            <label for="age">Age:<span class="required-mark">*</span></label>
            <select class="form-control" id="age" name="age" required>
                <option value="">Select Age</option>
                <?php
                for ($i = 1; $i <= 100; $i++) {
                    echo '<option value="' . $i . '">' . $i . '</option>';
                }
                ?>
            </select>
        </div>

        <!-- Mobile (compulsory) -->
        <div class="form-container">
            <label for="mobile">Mobile:<span class="required-mark">*</span></label>
            <div style="display: flex;">
                <input type="text" width="1rem" name="mobile-prefix" value="+91" placeholder="+91" readonly size="2" style="width:20%">
                <input type="tel" name="mobile" maxlength="10" minlength="10" id="mobile" required>
            </div>
            <span class="empty-error" id="invalid-mobile" style="display: none;">Invalid Number</span>
        </div>

        <!-- District (compulsory) -->
        <div class="form-container">
            <label for="district">District:<span class="required-mark">*</span></label>
            <?php echo do_shortcode('[district_options]'); ?>
            <span class="empty-error" id="errorDistrict">Please Select District</span>
        </div>

        <!-- Vidhan Sabha (select field compulsory) -->
        <div class="form-container">
            <label for="vidhan_sabha">Vidhan Sabha:<span class="required-mark">*</span></label>
            <select name="vidhan_sabha" id="vidhan_sabha" required></select>
            <span class="empty-error" id="errorVidhan">Please Select Vidhan Sabha</span>
        </div>

        <!-- Village Ward (select field compulsory) -->
        <div class="form-container">
            <label for="village_ward">Village Ward:<span class="required-mark">*</span></label>
            <select name="village_ward" id="village_ward" required></select>
            <span class="empty-error" id="errorVillageWard">Please Select Village Ward</span>
        </div>

        <!-- Submit Button -->
        <div class="form-container">
            <input type="submit" value="submit" name="submit" id="submitButton" style="background-color:green ; color:white;">
        </div>
    </form>


    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const districtSelect = document.getElementById('district');
            const vidhanSabhaSelect = document.getElementById('vidhan_sabha');
            const villageWardSelect = document.getElementById('village_ward')
            const mobileinput = document.getElementById('mobile')

            mobileinput.addEventListener('keyup', function() {
                mobileInputValue = mobileinput.value;
                if (!/^[0-9]{10}$/.test(mobileInputValue)) {
                    document.getElementById('invalid-mobile').style.display = "block"
                } else {
                    document.getElementById('invalid-mobile').style.display = "none"
                }
            })

            // Event listener to fetch Vidhan Sabha options on district select change
            districtSelect.addEventListener('change', function() {
                const selectedDistrict = districtSelect.value;
                if (selectedDistrict === "") {
                    errorDistrict.style.display = "block"; // Show the error message
                    vidhanSabhaSelect.innerHTML = "";
                    villageWardSelect.innerHTML = "";
                    errorVidhan.style.display = "block";
                    errorVillageWard.style.display = "block";
                } else {
                    errorDistrict.style.display = "none"; // Hide the error message
                    fetchVidhanSabhaOptions(selectedDistrict); ///--------------------------
                }

            });

            // Event listener to fetch Village/Ward options on Vidhan Sabha select change
            vidhanSabhaSelect.addEventListener('change', function() {
                const selectedVidhanSabha = vidhanSabhaSelect.value;

                if (selectedVidhanSabha === "") {
                    errorVidhan.style.display = "block"; // Show the error message
                    villageWardSelect.innerHTML = "";
                    errorVillageWardOptions.style.display = "block";
                } else {
                    errorVidhan.style.display = "none"; // Hide the error message
                    fetchVillageWardOptions(selectedVidhanSabha); ///--------------------------
                }
            });

            //EVENT LISTERNER TO SHOW ERROR-----For Vidhan Sabha
            villageWardSelect.addEventListener('change', function() {
                const selectedVillageWard = villageWardSelect.value;

                if (selectedVillageWard === "") {
                    errorVillageWard.style.display = "block"; // Show the error message
                } else {
                    errorVillageWard.style.display = "none"; // Hide the error message
                }
            });




            // Function to fetch Vidhan Sabha options based on selected district
            function fetchVidhanSabhaOptions(selectedDistrict) {
                // AJAX call to your PHP function that returns the list of Vidhan Sabha options
                // Make sure to replace "your_ajax_handler" with the actual AJAX handler you define in WordPress
                fetch('<?php echo admin_url('admin-ajax.php'); ?>?action=custom_vidhan_sabha_options&district=' + encodeURIComponent(selectedDistrict))
                    .then(response => {

                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {

                        // Update the Vidhan Sabha options dynamically
                        vidhanSabhaSelect.innerHTML = '';
                        //empty option for list
                        const emptyOptionElement = document.createElement('option');
                        emptyOptionElement.value = "";
                        emptyOptionElement.textContent = 'Select';
                        vidhanSabhaSelect.appendChild(emptyOptionElement);


                        for (const option of data) {
                            const optionElement = document.createElement('option');
                            optionElement.value = option.value;
                            optionElement.textContent = option.label;
                            vidhanSabhaSelect.appendChild(optionElement);
                        }


                    })
                    .catch(error => {
                        console.error('Error fetching Vidhan Sabha options:', error);
                    });
            }

            // Function to fetch Village/Ward options based on selected Vidhan Sabha
            function fetchVillageWardOptions(selectedVidhanSabha) {
                // AJAX call to your PHP function that returns the list of Village/Ward options
                // Make sure to replace "your_ajax_handler" with the actual AJAX handler you define in WordPress
                fetch('<?php echo admin_url('admin-ajax.php'); ?>?action=custom_village_ward_options&vidhan_sabha=' + encodeURIComponent(selectedVidhanSabha))
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {

                        // Update the Village/Ward options dynamically
                        const villageWardSelect = document.getElementById('village_ward');
                        villageWardSelect.innerHTML = ''; // Clear existing options
                        const emptyOptionElement = document.createElement('option');
                        emptyOptionElement.value = "";
                        emptyOptionElement.textContent = 'Select';
                        villageWardSelect.appendChild(emptyOptionElement);
                        for (const option of data) {
                            const optionElement = document.createElement('option');
                            optionElement.value = option.value;
                            optionElement.textContent = option.label;
                            villageWardSelect.appendChild(optionElement);
                        }

                    })
                    .catch(error => {
                        console.error('Error fetching Village/Ward options:', error);
                    });
            }
        });
    </script>
</body>

</html>

<?php
get_footer();

?>
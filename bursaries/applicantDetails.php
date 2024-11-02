<?php
echo "
<h2>Applicant Details</h2>
<form action='' method='POST' style='max-width: 800px; margin: auto;'>
    
    <div style='display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px;'>
        <div style='display: flex; flex-direction: column;'>
            <label for='name'>Name:</label>
            <input type='text' id='name' name='name' required>
        </div>
        
        <div style='display: flex; flex-direction: column;'>
            <label for='phone_number'>Phone Number:</label>
            <input type='text' id='phone_number' name='phone_number' required>
        </div>

        <div style='display: flex; flex-direction: column;'>
            <label for='postal_address'>Postal Address:</label>
            <input type='text' id='postal_address' name='postal_address' required>
        </div>
    </div>

    <div style='display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-top: 20px;'>
        <div style='display: flex; flex-direction: column;'>
            <label for='ward'>Ward:</label>
            <input type='text' id='ward' name='ward' required>
        </div>
        
        <div style='display: flex; flex-direction: column;'>
            <label for='sub_county'>Sub-County:</label>
            <input type='text' id='sub_county' name='sub_county' required>
        </div>
        
        <div style='display: flex; flex-direction: column;'>
            <label for='id_number'>ID Number:</label>
            <input type='text' id='id_number' name='id_number' required>
        </div>
    </div>

    <div style='display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-top: 20px;'>
        <div style='display: flex; flex-direction: column;'>
            <label for='date_of_birth'>Date of Birth:</label>
            <input type='date' id='date_of_birth' name='date_of_birth' required>
        </div>
        
        <div style='display: flex; flex-direction: column;'>
            <label for='disability_status'>Disability Status:</label>
            <select id='disability_status' name='disability_status'>
                <option value='Yes'>Yes</option>
                <option value='No'>No</option>
            </select>
        </div>
        
        <div style='display: flex; flex-direction: column;'>
            <label for='family_status'>Family Status:</label>
            <select id='family_status' name='family_status'>
                <option value='Single'>Single</option>
                <option value='Married'>Married</option>
                <option value='Divorced'>Divorced</option>
                <option value='Widowed'>Widowed</option>
            </select>
        </div>
    </div>

    <!-- Submit button across all columns -->
    <div style='text-align: center; margin-top: 20px;'>
        <input type='submit' value='Save Details' style='padding: 10px 20px; font-size: 1em;'>
    </div>
</form>";
?>

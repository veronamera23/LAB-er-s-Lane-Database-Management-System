<link rel="stylesheet" href="LabersLane.css">

<div class="WebHead">   
        <h3>Sign Up</h3>
</div>

<form class="userSULI" action="includes/signup.inc.php" method="post">
    <input type="text" name="name" placeholder="Name" required> 
    <br><br>
    <input type="password" name="pwd" placeholder="Password" required>
    <br><br>

    <input type="radio" id="staff" name="role" value="staff" required>
    <label for="staff">STAFF</label><br>
    <input type="radio" id="student" name="role" value="student" required>
    <label for="student">STUDENT</label><br>
    <br>

    <div id="staff-options" style="display: none;">
        <select name="SelDept" required>
            <option value="CAS Chem">CAS Chem</option>
            <option value="CAS Phy">CAS Phy</option>
            <option value="CAS Bio">CAS Bio</option>
            <option value="SOTECH Food">SOTECH Food</option>
            <option value="SOTECH Che">SOTECH Che</option>
            <option value="CFOS">CFOS</option>
        </select>
        <br><br>
    </div>

    <button type="submit" name="submit">SIGN UP</button>
</form>

<script>
    document.querySelectorAll('input[name="role"]').forEach((elem) => {
        elem.addEventListener("change", function(event) {
            var value = event.target.value;
            var staffOptions = document.getElementById("staff-options");
            if (value === "staff") {
                staffOptions.style.display = "block";
            } else {
                staffOptions.style.display = "none";
            }
        });
    });

    window.onload = function() {
        const urlParams = new URLSearchParams(window.location.search);
        const userId = urlParams.get('userId');
        if (userId) {
            alert('Your account has been created. Your user ID is: ' + userId);
        }
    };
</script>

<?php
/**
 * Created by PhpStorm.
 * User: Bharatwaaj
 * Date: 12-05-2017
 * Time: 13:34
 */
?>

<script src="https://www.gstatic.com/firebasejs/4.0.0/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/4.0.0/firebase-auth.js"></script>
<script src="https://www.gstatic.com/firebasejs/4.0.0/firebase-database.js"></script>
<script src="https://www.gstatic.com/firebasejs/4.0.0/firebase-messaging.js"></script>

<script>
    // Initialize Firebase
    // TODO: Replace with your project's customized code snippet
    var firebase;
    var config = {
        apiKey: "AIzaSyCcYZJI50aWjZN9w4S0y3MnkNCSKCP4Lto",
        databaseURL: "https://roverapp-ebd97.firebaseio.com",
        storageBucket: "roverapp-ebd97.appspot.com",
        authDomain: "roverapp-ebd97.firebaseapp.com",
        messagingSenderId: "393116845605",
        projectId: "roverapp-ebd97"
    };
    firebase.initializeApp(config);
    var database = firebase.database();
</script>


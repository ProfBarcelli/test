<html>
    <head>
        <title>Docente</title>
    </head>
    <body>
<?php
if(!isset($_SESSION["docente"])) {
    if(!isset($_POST["username"]) || !isset($_POST["password"])) { ?>
        <h1>Login Docente</h1>
        <form method="post">
            <input type="text" name="username" placeholder="Username">
            <input type="password" name="password" placeholder="Password">
            <button type="submit">Login</button>
        </form>
<?php
        die();
    } else {
        $username=$_POST["username"];
        $password=$_POST["password"];
        $docenti=json_decode(file_get_contents("docenti.json"),true);
        if(isset($docenti[$username]) && $docenti[$username]["password"]==$password) {
            $_SESSION["docente"]=$username;
            //echo "Login effettuato";
        } else {
            #write the php code to relaod the page
            header('Location: '.$_SERVER['REQUEST_URI']);
        }
    }
} 
$username=$_SESSION["docente"];
$docenti=json_decode(file_get_contents("docenti.json"),true);
if(!isset($docenti[$username])) {
    echo "Errore";
    die();
}
$docente=$docenti[$username];
?>
        <h1>Ciao <?php echo $docente["nome"]." ".$docente["cognome"];?>, ecco le delibere</h1>
        <div id="noDelibereDiv">
            <h2>Non ci sono delibere</h2>
        </div>
        <div id="deliberaDiv" style="display:none;">
            <h2 id="deliberaH2"></h2>
            <button onclick="send('favorvole')">Favorevole</button>
            <button onclick="send('contrario')">Contrario</button>
            <button onclick="send('astenuto')">Astenuto</button>
        </div>
        <script src="https://cdn.socket.io/4.5.1/socket.io.min.js"></script>
        <script>
const noDelibereDiv = document.getElementById("noDelibereDiv");
const deliberaDiv = document.getElementById("deliberaDiv");
const deliberaH2 = document.getElementById("deliberaH2");

const socket = io("http://localhost:8000");

// receive a "foo" event from the server
socket.on("nuovaDelibera", function(delibera) {
    console.log(delibera);
    deliberaH2.innerHTML = delibera["delibera"];
    noDelibereDiv.style.display = "none";
    deliberaDiv.style.display = "block";
});
socket.on("fineVotazione", function() {
    console.log("Fine votazione");
    deliberaH2.innerHTML = "";
    noDelibereDiv.style.display = "block";
    deliberaDiv.style.display = "none";
});


const send = function(what) {
    if(what!="favorvole" && what!="contrario" && what!="astenuto" && deliberaDiv.style.display != "block") {
        return;
    }
    fetch("http://localhost/test/voto.php",{
        method: 'POST',  // You can also use 'POST', 'PUT', etc.
        mode: 'no-cors',  // This is the key part to disable CORS
        headers: {"Content-Type": "application/json"},
        body: JSON.stringify({"what": what, "docente": "<?php echo $_SESSION["docente"]?>"})
    }).then(function(response) {
        return response.text();
    }).then(function(txt) {
        console.log(txt);
    });
};
        </script>
    </body>
</html>
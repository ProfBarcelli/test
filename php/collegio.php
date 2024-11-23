<html>
    <head>
        <title>Collegio</title>
    </head>
    <body>

        <h1>Test delibere</h1>
        Testo delibera:<br>
        <textarea id="deliberaTextArea">ciao</textarea><br>
        <button onclick="sendDelibera()">Invia delibera</button>
        <button onclick="concludeVoting()">Fine votazione</button>
        <hr>
        <script>
const deliberaTextArea = document.getElementById("deliberaTextArea");
const sendDelibera = function() {
    fetch("nuovaDelibera.php",{
        method: "POST",
        headers: {"Content-Type": "application/json"},
        body: JSON.stringify({"delibera": deliberaTextArea.value})
    }).then(response => response.text()).then(txt => {
        console.log(txt);
    });
};
const concludeVoting = function() {
    fetch("fineVotazione.php").then(response => response.text()).then(txt => {
        console.log(txt);
    });
};
</script>

    </body>
</html>
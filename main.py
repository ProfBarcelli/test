from flask import Flask, render_template, request
from flask_socketio import SocketIO

app = Flask(__name__)
socketio = SocketIO(app, cors_allowed_origins="*")

delibera_attuale = None
number_of_clients = 0

@app.route("/")
def home():
    return render_template("index.html")

@app.route("/nuovaDelibera",methods=["POST","GET"])
def new_delilbera():
    global delibera_attuale
    delibera_attuale = request.get_json()
    socketio.emit("nuovaDelibera",delibera_attuale)
    #send("ok")
    return "ok, ci sono "+str(number_of_clients)+" client connessi"

@app.route("/fineVotazione",methods=["POST","GET"])
def conclude_voting():
    global delibera_attuale
    delibera_attuale = None
    socketio.emit("fineVotazione",{})
    #send("ok")
    return "ok"


@socketio.on('connect')
def on_socket_connect(auth):
    print('Client connected')
    global number_of_clients
    number_of_clients += 1
    if delibera_attuale:
        socketio.emit("nuovaDelibera",delibera_attuale,room=request.sid)
@socketio.on('disconnect')
def on_socket_disconnect():
    print('Client disconnected')
    global number_of_clients
    number_of_clients -= 1

if __name__ == "__main__":
    socketio.run(app)
    #app.run(debug=True)
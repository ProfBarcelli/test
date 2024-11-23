from flask import Flask, render_template, request
from flask_socketio import SocketIO

app = Flask(__name__)
socketio = SocketIO(app)

@app.route("/")
def home():
    return render_template("index.html")

@app.route("/nuovaDelibera",methods=["POST"])
def new_delilbera():
    data = request.get_json()
    socketio.emit("new_delibera",data)
    #send("ok")
    return "ok"

@app.route("/fineVotazione")
def conclude_voting():
    socketio.emit("fineVotazione",{})
    #send("ok")
    return "ok"


@socketio.on('connect')
def on_socket_connect(auth):
    print('Client connected')

if __name__ == "__main__":
    socketio.run(app)
    #app.run(debug=True)
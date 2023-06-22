from flask import Flask, render_template, Response as HTTPResponse, request as HTTPRequest
import mysql.connector, json, pika, logging
from datetime import datetime

#ganti entitynya aja sama column pas insert
entity = 'login'

sql_host = f'{entity}_service-{entity}_sql-1'    #nama container sql
# sql_host = 'localhost'
sql_user = 'root'
sql_pass = 'root'
# sql_pass = ''
sql_db = f'soa_{entity}'


db = mysql.connector.connect(host=sql_host, user=sql_user, password=sql_pass, database=sql_db)
dbc = db.cursor(dictionary=True)


app = Flask(__name__)

# Note, HTTP response codes are
#  200 = OK the request has succeeded.
#  201 = the request has succeeded and a new resource has been created as a result.    
#  401 = Unauthorized (user identity is unknown)
#  403 = Forbidden (user identity is known to the server)
#  409 = A conflict with the current state of the resource
#  429 = Too Many Requests

def reconnect():
    global db
    global dbc

    db = mysql.connector.connect(host=sql_host, user=sql_user, password=sql_pass, database=sql_db)
    dbc = db.cursor(dictionary=True)

def getColumnName(cursor):
    column_names = [column[0] for column in cursor.description]
    return column_names

def db2str(data):
    result = []

    for row in data:
        # Convert each column value to a string
        string_row = {key: str(value) for key, value in row.items()}
        result.append(string_row)

    print(result)
    return result

def returnResponse(dictResponse, status_code):
    # ------------------------------------------------------
    # Kirimkan JSON yang sudah dibuat ke client
    # ------------------------------------------------------
    resp = HTTPResponse()
    jsondoc = json.dumps(dictResponse)
    print(dictResponse)
    print(jsondoc)
    resp.response = jsondoc
    resp.headers['Content-Type'] = 'application/json'
    resp.status = status_code
    return resp

@app.route(f'/{entity}/client', methods = ['POST'])
def postClient():
    response = {}

    if HTTPRequest.method == 'POST':
        body = json.loads(HTTPRequest.get_data())

        reconnect()
        
        # ambil data clients
        sql = f"SELECT * FROM clients WHERE username=%s AND password=%s"

        dbc.execute(sql, [body['username'], body['password']])
        clients = dbc.fetchall()

        if len(clients) != 0:
        
            status_code = 200  # The request has succeeded

            response['data'] = db2str(clients)
            response['status_code'] = status_code
            response['message'] = 'login berhasil'

        else: 
            status_code = 403  # No resources found
            response['status_code'] = status_code
            response['message'] = 'username atau password salah'

    return returnResponse(response, status_code)

@app.route(f'/{entity}/staff', methods = ['POST'])
def postStaff():
    response = {}
    if HTTPRequest.method == 'POST':
        body = json.loads(HTTPRequest.get_data())

        reconnect()
        
        # ambil data clients
        sql = f"SELECT * FROM staffs WHERE username=%s AND password=%s"

        dbc.execute(sql, [body['username'], body['password']])
        staffs = dbc.fetchall()

        if len(staffs) != 0:
        
            status_code = 200  # The request has succeeded

            response['data'] = db2str(staffs)
            response['status_code'] = status_code
            response['message'] = 'login berhasil'

        else: 
            status_code = 403  # No resources found
            response['status_code'] = status_code
            response['message'] = 'username atau password salah'

    return returnResponse(response, status_code)
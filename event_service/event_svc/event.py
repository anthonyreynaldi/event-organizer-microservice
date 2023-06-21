from flask import Flask, render_template, Response as HTTPResponse, request as HTTPRequest
import mysql.connector, json, pika, logging
from datetime import datetime
from producer import *

#ganti entitynya aja sama column pas insert
entity = 'event'

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

def isExist(id) :
    sql = f"SELECT * from {entity}s where {entity}_id = {id}"
    dbc.execute(sql)
    events = dbc.fetchall()
    return len(events) != 0

def isExistOrder(id) :
    sql = f"SELECT * from orders where order_id = {id}"
    dbc.execute(sql)
    orders = dbc.fetchall()
    return len(orders) != 0


@app.route(f'/{entity}', methods = ['GET'])
@app.route(f'/{entity}/<path:id>', methods = ['GET'])
def getEvent(id = None):
    response = {}   

    # ------------------------------------------------------
    # HTTP method = GET
    # ------------------------------------------------------
    if HTTPRequest.method == 'GET':

        # ambil data clients
        sql = f"SELECT * FROM {entity}s"

        if(id):
            
            if(not isExistOrder(id)) :
                status_code = 404  # No resources found
                response['status_code'] = status_code
                response['message'] = "Data not found"

                return returnResponse(response, status_code)
            
            sql += f" WHERE order_id = {id}"

        dbc.execute(sql)
        clients = dbc.fetchall()

        if clients != None:
        
            status_code = 200  # The request has succeeded

            response['data'] = db2str(clients)
            response['status_code'] = status_code

        else: 
            status_code = 404  # No resources found
            response['status_code'] = status_code

    return returnResponse(response, status_code)


@app.route(f'/{entity}', methods = ['POST'])
def postEvent():
    response = {}

    if HTTPRequest.method == 'POST':
        
        body = json.loads(HTTPRequest.get_data())

        try:
            # simpan client
            sql = f"INSERT INTO {entity}s ({entity}_id, start, end, description, order_id, staff_id, created_at, updated_at) VALUES (NULL, %s, %s, %s, %s, %s, %s, %s)"
            dbc.execute(sql, [body['start'], body['end'], body['description'], body['order_id'], body['staff_id'], datetime.now(), datetime.now()] )
            db.commit()

            status_code = 201
            response['status_code'] = status_code
            response['message'] = "Data berhasil ditambahkan"

        # bila ada kesalahan saat insert data\
        except mysql.connector.Error as err:
            status_code = 409
            response['status_code'] = status_code
            response['message'] = err.msg

    return returnResponse(response, status_code)

@app.route(f'/{entity}/<path:id>', methods = ['PUT'])
def putEvent(id):
    response = {}
    # ------------------------------------------------------
    # HTTP method = PUT
    # ------------------------------------------------------
    if HTTPRequest.method == 'PUT':

        if(not isExist(id)) :
            status_code = 404  # No resources found
            response['status_code'] = status_code
            response['message'] = "Data not found"

            return returnResponse(response, status_code)

        body = json.loads(HTTPRequest.get_data())

        try:
            # update client
            param = [datetime.now()]
            
            #statement query
            sql = f"UPDATE {entity}s SET updated_at=%s, "

            #concate column name based on key data
            for column, value in body.items():
                sql += column + "=%s, "
                param.append(str(value))

            #delete last , and concate where tablenamewhithouts_id
            sql = sql[:-2] + f" WHERE {entity}_id=%s"
            param.append(id)

            dbc.execute(sql, param)
            db.commit()

            status_code = 201
            response['status_code'] = status_code
            response['message'] = "Data berhasil diupdate"

        # bila ada kesalahan saat insert data\
        except mysql.connector.Error as err:
            status_code = 409
            response['status_code'] = status_code
            response['message'] = err.msg

        return returnResponse(response, status_code)
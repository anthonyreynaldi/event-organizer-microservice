from flask import Flask, render_template, Response as HTTPResponse, request as HTTPRequest
import mysql.connector, json, pika, logging
from datetime import datetime
from producer import *

#ganti entitynya aja sama column pas insert
entity = 'order'

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
    orders = dbc.fetchall()
    return len(orders) != 0

def isExistClient(id) :
    sql = f"SELECT * from clients where client_id = {id}"
    dbc.execute(sql)
    clients = dbc.fetchall()
    return len(clients) != 0



@app.route(f'/{entity}/client/<path:id>', methods = ['GET'])
def clientOrder(id = None):
    response = {}   

    # ------------------------------------------------------
    # HTTP method = GET
    # ------------------------------------------------------
    if HTTPRequest.method == 'GET':

        # ambil data clients
        sql = f"SELECT * FROM {entity}s"

        if(id):
            
            if(not isExistClient(id)) :
                status_code = 404  # No resources found
                response['status_code'] = status_code
                response['message'] = "Data not found"

                return returnResponse(response, status_code)
            
            sql += f" WHERE client_id = {id}"

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

@app.route(f'/{entity}', methods = ['GET'])
@app.route(f'/{entity}/<path:id>', methods = ['GET'])
def getOrder(id = None):
    response = {}   

    # ------------------------------------------------------
    # HTTP method = GET
    # ------------------------------------------------------
    if HTTPRequest.method == 'GET':

        # ambil data clients
        sql = f"SELECT * FROM {entity}s"

        if(id):
            
            if(not isExist(id)) :
                status_code = 404  # No resources found
                response['status_code'] = status_code
                response['message'] = "Data not found"

                return returnResponse(response, status_code)
            
            sql += f" WHERE {entity}_id = {id}"

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
def postOrder():
    response = {}

    if HTTPRequest.method == 'POST':
        
        body = json.loads(HTTPRequest.get_data())

        try:
            # simpan client
            sql = f"INSERT INTO {entity}s ({entity}_id, start_date, end_date, note, package_id, client_id, staff_id, created_at, updated_at) VALUES (NULL, %s, %s, %s, %s, %s, NULL, %s, %s)"
            dbc.execute(sql, [body['start_date'], body['end_date'], body['note'], body['package_id'], body['client_id'], datetime.now(), datetime.now()] )
            db.commit()

            # inserted id
            id = dbc.lastrowid

            # ambil semua data
            sql = f"SELECT * FROM {entity}s WHERE {entity}_id = {id}"

            dbc.execute(sql)
            json_data = db2str(dbc.fetchall())[0]

            # Publish event {entiy}.new
            # Data json yang dikirim adalah semua ada yang baru diinsert
            message = json.dumps(json_data)
            publish_message(message, f'{entity}.new')

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
def putOrder(id):
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
                                        
            # ambil semua data
            sql = f"SELECT * FROM {entity}s WHERE {entity}_id = {id}"

            dbc.execute(sql)
            json_data = db2str(dbc.fetchall())[0]

            # Publish event {entiy}.update
            # Data json yang dikirim adalah semua ada yang baru diinsert
            message = json.dumps(json_data)
            publish_message(message, f'{entity}.update')

            status_code = 201
            response['status_code'] = status_code
            response['message'] = "Data berhasil diupdate"

        # bila ada kesalahan saat insert data\
        except mysql.connector.Error as err:
            status_code = 409
            response['status_code'] = status_code
            response['message'] = err.msg

        return returnResponse(response, status_code)
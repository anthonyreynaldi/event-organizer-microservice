from flask import Flask, render_template, Response as HTTPResponse, request as HTTPRequest
import mysql.connector, json, pika, logging
from datetime import datetime
from producer import *

entity = 'staff'

sql_host = f'{entity}_service-{entity}_sql-1'    #nama container sql
sql_host = 'localhost'
sql_user = 'root'
sql_pass = 'root'
sql_pass = ''
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

def db2str(data, column_names):
    result = []

    for row in data:
        print(row)
        # combine value with its column name
        string_row = dict(zip(column_names, row))
        # Convert each column value to a string
        string_row = {key: str(value) for key, value in string_row.items()}
        result.append(string_row)

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

@app.route('/staff', methods = ['POST'])
def postStaff():
    response = {} 
    if HTTPRequest.method == 'POST':
        
        body = json.loads(HTTPRequest.get_data())

        try:
            # simpan client
            sql = f"INSERT INTO {entity}s ({entity}_id, name, phone_num, username, password, created_at, updated_at) VALUES (NULL, %s, %s, %s, %s, %s, %s)"
            dbc.execute(sql, [body['name'], body['phone_num'], body['username'], body['password'], datetime.now(), datetime.now()] )
            db.commit()

            # inserted id
            id = dbc.lastrowid

            # ambil semua data
            sql = f"SELECT * FROM {entity}s WHERE {entity}_id = {id}"

            dbc.execute(sql)
            json_data = db2str(dbc.fetchall(), getColumnName(dbc))[0]

            # Publish event {entiy}.new
            # Data json yang dikirim adalah semua ada yang baru diinsert
            message = json.dumps(json_data)
            publish_message(message, 'staff.new')

            status_code = 201
            response['status_code'] = status_code
            response['message'] = "Data berhasil ditambahkan"

        # bila ada kesalahan saat insert data\
        except mysql.connector.Error as err:
            status_code = 409
            response['status_code'] = status_code
            response['message'] = err.msg

    return returnResponse(response, status_code)
        

@app.route('/staff', methods = ['GET'])
def getStaff():
    response = {}   

    # ------------------------------------------------------
    # HTTP method = GET
    # ------------------------------------------------------
    if HTTPRequest.method == 'GET':

        # ambil data clients
        sql = "SELECT * FROM staffs"
        dbc.execute(sql)
        clients = dbc.fetchall()
        print(clients)

        if clients != None:
        
            status_code = 200  # The request has succeeded

            response['data'] = db2str(clients, getColumnName(dbc))
            response['status_code'] = status_code


        else: 
            status_code = 404  # No resources found
            response['status_code'] = status_code

    return returnResponse(response, status_code)


@app.route('/staff/<path:id>', methods = ['GET'])
def getParticularStaff(id):
    jsondoc = ''

    if HTTPRequest.method == 'GET':
        response = {}   
        if id.isnumeric():
            sql = "SELECT * FROM staffs where staff_id = %s"
            dbc.execute(sql, [id])
            clients = dbc.fetchone()
            print(clients)

            if clients != None:
            
                status_code = 200  # The request has succeeded

                response['data'] = db2str(clients, getColumnName(dbc))
                response['status_code'] = status_code


            else: 
                status_code = 404  # No resources found
                response['status_code'] = status_code

        return returnResponse(response, status_code)

@app.route('/staff/<path:id>', methods = ['PUT'])
def updateParticularStaff(id) :
    response = {}
    if HTTPRequest.method == 'PUT':
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
            json_data = db2str(dbc.fetchall(), getColumnName(dbc))[0]

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







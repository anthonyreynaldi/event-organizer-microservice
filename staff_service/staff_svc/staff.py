from flask import Flask, render_template, Response as HTTPResponse, request as HTTPRequest
import mysql.connector, json, pika, logging
from datetime import datetime
from producer import *

sql_host = 'client_service-client_sql-1'    #nama container sql
sql_host = 'localhost'
sql_user = 'root'
sql_pass = 'root'
sql_pass = ''
sql_db = 'soa_staff'

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



@app.route('/client', methods = ['POST', 'GET'])
def client():
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


    # ------------------------------------------------------
    # HTTP method = POST
    # ------------------------------------------------------
    elif HTTPRequest.method == 'POST':
        data = json.loads(HTTPRequest.data)
        kantinName = data['nama']
        gedung = data['gedung']

        try:
            # simpan nama kantin, dan gedung ke database
            sql = "INSERT INTO kantin_resto (nama,gedung) VALUES (%s,%s)"
            dbc.execute(sql, [kantinName,gedung] )
            db.commit()
            # dapatkan ID dari data kantin yang baru dimasukkan
            kantinID = dbc.lastrowid
            data_kantin = {'id':kantinID}
            jsondoc = json.dumps(data_kantin)

            # simpan menu-menu untuk kantin di atas ke database
            for i in range(len(data['produk'])):
                menu = data['produk'][i]['menu']
                price = data['produk'][i]['price']

                sql = "INSERT INTO kantin_menu (idresto,menu,price) VALUES (%s,%s,%s)"
                dbc.execute(sql, [kantinID,menu,price] )
                db.commit()


            # Publish event "new kantin" yang berisi data kantin yg baru.
            # Data json yang dikirim sebagai message ke RabbitMQ adalah json asli yang
            # diterima oleh route /kantin [POST] di atas dengan tambahan 2 key baru,
            # yaitu 'event' dan kantinID.
            data['event']  = 'new_kantin'
            data['kantin_id'] = kantinID
            message = json.dumps(data)
            publish_message(message, 'client.new')


            status_code = 201

        # bila ada kesalahan saat insert data\
        except mysql.connector.Error as err:
            status_code = 409


    # ------------------------------------------------------
    # Kirimkan JSON yang sudah dibuat ke client
    # ------------------------------------------------------
    resp = HTTPResponse()
    jsondoc = json.dumps(response)
    resp.response = jsondoc
    resp.headers['Content-Type'] = 'application/json'
    resp.status = status_code
    return resp





@app.route('/kantin/<path:id>', methods = ['GET', 'PUT'])
def kantin2(id):
    jsondoc = ''


    # ------------------------------------------------------
    # HTTP method = GET
    # ------------------------------------------------------
    if HTTPRequest.method == 'GET':
        response = {}   
        if id.isnumeric():
            sql = "SELECT * FROM clients"
            dbc.execute(sql)
            clients = dbc.fetchone()
            print(clients)

            if clients != None:
            
                status_code = 200  # The request has succeeded

                response['data'] = db2str(clients, getColumnName(dbc))
                response['status_code'] = status_code


            else: 
                status_code = 404  # No resources found
                response['status_code'] = status_code

            # ambil data kantin
        #     sql = "SELECT * FROM kantin_resto WHERE id = %s"
        #     dbc.execute(sql, [id])
        #     data_kantin = dbc.fetchone()
        #     # kalau data kantin ada, juga ambil menu dari kantin tsb.
        #     if data_kantin != None:
        #         sql = "SELECT * FROM kantin_menu WHERE idresto = %s"
        #         dbc.execute(sql, [id])
        #         data_menu = dbc.fetchall()
        #         data_kantin['produk'] = data_menu
        #         jsondoc = json.dumps(data_kantin)

        #         status_code = 200  # The request has succeeded
        #     else: 
        #         status_code = 404  # No resources found
        # else: status_code = 400  # Bad Request


    # ------------------------------------------------------
    # HTTP method = POST
    # ------------------------------------------------------
    # elif HTTPRequest.method == 'POST':
    #     data = json.loads(HTTPRequest.data)
    #     kantinName = data['nama']
    #     gedung = data['gedung']

    #     try:
    #         # simpan nama kantin, dan gedung ke database
    #         sql = "INSERT INTO kantin_resto (id, nama,gedung) VALUES (%s,%s,%s)"
    #         dbc.execute(sql, [id,kantinName,gedung] )
    #         db.commit()
    #         # dapatkan ID dari data kantin yang baru dimasukkan
    #         kantinID = dbc.lastrowid
    #         data_kantin = {'id':kantinID}
    #         jsondoc = json.dumps(data_kantin)

    #         # TODO: Kirim message ke order_service melalui RabbitMQ tentang adanya data kantin baru


    #         status_code = 201
    #     # bila ada kesalahan saat insert data, buat XML dengan pesan error
    #     except mysql.connector.Error as err:
    #         status_code = 409


    # ------------------------------------------------------
    # HTTP method = PUT
    # ------------------------------------------------------
    elif HTTPRequest.method == 'PUT':
        data = json.loads(HTTPRequest.data)
        id = data['id']
        nama = data['nama']
        gedung = data['gedung']

        messagelog = 'PUT id: ' + str(id) + ' | nama: ' + nama + ' | gedung: ' + gedung 
        logging.warning("Received: %r" % messagelog)

        try:
            # ubah nama kantin dan gedung di database
            sql = "UPDATE kantin_resto set nama=%s, gedung=%s where id=%s"
            dbc.execute(sql, [nama,gedung,id] )
            db.commit()

            # teruskan json yang berisi perubahan data kantin yang diterima dari Web UI
            # ke RabbitMQ disertai dengan tambahan route = 'kantin.tenant.changed'
            data_baru = {}
            data_baru['event']  = "updated_tenant"
            data_baru['id']     = id
            data_baru['nama']   = nama
            data_baru['gedung'] = gedung
            jsondoc = json.dumps(data_baru)
            publish_message(jsondoc,'kantin.tenant.changed')

            status_code = 200
        # bila ada kesalahan saat ubah data, buat XML dengan pesan error
        except mysql.connector.Error as err:
            status_code = 409


    # ------------------------------------------------------
    # HTTP method = DELETE
    # ------------------------------------------------------
    # elif HTTPRequest.method == 'DELETE':
    #     data = json.loads(HTTPRequest.data)




    # # ------------------------------------------------------
    # # Kirimkan JSON yang sudah dibuat ke client
    # # ------------------------------------------------------
    # resp = HTTPResponse()
    # if jsondoc !='': resp.response = jsondoc
    # resp.headers['Content-Type'] = 'application/json'
    # resp.status = status_code
    # return resp






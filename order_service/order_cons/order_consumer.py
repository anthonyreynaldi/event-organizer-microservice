import pika, sys, os
import mysql.connector,logging, json

sql_host = 'order_service-order_sql-1'    #nama container sql
# sql_host = 'localhost'
sql_user = 'root'
sql_pass = 'root'
# sql_pass = ''
sql_db = 'soa_order'

mq_host = 'message_broker-eo_mq-1'
# mq_host = 'localhost'
mq_exchange = 'EoEx'
mq_routing = [
    'staff.new',
    'staff.update',
    'client.new',
    'client.update',
    'order.new',
    'package.new'
]

db = mysql.connector.connect(host=sql_host, user=sql_user, password=sql_pass, database=sql_db)
dbc = db.cursor(dictionary=True)


def main():
    def insert(data, table):
        param = []
        #statement query
        sql = f"insert into {table} ("
        temp_bind = ""

        #concate column name based on key data
        for column, value in data.items():
            sql += column + ", "
            temp_bind += "%s, "
            param.append(str(value))

        #delete last , and concate the bind
        sql = sql[:-2] + f") VALUES ({temp_bind[:-2]})"

        print(sql)
        print(param)

        dbc.execute(sql, param)
        db.commit()

    def update(data, table):
        param = []
        #statement query
        sql = f"update {table} set "

        #concate column name based on key data
        for column, value in data.items():
            sql += column + "=%s, "
            param.append(str(value))

        #delete last , and concate where tablenamewhithouts_id
        sql = sql[:-2] + f" WHERE {table[:-1]}_id=%s"
        param.append(data[str(table[:-1]+"_id")])

        print(sql)
        print(param)

        dbc.execute(sql, param)
        db.commit()

    def get_message(ch, method, properties, body):
        # get mq_routing
        route_key = method.routing_key

        # Parse json data di dalam 'body' untuk mengambil data terkait event
        data = json.loads(body)

        obj, type = str(route_key).split(".")

        if (type == "new"):
            insert(data, obj+"s")

        elif (type == "update"):
            update(data, obj+"s")

        
        # # tampilkan pesan bahwa event sudah diproses
        message = str(route_key) + ' - ' + str(data)
        logging.warning("Received: %r" % message)

        # acknowledge message dari RabbitMQsecara manual yang 
        # menandakan message telah selesai diproses
        ch.basic_ack(delivery_tag=method.delivery_tag)

    # buka koneksi ke server RabbitMQ di eo_mq-1
    credentials = pika.PlainCredentials('radmin', 'rpass')
    connection = pika.BlockingConnection(pika.ConnectionParameters(mq_host, 5672, '/', credentials))
    channel = connection.channel()

    # Buat exchange dan queue
    channel.exchange_declare(exchange=mq_exchange, exchange_type='topic')
    new_queue = channel.queue_declare(queue='', exclusive=True)
    new_queue_name = new_queue.method.queue

    for routing in mq_routing:
        channel.queue_bind(exchange=mq_exchange, queue=new_queue_name, routing_key=routing)

    # Ambil message dari RabbitMQ (bila ada)
    channel.basic_qos(prefetch_count=1)
    channel.basic_consume(queue=new_queue_name, on_message_callback=get_message)
    channel.start_consuming()


if __name__ == '__main__':
    try:
        main()
    except KeyboardInterrupt:
        print('Interrupted')
        try:
            sys.exit(0)
        except SystemExit:
            os._exit(0)
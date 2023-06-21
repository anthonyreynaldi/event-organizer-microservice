import pika, sys

def publish_message(message,route):
    mq_host = 'message_broker-eo_mq-1'
    mq_host = 'localhost'
    mq_exchange = 'EoEx'

    credentials = pika.PlainCredentials('radmin', 'rpass')
    connection = pika.BlockingConnection(pika.ConnectionParameters(mq_host, 5672, '/', credentials))
    channel = connection.channel()

    # Buat exchange baru yang nantinya akan dihubungkan ke satu/lebih queue oleh consumer(s)
    channel.exchange_declare(exchange=mq_exchange, exchange_type='topic')

    # Kirimkan message ke RabbitMQ
    channel.basic_publish(exchange=mq_exchange,
                          routing_key=route, 
                          body=message, 
                          properties=pika.BasicProperties(delivery_mode=pika.spec.PERSISTENT_DELIVERY_MODE) )

    print("Sent a message: " + message)

    connection.close()
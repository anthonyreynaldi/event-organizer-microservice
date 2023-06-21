import mysql.connector

# Establish a connection to the database
cnx = mysql.connector.connect(
    host="localhost",
    user="root",
    password="",
    database="soa_client"
)

# Create a cursor object to execute queries
cursor = cnx.cursor()

# Execute a SELECT query
query = "SELECT * FROM clients"
cursor.execute(query)


# Fetch all rows as string data type
rows = cursor.fetchall()
result = []
# Get column names
column_names = [column[0] for column in cursor.description]

for row in rows:
    print(row)
    # combine value with its column name
    string_row = dict(zip(column_names, row))
    # Convert each column value to a string
    string_row = {key: str(value) for key, value in string_row.items()}
    result.append(string_row)

# Print the result
for row in result:
    print(row)

# Close the cursor and database connection
cursor.close()
cnx.close()
